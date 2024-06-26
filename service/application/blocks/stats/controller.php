<?php
namespace Application\Block\Stats;

use Application\Blocks\Controller as BlockController;

class Controller extends BlockController
{
    protected $btTable = 'btStats';
    protected $btInterfaceWidth = '1280';
    protected $btInterfaceHeight = '1000';
    protected $searchableFields = ['title'];
    protected $allowedSubItemTypes = ['stat'];
    protected $defaultItemType = 'stat';
    protected $searchableSubFields = ['text'];
    protected $maxNumberOfItems = 6;
    protected $requiredFields = [
        ['fieldName'=>'value', 'parent'=>'items', 'whenType'=>'stat'],
        ['fieldName'=>'text', 'parent'=>'items', 'whenType'=>'stat'],
        ['fieldName'=>'icon', 'parent'=>'items', 'whenType'=>'stat'],
    ];

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders a section with stats');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('Stats');
    }

}