<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Application\Entity\Ticket;
use Concrete\Core\User\UserInfo;
use Concrete\Core\Page\Page;

/** @var Ticket $ticket  */
/** @var Page $ticketDetailPage */

$subject = $ticket->getReference();
ob_start();
?>
<h4>Ticket <?php echo $ticket->getReference(); ?></h4>
<p>
    <?php echo $ticket->getCreatedAt()->format('d-m-Y H:i:s'); ?><br/>
    <?php if($ticket->open()) : ?>
        <strong>Em curso</strong>
    <?php else : ?>
        <strong>Resolvido</strong>
    <?php endif; ?>
</p>
<p><?php echo $ticket->getDescription(); ?></p>
<p><?php echo $ticket->getLocation(); ?></p>

<?php if(!empty($ticket->getComments())) : ?>
    <h6>Comentários</h6>
    <?php foreach($ticket->getComments() as $comment) : ?>
        <?php $user = UserInfo::getByID($comment['userId']); ?>
        <p>
            <?php echo $comment['comment']; ?><br/>
            <strong><?php echo $user->getUserEmail(); ?></strong><br/>
            <small><?php echo $comment['date']->format('d-m-Y H:i:s'); ?></small>
        </p>
    <?php endforeach; ?>
<?php endif; ?>

<p>
    <a href="<?php echo $ticketDetailPage->getCollectionLink() . '/' . $ticket->getId(); ?>">Ver detalhes</a>
<p>
<?php
$bodyHTML = ob_get_clean();