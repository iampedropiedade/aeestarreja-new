<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\Editor\CkeditorEditor;
use Application\Entity\Ticket as TicketEntity;
use Concrete\Core\User\User;
use Concrete\Core\User\UserInfo;

/** @var CkeditorEditor $editor */
/** @var ?TicketEntity $ticket */

$this->inc('includes/doc_header.php');
$this->inc('includes/header.php');
$this->inc('elements/widgets/heading.php', ['headingImage' => true]);
?>
<main>
    <?php $this->inc('elements/widgets/errors.php', ['errors' => $errors]); ?>


    <section class="ftco-section py-5">
        <div class="container">

            <?php if($ticket) : ?>

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
                    </div>
                </div>

                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                        <h4 class="my-0 fw-normal">Comentários</h4>
                    </div>
                    <div class="card-body">
                        <?php if(!empty($ticket->getComments())) : ?>
                            <?php foreach($ticket->getComments() as $comment) : ?>
                                <li class="list-group-item">
                                    <p><?php echo $comment['comment']; ?></p>
                                    <p>
                                        <span class="badge badge-secondary"><?php echo $comment['date']->format('d-m-Y H:i:s'); ?></span>
                                        <span class="badge badge-secondary"><?php echo ($ticket->getCreator())->getUserEmail(); ?></span>
                                    </p>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if($ticket->open()) : ?>
                            <form action="<?php echo $view->action('comment'); ?>" class="pt-4 contact-form" method="post" data-behaviour='parsley-validate'>
                                <input type="hidden" name="token" value="<?php echo $token->generate($tokenAction); ?>">
                                <input type="hidden" name="ticket[id]" value="<?php echo $ticket->getId(); ?>">
                                <div class="form-group">
                                    <label for="meeting[comment]">Novo comentário</label>
                                    <textarea class="form-control form-control-lg" name="ticket[comment]" rows="8"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meeting[closed]"><input type="checkbox" name="ticket[close]" value="true"> Marcar como resolvido</label>

                                </div>
                                <div class="form-group mt-5">
                                    <input type="submit" value="Submeter" class="btn btn-primary py-3 px-5">
                                </div>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>

            <?php else : ?>
                <form action="<?php echo $view->action('submit'); ?>" class="pt-4 contact-form" method="post" data-behaviour='parsley-validate'>
                    <input type="hidden" name="token" value="<?php echo $token->generate($tokenAction); ?>">
                    <div class="form-group">
                        <label for="ticket[location]">Local</label>
                        <p><small>Exemplo: Sala A3</small></p>
                        <input type="text" class="form-control form-control-lg" name="ticket[location]" value="<?php echo $postData['location'] ?: ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="meeting[content]">Descrição</label>
                        <p><small>Exemplo: O computador 5 não liga</small></p>
                        <textarea class="form-control form-control-lg" name="ticket[description]" rows="8"><?php echo $postData['description'] ?: ''; ?></textarea>
                    </div>
                    <div class="form-group mt-5">
                        <input type="submit" value="Submeter" class="btn btn-primary py-3 px-5">
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php
$this->inc('includes/footer.php');
$this->inc('includes/doc_footer.php');
?>
