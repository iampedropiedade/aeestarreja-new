<?php
namespace Application\Search\Pages;

use Application\Constants\Attributes;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption;
use Concrete\Core\Page\PageList as CorePageList;
use Concrete\Core\Search\Pagination\PaginationFactory;
use Pagerfanta\Pagerfanta;
use Concrete\Core\Http\Request;

class PageList extends CorePageList
{
    public const SORT_DATE_ASC = 'date_asc';
    public const SORT_DATE_DESC = 'date_desc';
    public const SITEMAP = 'sitemap';
    public const SORT_OPTIONS = [
        self::SORT_DATE_ASC => 'Date Ascending',
        self::SORT_DATE_DESC => 'Date Descending',
        self::SITEMAP => 'Sitemap order',
    ];

    protected $paginationPageParameter = 'page';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $sort
     * @return void
     */
    public function handleSort(string $sort): void
    {
        switch ($sort) {
            case self::SITEMAP:
                $this->sortByDisplayOrder();
                break;
            case self::SORT_DATE_ASC:
                $this->sortByPublicDate();
                break;
            case self::SORT_DATE_DESC:
            default:
                $this->sortByPublicDateDescending();
        }
    }

    /**
     * @param string $keywords
     * @return void
     */
    public function filterByFulltextKeywords($keywords): void
    {
        $this->isFulltextSearch = true;
        $this->autoSortColumns[] = 'cIndexScore';
        $this->query->addSelect('match(psi.cName, psi.cDescription, psi.content) against (:fulltext) as cIndexScore');
        $this->query->andWhere('match(psi.cName, psi.cDescription, psi.content) against (:fulltext)');
        $this->query->orderBy('cIndexScore', 'desc');
        $this->query->setParameter('fulltext', $keywords);
    }

    public function filterByExcludePageTypeHandles(array $ptHandles): void
    {
        $db = \Database::get();
        $this->query->andWhere(
            $this->query->expr()->notIn('ptHandle', array_map([$db, 'quote'], $ptHandles))
        );
    }

    public function getPaginationFactory() : Pagerfanta
    {
        $factory = new PaginationFactory(Request::createFromGlobals());
        return $factory->createPaginationObject($this);
    }

    public function filterByTags(?array $tags): void
    {
        if($tags === null || count($tags) === 0) {
            return;
        }
        $this->filterBySelectMultipleOr(Attributes::TAGS, $tags);
    }

    public function filterBySelectMultipleOr($attributeHandle, $selectIds, $like=true)
    {
        if(!is_array($selectIds) || empty($selectIds)) {
            return;
        }
        $filter = $like ? 'like' : 'notLike';
        $expressions = array();
        $em = \Database::connection()->getEntityManager();
        $repository = $em->getRepository(SelectValueOption::class);
        foreach ($selectIds as $key => $selectId) {
            $option = $repository->findOneBy(['avSelectOptionID' => $selectId]);
            $column = 'ak_' . $attributeHandle;
            $expressions[] = $this->query->expr()->{$filter}($column, ':option_' . $attributeHandle . '_' . $key);
            $this->query->setParameter('option_' . $attributeHandle . '_' . $key, "%\n" . $option->getSelectAttributeOptionValue(false) . "\n%");
        }
        if (count($expressions)) {
            $this->query->andWhere(call_user_func_array(array($this->query->expr(), 'orX'), $expressions));
        }
    }

}
