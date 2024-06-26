<?php

namespace Application\Container;

use Application\EventListener\TicketListener;
use Concrete\Core\Application\Application;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventRegistration
{
    /**
     * @param Application $application
     */
    public function registerEvents(Application $application): void
    {
        $dispatcher = $application->make(EventDispatcher::class);
        // Use text strings for event names instead of class constants - events get registered before constants class are defined

        // Ticket
        $apiListener = $application->make(TicketListener::class);
        $dispatcher->addListener('on_ticket_create', [$apiListener, 'onPostPersist']);
        $dispatcher->addListener('on_ticket_update', [$apiListener, 'onPostUpdate']);
    }

}
