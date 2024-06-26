<?php
namespace Application\Block\Columns;

use Application\Blocks\Controller as BlockController;

class Controller extends BlockController
{
    public const ITEM_TYPE_CONTENT = 'content';
    public const ITEM_TYPE_TITLE_CONTENT = 'title_content';
    public const ITEM_TYPE_VIDEO = 'video';
    public const ITEM_TYPE_QUOTE = 'quote';
    public const ITEM_TYPE_CONTENT_VIDEO = 'content_video';
    public const ITEM_TYPE_STAT = 'stat';
    public const ITEM_TYPE_IMAGE = 'image';

    protected $btTable = 'btColumns';
    protected $btInterfaceWidth = '1280';
    protected $btInterfaceHeight = '1000';
    protected $allowedSubItemTypes = [
        self::ITEM_TYPE_CONTENT,
        self::ITEM_TYPE_TITLE_CONTENT,
        self::ITEM_TYPE_VIDEO,
        self::ITEM_TYPE_QUOTE,
        self::ITEM_TYPE_CONTENT_VIDEO,
        self::ITEM_TYPE_STAT,
        self::ITEM_TYPE_IMAGE,
    ];
    protected $searchableFields = ['title'];
    protected $searchableSubFields = ['content', 'quote', 'author', 'title', 'heading', 'copy'];
    protected $maxNumberOfItems = 4;
    protected $requiredFields = [
        ['fieldName'=>'content', 'parent'=>'items', 'whenType'=>'content'],
        ['fieldName'=>'content', 'parent'=>'items', 'whenType'=>'title_content'],
        ['fieldName'=>'title', 'parent'=>'items', 'whenType'=>'title_content'],
        ['fieldName'=>'content', 'parent'=>'items', 'whenType'=>'content_video'],
        ['fieldName'=>'videoId', 'parent'=>'items', 'whenType'=>'content_video'],
        ['fieldName'=>'posterImageId', 'parent'=>'items', 'whenType'=>'content_video', 'validationType'=>'image'],
        ['fieldName'=>'videoId', 'parent'=>'items', 'whenType'=>'video'],
        ['fieldName'=>'posterImageId', 'parent'=>'items', 'whenType'=>'video', 'validationType'=>'image'],
        ['fieldName'=>'quote', 'parent'=>'items', 'whenType'=>'quote'],
        ['fieldName'=>'author', 'parent'=>'items', 'whenType'=>'quote'],
        ['fieldName'=>'heading', 'parent'=>'items', 'whenType'=>'stat'],
        ['fieldName'=>'copy', 'parent'=>'items', 'whenType'=>'stat'],
        ['fieldName'=>'icon', 'parent'=>'items', 'whenType'=>'stat'],
        ['fieldName'=>'imageId', 'parent'=>'items', 'whenType'=>'image'],
    ];

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders a section with 1-6 colunms');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('Columns');
    }

    public function on_start()
    {
        parent::on_start();
    }

    public function edit()
    {
        parent::edit();
        $this->set('gridGutterOptions', [''=>'Default', 'grid--gutter-small'=>'Small', 'grid--gutter-medium'=>'Medium', 'grid--gutter-middle'=>'Middle', 'grid--gutter-wide'=>'Wide']);
    }

    public function view()
    {
        parent::view();
        $this->countGrid();
    }

    public function countGrid()
    {
        $items = $this->get($this->subItems);
        $count = count($items);
        $gridCount = 0;
        for($i=0; $i<$count; $i++) {
            $item = $items[$i];
            if($item['type'] === 'stat' && isset($items[$i-1]) && $items[$i-1]['type'] === 'stat') {
                continue;
            }
            $gridCount++;
        }
        $this->set('gridCount', $gridCount);
    }

}