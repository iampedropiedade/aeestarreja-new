<?php
namespace Application\Block\ImageContent;

use Application\Blocks\Controller as BlockController;

/**
 * Class Controller
 * @package Application\Block\ImageContent
 */
class Controller extends BlockController
{
    protected $btTable = 'btImageContent';
    protected $btInterfaceWidth = '1200';
    protected $btInterfaceHeight = '900';

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders an image and content section');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('Image+Content');
    }

    public function edit()
    {
        parent::edit();
        $this->set('dispositionOptions', [
            'image'=>'Image + Content',
            'content'=>'Content + Image',
        ]);
    }

}