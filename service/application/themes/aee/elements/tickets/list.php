<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div class="row mb-3 text-center">
    <?php foreach($tickets as $ticket) : ?>
        <?php $this->inc('elements/tickets/ticket.php', ['ticket'=>$ticket, 'ticketDetailPage'=>$ticketDetailPage]); ?>
    <?php endforeach; ?>
</div>