<?php
namespace Application\Block\Sitemap;

use Application\Blocks\Controller as BlockController;
use Concrete\Core\Page\Template as PageTemplate;
use Concrete\Core\Page\Type\Type as PageType;
use Application\Models\Page\Generic as Model;

class Controller extends BlockController
{
    protected $btTable = 'rnBtSitemap';
    protected $btInterfaceWidth = '900';
    protected $btInterfaceHeight = '550';
    protected $requiredFields = [
        ['fieldName'=>'rootPageId'],
    ];

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders a Sitemap');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('Sitemap');
    }

    public function view()
    {
        $this->set('sitemapPageList', $this->getSitemapPageList($this->rootPageId));
    }

    public function save($data)
    {
        $data['excludedPageTypes'] = json_encode($data['excludedPageTypes']);
        $data['excludedPageTemplates'] = json_encode($data['excludedPageTemplates']);
        parent::save($data);
    }

    public function add()
    {
        $this->edit();
    }

    public function on_start()
    {
        $this->excludedPageTypes = json_decode($this->excludedPageTypes, true);
        $this->excludedPageTemplates = json_decode($this->excludedPageTemplates, true);
        $this->set('excludedPageTypes', $this->excludedPageTypes);
        $this->set('excludedPageTemplates', $this->excludedPageTemplates);
    }

    public function edit()
    {
        parent::edit();
        $this->set('pageTypesOptions', $this->getPageTypesList());
        $this->set('pageTemplatesOptions', $this->getPageTemplatesList());
        $this->requireAsset('css', 'select2');
        $this->requireAsset('javascript', 'select2');
    }

    /**
     * @return array
     */
    public function getPageTypesList(): array
    {
        $pageTypesList = [];
        $pageTypes = PageType::getList();
        foreach ($pageTypes as $ct) {
            $pageTypesList[$ct->ptHandle] = $ct->ptName;
        }
        asort($pageTypesList);
        return $pageTypesList;
    }

    /**
     * @return array
     */
    public function getPageTemplatesList(): array
    {
        $pageTemplatesList = [];
        $pageTemplates = PageTemplate::getList();
        foreach ($pageTemplates as $pt) {
            $pageTemplatesList[$pt->pTemplateID] = $pt->pTemplateName;
        }
        asort($pageTemplatesList);
        return $pageTemplatesList;
    }

    public function getSitemapPageList($rootPageId): array
    {
        $sitemapPageList = [];
        $model = new Model();
        $model->excludePageTypesByHandle($this->excludedPageTypes);
        $model->excludePageTemplatesById($this->excludedPageTemplates);
        $model->filterByParentID($rootPageId);
        $model->sortByDisplayOrder();
        $pages = $model->getResults();

        foreach($pages as $page) {
            $item = [];
            $item['page'] = $page;
            $item['children'] = $this->getSitemapPageList($page->getCollectionId());
            $sitemapPageList[] = $item;
        }
        return $sitemapPageList;
    }


}
