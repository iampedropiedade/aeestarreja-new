<?php
namespace Application\EventListener;

use Application\Entity\Ticket;
use Application\Service\TicketNotification;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Concrete\Core\Application\Application;
use Symfony\Component\EventDispatcher\GenericEvent;

class TicketListener
{
    /** @var Application */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function onPostPersist(GenericEvent $event): void
    {
        $entity = $event->getSubject();
        if(!($entity instanceof Ticket)) {
            return;
        }
        /** @var Ticket $entity */
        $ticketNotificationService = new TicketNotification();
        $ticketNotificationService->notify($entity);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function onPostUpdate(GenericEvent $event): void
    {
        $entity = $event->getSubject();
        if(!($entity instanceof Ticket)) {
            return;
        }
        /** @var Ticket $entity */
        $ticketNotificationService = new TicketNotification();
        $ticketNotificationService->notify($entity);
    }

}