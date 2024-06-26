<?php
namespace Application\Service;

use Application\Constants\Groups;
use Application\Entity\Ticket;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Mail\Service as MailService;
use Application\Models\Page\Generic;

class TicketNotification
{
    /**
     * @param Ticket $ticket
     */
    public function notify(Ticket $ticket): void
    {
        $groupsService = new GroupsService();
        $notifyEmails = $groupsService->getUsersEmailsByGroupName(Groups::SYS_ADMINS);
        $userEmail = ($ticket->getCreator())->getUserEmail();
        $notifyEmails[$userEmail] = $userEmail;
        if (empty($notifyEmails)) {
            return;
        }
        $pagelist = new Generic();
        $pagelist->filterByPageTypeHandle('tickets_detail');
        $ticketDetailPage = $pagelist->getResults();
        $ticketDetailPage = reset($ticketDetailPage);

        $app = Application::getFacadeApplication();
        /** @var MailService $mail */
        $mail = $app->make('mail');
        $mail->to(implode(',', $notifyEmails));
        $mail->addParameter('ticket', $ticket);
        $mail->addParameter('ticketDetailPage', $ticketDetailPage);
        $mail->load('ticket_notification');
        try {
            $mail->sendMail();
        }
        catch (\Exception $exception) {
            return;
        }
    }
}