<?php
namespace Application\Models\Entity;

use Concrete\Package\Meetings\Entity\Meeting as Entity;
use Datetime;

class Meetings extends AbstractModel
{

    protected function setEntity() : void
    {
        $this->entity = Entity::class;
    }

    public function sortByStartTimeDesc()
    {
        $this->sortBy('e.startTimestamp', 'desc');
    }

    public function sortByCreatedTimeDesc()
    {
        $this->sortBy('e.createdAt', 'desc');
    }

    public function filterByDay(DateTime $date)
    {
        $startDay = clone $date;
        $endDay = clone $date;
        $startDay->setTime(0,0);
        $endDay->setTime(23,59);
        $this->query->andWhere('e.startTimestamp >= :startDayTS')->setParameter('startDayTS', $startDay->getTimestamp());
        $this->query->andWhere('e.startTimestamp <= :endDayTS')->setParameter('endDayTS', $endDay->getTimestamp());
    }


}
