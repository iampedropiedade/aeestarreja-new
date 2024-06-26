<?php

namespace Application\Models\Entity;

use Concrete\Core\Search\ItemList\EntityItemList as CoreEntityItemList;
use Concrete\Core\Search\Pagination\Pagination;
use Concrete\Core\Search\Pagination\PaginationFactory;
use Concrete\Package\Meetings\Entity\Meeting;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractModel
 * @package Application\Models\Entity
 */

abstract class AbstractModel extends CoreEntityItemList
{

    /** @var EntityManager */
    private $entityManager;
    protected $entity;
    protected $paginationContent;
    protected $paginationPageParameter = 'page';

    /**
     * EntityItemList constructor.
     * @param EntityManager|null $em
     */
    public function __construct(EntityManager $em = null)
    {
        $this->entityManager = $em ?: \ORM::entityManager();
        $this->setEntity();
        parent::__construct();
    }

    abstract protected function setEntity() : void;

    /**
     * @param $row
     * @return null|object
     */
    public function getResult($row)
    {
        return $this->getEntityManager()->getRepository($this->entity)->find($row->getId());
    }

    /**
     * @param $id
     * @return Form|null
     */
    public function getResultById($id) : ?Meeting
    {
        return $this->getEntityManager()->getRepository($this->entity)->find($id);
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function createQuery()
    {
        $this->query = $this->getEntityManager()->getRepository($this->entity)->createQueryBuilder('e');
    }

    public function setQuery($q): self
    {
        $this->query = $q;
        return $this;
    }

    /**
     * @return int|mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalResults()
    {
        return $this->query->select('count(e.id)')->getQuery()->getSingleScalarResult();
    }

    /**
     * @return Pagination
     */
    public function getPagination()
    {
        return new Pagination($this, new DoctrineORMAdapter($this->getQueryObject()));
    }

    public function getPaginationData(): array
    {
        $data = [];
        $pagination = $this->getPaginationFactory();
        if ($pagination) {
            $data = [
                'currentPage' => $pagination->getCurrentPage(),
                'previousPage' => $pagination->hasPreviousPage() ? $pagination->getPreviousPage() : false,
                'nextPage' => $pagination->hasNextPage() ? $pagination->getNextPage() : false,
                'totalPages' => $pagination->getNbPages(),
                'totalResults' => $pagination->getNbResults(),
                'offsetStart' => $pagination->getCurrentPageOffsetStart(),
                'offsetEnd' => $pagination->getCurrentPageOffsetEnd(),

            ];
        }
        return $data;
    }

    /**
     * @return \Pagerfanta\Pagerfanta
     */
    public function getPaginationFactory(): Pagerfanta
    {
        if (!$this->paginationContent) {
            $request = Request::createFromGlobals();
            $factory = new PaginationFactory(Request::createFromGlobals());
            $this->paginationContent = $factory->createPaginationObject($this);
            $this->paginationContent->setCurrentPage($request->get($this->paginationPageParameter, 1));
        }
        return $this->paginationContent;
    }

    public function getPagedResults()
    {
        $pagination = $this->getPaginationFactory();
        return $pagination->getCurrentPageResults();
    }
}

