<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-02-28
 * Time: 16:10
 */

namespace Application\Blocks;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Page\Page;
use Concrete\Core\Filesystem\FileLocator;
use Concrete\Core\Permission\Checker as PermissionChecker;
use Concrete\Core\Permission\Checker as Permissions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Controller extends BlockController
{
    use Validation;

    protected $btCacheBlockOutput = true;
    protected $btDefaultSet = 'basic';
    protected $subItems = 'items';
    protected $defaultItemType = 'content';
    protected $allowedSubItemTypes = [];
    protected $allowedItemTypes = [];
    protected $searchableFields = [];
    protected $searchableSubFields = [];
    protected $maxNumberOfItems = 100;
    protected $assetsFolder = '';


    public function on_start()
    {
        parent::on_start();
        $this->loadData();
        $this->assetsFolder = DIRNAME_CLASSES . '/Blocks';
    }

    /**
     *
     */
    public function view()
    {
        $currentPage = Page::getCurrentPage();
        if($currentPage->cID) {
            $pageView = $currentPage?->getPageController()?->getViewObject();
            $this->set('pageView', $pageView);
            $this->set('currentPage', $currentPage);
        }
    }

    /**
     *
     */
    public function add()
    {
        $this->edit();
    }

    public function edit()
    {
        $this->set('allowedItemTypes', $this->allowedSubItemTypes);
        $this->set('maxNumberOfItems', $this->maxNumberOfItems);
        $this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
    }

    /**
     * @param array $data
     */
    public function save($data)
    {
        if($this->subItems && $this->get($this->subItems)) {
            $subItems = $data[$this->subItems];
            if(\is_array($subItems)) {
                foreach($subItems as $key=>$value) {
                    if(!isset($subItems[$key]['type']) || !in_array($subItems[$key]['type'], $this->allowedSubItemTypes, true)) {
                        unset($subItems[$key]);
                    }
                }
                $data[$this->subItems] = json_encode(array_values($subItems));
            }
        }
        parent::save($data);
    }

    /**
     * @return string
     */
    public function getSearchableContent() : string
    {
        $searchableContent = [];
        if($this->searchableFields) {
            foreach($this->searchableFields as $item) {
                $searchableContent[] = $this->get($item);
            }
        }
        if($this->subItems && $this->get($this->subItems)) {
            $subItems = json_decode($this->get($this->subItems), true);
            foreach($subItems as $item) {
                foreach($item as $key=>$element) {
                    if(\in_array($key, $this->searchableSubFields, true)) {
                        $searchableContent[] = $element;
                    }
                }
            }
        }
        return implode( ' ', $searchableContent);
    }

    public function loadData()
    {
        if(!$this->subItems || $this->get($this->subItems) === null) {
            return;
        }
        if(!is_array($this->get($this->subItems))) {
            $this->set($this->subItems, json_decode($this->get($this->subItems), true));
        }
        $this->set($this->subItems, \is_array($this->get($this->subItems)) ? $this->get($this->subItems) : []);
        $this->set($this->subItems, $this->get($this->subItems));
    }

    /**
     * @param bool $data
     * @return false|string
     */
    public function action_load_list_item($data=false)
    {
        $type = isset($data['type']) ? $data['type'] : $this->get('type');
        if(!\in_array($type, $this->allowedSubItemTypes, true)) {
            $type = $this->defaultItemType;
        }
        $form = \Core::make('helper/form');
        $code = uniqid('form_', true);
        $markup = $this->includeFile('elements/form/' . $type . '.php', ['data'=>$data, 'form'=>$form, 'code'=>$code, 'type'=>$type, 'controller'=>$this, 'blockActionUrl'=>$this->get('blockActionUrl')]);
        if($this->isRequestJson()) {
            (new JsonResponse(['code' => 200, 'markup' => $markup, 'blockActionUrl'=>$this->get('blockActionUrl')], 200))->send();
            \Core::shutdown();
        }
        return $markup;
    }

    /**
     * @param $fileToInclude
     * @param array $args
     * @param bool $rootPath
     * @return string
     */
    public function includeFile($fileToInclude, array $args = [], $rootPath=false) : string
    {
        extract($args, EXTR_OVERWRITE);
        extract($this->getSets(), EXTR_OVERWRITE);
        $path = $rootPath ?: DIRNAME_BLOCKS . '/' . $this->btHandle;
        $fileLocator = \Core::make(FileLocator::class);
        $include = $fileLocator->getRecord($path . '/' . $fileToInclude);
        if(!file_exists($include->file)) {
            return '';
        }
        ob_start();
        include $include->file;
        $markup = ob_get_clean();
        return $markup;
    }

    protected function isRequestJson() : bool
    {
        $request = Request::createFromGlobals();
        return $request->headers->get('Content-Type') === 'application/json';
    }

    public function getEditAssets($view) : string
    {
        $markup = $this->includeFile('assets/edit_js.php', ['maxNumberOfItems'=>$this->maxNumberOfItems, 'view'=>$view], $this->assetsFolder);
        $markup .= $this->includeFile('assets/edit_css.php', [], $this->assetsFolder);
        return $markup;
    }

    public function getEditButtons() : string
    {
        return $this->includeFile('assets/edit_buttons.php', ['allowedItemTypes'=>$this->allowedItemTypes], $this->assetsFolder);
    }

    public function getItemTitle($title, $code, $type) : string
    {
        return $this->includeFile('assets/edit_item_title.php', ['blockItemHeaderTitle'=>$title, 'blockItemHeaderCode'=>$code, 'blockItemHeaderType'=>$type, 'blockItemHeaderController'=>$this], $this->assetsFolder);
    }

    public function getHref($pageId, $fallbackUrl=null) : string
    {
        if ($pageId) {
            $page = Page::getByID($pageId);
            if($page->cID) {
                $permissions = new PermissionChecker($page);
                if($permissions->canViewPage()) {
                    return $page->getCollectionLink();
                }
            }
        }
        if($fallbackUrl) {
            return $fallbackUrl;
        }
        return '';
    }

    protected function canEditPage() : bool
    {
        $cp = new Permissions($this->c);
        if(!$cp->canEditPageContents()) {
            return false;
        }
        return true;
    }

}
