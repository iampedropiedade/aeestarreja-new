<?php
namespace Application\Block\ContentCards;

use Application\Blocks\Controller as BlockController;
use Concrete\Core\File\File;
use Concrete\Core\Page\Page;

class Controller extends BlockController
{
    protected $btTable = 'rnBtContentCards';
    protected $btInterfaceWidth = '1280';
    protected $btInterfaceHeight = '1000';
    protected $searchableFields = ['sectionTitle', 'sectionIntro'];
    protected $searchableSubFields = ['title', 'description'];
    protected $allowedSubItemTypes = ['card'];
    protected $requiredFields = [
        ['fieldName'=>'pageId', 'parent'=>'items', 'whenType'=>'card'],
    ];

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders a section with content cards');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('Content cards');
    }

    public function view()
    {
        parent::view();
        $buttonLink = null;
        $buttonCaption = $this->buttonCaption;
        $target = '';
        if($this->buttonLinkToPageId) {
            $page = Page::getByID($this->buttonLinkToPageId);
            if ($page instanceof Page) {
                $buttonLink = $page->getCollectionLink();
                if(!$buttonCaption) {
                    $buttonCaption = $page->getCollectionName();
                }
            }
        }
        elseif($this->buttonLinkToFileId) {
            $file = File::getByID($this->buttonLinkToFileId);
            if ($file) {
                $target = '_blank';
                $buttonLink = $file->getVersion()->getDownloadURL();
            }
        }
        elseif($this->buttonLinkToUrl) {
            $buttonLink = $this->buttonLinkToUrl;
        }
        $this->set('target', $target);
        $this->set('buttonLink', $buttonLink);
        $this->set('buttonCaption', $buttonCaption);
    }

}
