<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Application\Entity\Ticket;
use Concrete\Core\Utility\Service\Text;
use Concrete\Core\Localization\Service\Date;

/** @var Ticket $ticket */
$created = $ticket->getCreatedAt();
$text = new Text();
/** @var Date $dateHelper */
$dateHelper = \Core::make('helper/date');
?>
<div class="col col-6">
    <div class="card mb-4 rounded-3 shadow-sm">
        <div class="card-header py-3">
            <h4 class="my-0 fw-normal"><?php echo $ticket->getReference(); ?> <small><span class="badge badge-<?php echo $ticket->open() ? 'warning' : 'success'; ?>"><?php echo $ticket->open() ? 'Em curso' : 'Resolvido'; ?></span></small></h4>
        </div>
        <div class="card-body">
            <h1 class="card-title pricing-card-title"><?php echo $ticket->getLocation(); ?></h1>
            <ul class="list-unstyled mt-3 mb-4">
                <li><?php echo $ticket->getDescription(); ?></li>
                <li>
                    <span class="badge badge-secondary"><?php echo $ticket->getCreatedAt()->format('d-m-Y H:i:s'); ?></span>
                    <span class="badge badge-secondary"><?php echo $ticket->getCreator()->getUserEmail(); ?></span>
                    <span class="badge badge-secondary"><?php echo t2('%s resposta', '%s respostas', count($ticket->getComments())); ?></span>
                </li>
            </ul>
            <a type="button" class="w-100 btn btn-lg btn-dark" href="<?php echo $ticketDetailPage->getCollectionLink() . '/' . $ticket->getId(); ?>">Detalhes</a>
        </div>
    </div>
</div>