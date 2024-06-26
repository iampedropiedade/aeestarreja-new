<?php

namespace Application\Page;

use Concrete\Core\Page\PageList as CorePageList;
use \Doctrine\DBAL\Connection;

/**
 * Class PageList
 * @package Application\Page
 */
class PageList extends CorePageList
{

    public function filterByPageIds($ids, $exclude=false) : void
    {
        if(!$ids || empty($ids)) {
            return;
        }
        $operator = $exclude ? ' NOT IN ' : ' IN ';
        $pageIds = is_array($ids) ? $ids : [$ids];
        $this->query->andWhere('p.cID ' . $operator . ' (:pageIds)')->setParameter('pageIds', $pageIds, Connection::PARAM_INT_ARRAY);
    }

    /**
     * Filters keyword fields by keywords (including name, description, content, and attributes) but page title will be most relevant when sorting
     * @param $keywords
     */
    public function filterByFulltextKeywordsAndTitle($keywords) : void
    {
        $sortExpression = $this->query->expr()->like('psi.cName', ':keywords');
        $this->isFulltextSearch = true;
        $this->autoSortColumns[] = 'cIndexScore';
        $this->query->addSelect('MATCH(psi.cName, psi.cDescription, psi.content) AGAINST (:fulltext) AS cIndexScore');
        $this->query->where('MATCH(psi.cName, psi.cDescription, psi.content) AGAINST (:fulltext)');
        $this->query->orderBy($sortExpression, 'DESC');
        $this->query->addOrderBy('cIndexScore', 'DESC');
        $this->query->setParameter('fulltext', $keywords);
        $this->query->setParameter('keywords', '%' . $keywords . '%');
    }


    /**
     * @param $pageTypeHandles
     */
    public function excludePageTypesByHandle($pageTypeHandles) : void
    {
        if($pageTypeHandles && !is_array($pageTypeHandles)) {
            $pageTypeHandles = [$pageTypeHandles];
        }
        if(!empty($pageTypeHandles)) {
            $this->query->andWhere('ptHandle NOT IN (:pageTypeHandles)')->setParameter('pageTypeHandles', $pageTypeHandles, Connection::PARAM_STR_ARRAY);
        }
    }

    /**
     * @param $pageTemplateIds
     */
    public function excludePageTemplatesById($pageTemplateIds) : void
    {
        if($pageTemplateIds && !is_array($pageTemplateIds)) {
            $pageTemplateIds = [$pageTemplateIds];
        }
        if(!empty($pageTemplateIds)) {
            $this->query->andWhere('cv.pTemplateID NOT IN (:pageTemplateIds)')->setParameter('pageTemplateIds', $pageTemplateIds, Connection::PARAM_INT_ARRAY);
        }
    }
}