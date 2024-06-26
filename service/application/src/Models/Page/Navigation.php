<?php
namespace Application\Models\Page;

use Concrete\Core\Page\Page;

class Navigation extends AbstractModel
{

    protected function setDefaults() : void
    {
        $this->itemsPerPage = -1;
        $this->disableAutomaticSorting();
        $this->sortByDisplayOrder();
    }

    public function getNodes($parentId=1)
    {
        $this->filterByParentID($parentId);
        $this->excludePageTypesByHandle(['news_article', 'search']);
        return $this->getResults();
    }

    public function getBreadcrumbs()
    {
        $breadcrumbs = [];
        $currentPage = Page::getCurrentPage();
        while($currentPage && $currentPage->getCollectionParentID() !== 0) {
            $breadcrumbs[] = $currentPage;
            $currentPage = Page::getById($currentPage->getCollectionParentID());
        }
        $breadcrumbs[] = Page::getById(1);
        return array_reverse($breadcrumbs);
    }

}
