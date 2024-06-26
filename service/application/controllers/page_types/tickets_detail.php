<?php
namespace Application\Controller\PageType;

use Application\Page\Controller\PageController;
use Concrete\Core\Entity\User\User as UserEntity;
use Concrete\Core\Routing\Redirect as RoutingRedirect;
use Concrete\Core\User\User;
use Concrete\Core\Page\Page;
use Concrete\Core\Validation\CSRF\Token;
use Application\Entity\Ticket as TicketEntity;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TicketsDetail
 * @package Application\Controller\PageType
 */
class TicketsDetail extends PageController
{
    public const TOKEN_ACTION = 'tickets_form_submit';
    protected $entityManager;
    protected $user;
    protected $userInfo;
    protected $userEntity;
    protected $group;
    protected $postData;

    public function on_start()
    {
        parent::on_start();
        $this->entityManager = $this->app->make(EntityManagerInterface::class);
        $this->user = new User();
        if($this->user->uID) {
            $this->userInfo = $this->user->getUserInfoObject();
            $this->userEntity = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['uID' => $this->user->uID]);
        }
        $this->set('token', new Token());
        $this->set('tokenAction', self::TOKEN_ACTION);
        $this->postData = $this->post('ticket');
        $this->set('postData', $this->postData);
    }

    public function view($ticketId=0)
    {
        $this->entityManager = $this->app->make(EntityManagerInterface::class);
        if ($ticketId !== 0) {
            $ticket = $this->entityManager->getRepository(TicketEntity::class)->findOneByIdAndUser($ticketId, $this->user);
            if($ticket) {
                $this->set('ticket', $ticket);
            }
            else {
                return RoutingRedirect::to(Page::getById($this->c->getCollectionParentID()));
            }
        }
    }

    public function submit()
    {
        if(!$this->validateSubmission()) {
            $this->set('error', $this->error);
            $this->view();
            return;
        }
        if($this->save()) {
            return RoutingRedirect::to(Page::getById($this->c->getCollectionParentID()));
        }
    }

    public function comment()
    {
        /** @var ?TicketEntity $ticket */
        $ticket = $this->entityManager->getRepository(TicketEntity::class)->findOneByIdAndUser($this->postData['id'], $this->user);
        if(!$this->validateComment($ticket)) {
            $this->set('error', $this->error);
            $this->view($this->postData['id']);
            return;
        }
        if(trim($this->postData['comment'])) {
            $ticket->addComment(trim($this->postData['comment']), $this->user->uID);
        }
        if($this->postData['close'] === 'true') {
            $ticket->close();
        }
        $this->entityManager->persist($ticket);
        $this->entityManager->flush();
        if($ticket->open()) {
            return RoutingRedirect::to(Page::getById($this->c->cID)->getCollectionLink() . '/' . $this->postData['id']);
        }
        else {
            return RoutingRedirect::to(Page::getById($this->c->getCollectionParentID()));
        }
    }

    protected function save()
    {
        $entity = new TicketEntity();
        $entity->setCreator($this->userEntity);
        $entity->setDescription($this->postData['description']);
        $entity->setLocation($this->postData['location']);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return true;
    }

    protected function validateSubmission() : bool
    {
        if(!$this->user || !$this->userInfo) {
            $this->error->add(t('A sessão expirou, por favor autentique-se de novo.'));
        }
        if(!$this->postData['location']) {
            $this->error->add(t('O local é um campo obrigatório.'));
        }
        if(!$this->postData['description']) {
            $this->error->add(t('A descrição é um campo obrigatório.'));
        }
        $this->set('errors', $this->error);
        if($this->error->has()) {
            return false;
        }

        return true;
    }

    protected function validateComment($ticket) : bool
    {
        if($ticket === null) {
            $this->error->add(t('Ticket inválido.'));
        }
        if(!$this->user || !$this->userInfo) {
            $this->error->add(t('A sessão expirou, por favor autentique-se de novo.'));
        }
        if(!$this->postData['comment'] && $this->postData['close'] !== 'true') {
            $this->error->add(t('O comentário é um campo obrigatório.'));
        }
        $this->set('errors', $this->error);
        if($this->error->has()) {
            return false;
        }

        return true;
    }


}