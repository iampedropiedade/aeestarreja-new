<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
use Application\Entity\Ticket;

class TicketRepository extends EntityRepository
{

    /**
     * @return Ticket
     */
    public function findOneByIdAndUser($id, $user): Ticket
    {
        /** @var Ticket $ticket */
        $ticket = $this->findOneBy(['id'=>$id, 'creator'=>$user]);
        return $ticket;
    }

    /**
     * @return Ticket[]
     */
    public function findAllByUser($user) : array
    {
        return $this->findBy(['creator'=>$user]);
    }

}