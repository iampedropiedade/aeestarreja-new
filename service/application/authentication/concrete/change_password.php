<?php
defined('C5_EXECUTE') or die('Access denied.');

$_error = array();
if (isset($error)) {
    if ($error instanceof Exception) {
        $_error[] = $error->getMessage();
    } elseif ($error instanceof \Concrete\Core\Error\Error) {
        if ($error->has()) {
            $_error = $error->getList();
        }
    } else {
        $_error = $error;
    }
}
?>
<h4>Recuperar password</h4>
<p>Para recuperar a sua password introduza a nova password nos campos abaixo</p>
<form method="post" action="<?= URL::to('/login', 'callback', $authType->getAuthenticationTypeHandle(), 'change_password', $uHash) ?>" class="bg-light p-4 p-md-5 contact-form" data-parsley>
    <?php if(!empty($_error)) : ?>
        <?php View::element('system_errors', array('error' => $_error)); ?>
    <?php endif; ?>
    <div class="form-group">
        <input type="password" name="uPassword" placeholder="<?php echo t('New Password') ?>" class="form-control" autocomplete="off" required />
    </div>
    <div class="form-group">
        <input type="password" name="uPasswordConfirm" placeholder="<?php echo t('Confirm New Password') ?>" class="form-control" autocomplete="off" required />
    </div>
    <div class="form-group">
        <button name="resetPassword" class="btn btn-sm py-3 px-5 btn-primary"><span class="button__text"><?php echo t('Change password and sign in'); ?></span></button>
    </div>
</form>

