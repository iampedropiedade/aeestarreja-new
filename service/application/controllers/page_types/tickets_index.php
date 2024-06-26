<?php
namespace Application\Controller\PageType;

use Application\Page\Controller\PageController;
use Application\Models\Entity\Tickets as Model;
use Application\Models\Page\Generic;
use Concrete\Core\Entity\User\User as UserEntity;
use Concrete\Core\User\User;
use Application\Permissions\Permissions;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TicketsIndex
 * @package Application\Controller\PageType
 */
class TicketsIndex extends PageController
{
    protected $entityManager;
    protected $user;
    protected $userInfo;
    protected $userEntity;

    public function on_start()
    {
        parent::on_start();
        $this->entityManager = $this->app->make(EntityManagerInterface::class);
        $this->user = new User();
        if($this->user->uID) {
            $this->userInfo = $this->user->getUserInfoObject();
            $this->userEntity = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['uID' => $this->user->uID]);
        }
    }

    public function view()
    {
        $filters = $this->clearEmptyParams($this->request('filters'));
        $this->set('filters', $filters);
        $model = new Model();
        if (!(new Permissions())->canViewAllTickets()) {
            $model->getQueryObject()->andWhere('e.creator=:creator')->setParameter('creator', $this->userEntity);
        }
        $model->sortByCreatedTimeDesc();
        $pagination = $model->getPaginationFactory();
        $this->set('tickets', $model->getPagedResults());
        $this->set('pagination', $pagination);
        $this->set('addTicket', true);

        $pagelist = new Generic();
        $pagelist->filterByPageTypeHandle('tickets_detail');
        $ticketDetailPage = reset($pagelist->getResults());
        $this->set('ticketDetailPage', $ticketDetailPage);
    }
}