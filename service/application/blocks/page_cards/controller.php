<?php
namespace Application\Block\PageCards;

use Application\Blocks\Controller as BlockController;

class Controller extends BlockController
{
    protected $btTable = 'rnBtPageCards';
    protected $btInterfaceWidth = '1280';
    protected $btInterfaceHeight = '1000';
    protected $searchableFields = ['sectionTitle', 'sectionIntro'];
    protected $searchableSubFields = ['title', 'description'];
    protected $allowedSubItemTypes = ['card'];
    protected $maxNumberOfItems = 12;
    protected $requiredFields = [
        ['fieldName'=>'pageId', 'parent'=>'items', 'whenType'=>'card'],
    ];

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders a section with page cards');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('Page cards');
    }

}
