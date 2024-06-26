<?php
namespace Application\Models\Entity;

use Application\Entity\Ticket as Entity;
use Datetime;

class Tickets extends AbstractModel
{

    protected function setEntity() : void
    {
        $this->entity = Entity::class;
    }

    public function sortByCreatedTimeDesc()
    {
        $this->sortBy('e.createdAt', 'desc');
    }

}
