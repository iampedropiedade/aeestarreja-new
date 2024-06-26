<?php

namespace Application\Search\Pages;

use Application\Constants\PageTypes;

class NewsArticles extends GenericPageList
{
    /** @var string[] */
    protected array $pageTypeHandles = [PageTypes::NEWS_ARTICLE];

    public function __construct()
    {
        parent::__construct();
        $this->sortByPublicDateDescending();
    }
}
