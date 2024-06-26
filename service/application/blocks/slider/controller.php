<?php
namespace Application\Block\Slider;

use Application\Blocks\Controller as BlockController;

class Controller extends BlockController
{
    protected $btTable = 'rnBtSlider';
    protected $btInterfaceWidth = '1280';
    protected $btInterfaceHeight = '1000';
    protected $allowedSubItemTypes = ['image'];
    protected $requiredFields = [
        ['fieldName'=>'imageId', 'parent'=>'items', 'whenType'=>'image'],
    ];

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders a slider');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('Slider');
    }

}