<?php
namespace Application\Controller\PageType;

use Application\Models\Page\Model;
use Application\Page\Controller\PageController;
use Application\Constants\Attributes;

/**
 * Class PageTypeList
 * @package Application\Controller\PageType
 */
class PageTypeList extends PageController
{
    public function view()
    {
        $model = new Model();
        $model->filterByPageTypeHandle($this->c->getAttribute(Attributes::SELECTED_PAGE_TYPE_HANDLE));
        $pages = $model->getResults();
        $paginationData = $model->getPaginationData();
        $this->set('pages', $pages);
        $this->set('paginationData', $paginationData);
    }

}