<?php
namespace Application\Block\Hero;

use Application\Blocks\Controller as BlockController;
use Concrete\Core\File\File;
use Concrete\Core\Page\Page;

class Controller extends BlockController
{
    protected $btTable = 'btHero';
    protected $btInterfaceWidth = '1200';
    protected $btInterfaceHeight = '900';

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders a Hero section');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('Hero');
    }

    public function view()
    {
        parent::view();
        $buttonLink = null;
        $target = '';
        if($this->buttonLinkToPageId) {
            $page = Page::getByID($this->buttonLinkToPageId);
            if ($page instanceof Page) {
                $buttonLink = $page->getCollectionLink();
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
    }

}
