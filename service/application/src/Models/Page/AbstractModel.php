<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-03-06
 * Time: 13:57
 */
namespace Application\Models\Page;

use \Application\Page\PageList;
use \Concrete\Core\Search\Pagination\PaginationFactory;
use \Concrete\Core\Page\Page;
use \Pagerfanta\Pagerfanta;
use \Symfony\Component\HttpFoundation\Request;
use \Application\Constants\Attributes;

/**
 * Class AbstractModel
 * @package Application\Models\Page
 */
abstract class AbstractModel extends PageList
{
    protected static $modelIndexPageTypeHandle;
    protected $modelPageType;
    protected $paginationContent;
    protected $paginationPageParameter = 'page';

    protected const COMPARISON_EQUAL = '=';
    protected const COMPARISON_EQUAL_MORE_THAN = '>=';
    protected const COMPARISON_LESS_THAN = '<';

    abstract protected function setDefaults() : void;

    public function __construct()
    {
        parent::__construct();
        $this->setDefaults();
        $this->applyDefaults();
    }

    protected function applyDefaults() : void
    {
        if($this->modelPageType) {
            $this->filterByPageTypeHandle($this->modelPageType);
        }
    }

    public function getPagedResults()
    {
        $pagination = $this->getPaginationFactory();
        return $pagination->getCurrentPageResults();
    }

    public function getPaginationData() : array
    {
        $data = [];
        $pagination = $this->getPaginationFactory();
        if($pagination) {
            $data = [
                'currentPage'=>$pagination->getCurrentPage(),
                'previousPage'=>$pagination->hasPreviousPage() ? $pagination->getPreviousPage() : false,
                'nextPage'=>$pagination->hasNextPage() ? $pagination->getNextPage() : false,
                'totalPages'=>$pagination->getNbPages(),
                'totalResults'=>$pagination->getNbResults(),
                'offsetStart'=>$pagination->getCurrentPageOffsetStart(),
                'offsetEnd'=>$pagination->getCurrentPageOffsetEnd(),

            ];
        }
        return $data;
    }

    /**
     * @return \Pagerfanta\Pagerfanta
     */
    public function getPaginationFactory() : Pagerfanta
    {
        if(!$this->paginationContent) {
            $factory = new PaginationFactory(Request::createFromGlobals());
            $this->paginationContent = $factory->createPaginationObject($this);
        }
        return $this->paginationContent;
    }

    public function applyFilters($filters) : bool
    {
        if(!is_array($filters)) {
            return false;
        }
        foreach ($filters as $filterName => $filterValue) {
            if($filterValue) {
                $this->filterByAttribute($filterName, $filterValue, $comparison = '=');
            }
        }
        return true;
    }

    public function filterByAttribute($handle, $value, $comparison = '=')
    {
        if(!$value) {
            return false;
        }
        $attribute = new Attributes();
        $attributeKey = $attribute->getAttributeKeyByHandle($handle);
        if(!$attributeKey) {
            return false;
        }
        if($attributeKey->getAttributeTypeHandle() === 'select') {
            $akController = $attributeKey->getController();
            if($akController) {
                $value = $akController->getOptionById($value);
            }
        }
        parent::filterByAttribute($handle, $value, $comparison);
    }

    /**
     * @param $modelIndexPageTypeHandle
     * @return mixed
     */
    public static function getIndexPageByHandle($modelIndexPageTypeHandle)
    {
        $model = new Generic();
        $model->filterByPageTypeHandle($modelIndexPageTypeHandle);
        $pages = $model->getResults();
        return reset($pages);
    }

    public function setItemsPerPage($itemsPerPage)
    {
        parent::setItemsPerPage($itemsPerPage);
    }

    public static function getIndexPage()
    {
        return self::getIndexPageByHandle(self::$modelIndexPageTypeHandle);
    }

}
