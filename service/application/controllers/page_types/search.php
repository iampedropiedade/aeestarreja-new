<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-03-02
 * Time: 01:08
 */
namespace Application\Controller\PageType;

use Application\Constants\Attributes;
use Application\Page\Controller\PageController;
use Application\Models\Page\Generic as Model;
use Application\Search\Pages\GenericPageList;

/**
 * Class Search
 * @package Application\Controller\PageType
 */
class Search extends PageController
{

    public function view()
    {
        $query = $this->get('q');
        $this->set('query', $query);

        $this->validation->addRequired('q', 'Sem palavras para pesquisar.');
        if($query === null) {
            $this->set('searched', false);
            return false;
        }

        if(!$this->validate(false)) {
            return false;
        }
        $list = new GenericPageList();
        $list->filterByFulltextKeywords($query);
        $list->sortByPublicDateDescending();
        $pagination = $list->getPaginationFactory();
        $pagination->setCurrentPage($this->get('page', 1));
        $pagination->setMaxPerPage(self::MAX_ITEMS_PER_PAGE);
        $this->set('pagination', $pagination);
        $this->set('pages', $pagination->getCurrentPageResults());
        $this->set('searched', true);
    }

}