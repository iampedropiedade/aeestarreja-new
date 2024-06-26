<?php
namespace Application\Controller\PageType;

use Application\Constants\Attributes;
use Application\Page\Controller\PageController;
use Application\Models\Page\Articles as Model;
use Application\Search\Pages\NewsArticles;

/**
 * Class NewsIndex
 * @package Application\Controller\PageType
 */
class NewsIndex extends PageController
{
    public function view()
    {
        $tagsList = (new Attributes())->getSelectUsedOptions(Attributes::TAGS, true);
        $tagsList = ['' => 'Mostrar todas as tags'] + $tagsList;
        $this->set('tagsList', $tagsList);

        $tags = $this->get('tags', []);
        $this->set('tags', $tags);

        $list = new NewsArticles();
        $list->filterBySelectMultipleOr(Attributes::TAGS, $tags);
        $list->sortByPublicDateDescending();
        $pagination = $list->getPaginationFactory();
        $pagination->setCurrentPage($this->get('page', 1));
        $pagination->setMaxPerPage(self::MAX_ITEMS_PER_PAGE);
        $this->set('pagination', $pagination);
        $this->set('newsArticles', $pagination->getCurrentPageResults());
    }

}