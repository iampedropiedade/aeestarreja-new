<?php
namespace Application\Block\Link;

use Application\Blocks\Controller as BlockController;
use Concrete\Core\Page\Page;
use Concrete\Core\File\File;

class Controller extends BlockController
{
    protected $btTable = 'rnBtLink';
    protected $btInterfaceWidth = '900';
    protected $btInterfaceHeight = '500';
    protected $searchableFields = ['caption'];
    protected $requiredFields = [
        ['fieldName'=>'caption']
    ];

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders a Link');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('Link');
    }

    public function view()
    {
        $buttonLinkUrl = null;
        $target = null;
        if($this->linkToPageId) {
            $page = Page::getByID($this->linkToPageId);
            if ($page instanceof Page) {
                $buttonLinkUrl = $page->getCollectionLink();
            }
        }
        elseif($this->linkToFileId) {
            $file = File::getByID($this->linkToFileId);
            if ($file) {
                $target = '_blank';
                $buttonLinkUrl = $file->getVersion()->getDownloadURL();
            }
        }
        elseif($this->linkToUrl) {
            $target = '_blank';
            $buttonLinkUrl = $this->linkToUrl;
        }
        $this->set('target', $target);
        $this->set('buttonLinkUrl', $buttonLinkUrl);
    }
}
