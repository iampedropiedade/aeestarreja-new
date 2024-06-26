<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div class="container container--xtrim">
    <form method="post" action="<?php echo $view->action('save'); ?>" enctype="multipart/form-data" class="bg-light p-4 p-md-5 contact-form" data-parsley>
        <?php $valt->output('profile_edit'); ?>
        <div class="form-group">
            <label class="label">Email</label>
            <p><?php echo $email; ?></p>
        </div>
        <div class="form-group">
            <label class="label" for="<?php echo $userData['name']['field']; ?>">Nome</label>
            <input class="form-control" type="text" id="<?php echo $userData['name']['field']; ?>" name="<?php echo $userData['name']['field']; ?>" value="<?php echo $userData['name']['value']; ?>">
        </div>
        <div class="form-group">
            <button class="btn btn-primary u-mb" name="action" value="save" type="submit"><span class="button__text">Atualizar</span></button>
        </div>
    </form>
</div>