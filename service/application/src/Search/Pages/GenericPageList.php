<?php
namespace Application\Search\Pages;

use Application\Constants\PageTypes;

class GenericPageList extends PageList
{
    /** @var string[] */
    protected array $pageTypeHandles = [PageTypes::PAGE];

    public function __construct()
    {
        parent::__construct();
        $this->sortByPublicDateDescending();
        $this->filterByPageTypeHandle($this->pageTypeHandles);
    }
}
