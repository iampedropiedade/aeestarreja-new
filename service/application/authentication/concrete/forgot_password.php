<?php defined('C5_EXECUTE') or die('Access denied.'); ?>

<form method="post" action="<?php echo URL::to('/login', 'callback', $authType->getAuthenticationTypeHandle(), 'forgot_password'); ?>"  class="bg-light p-4 p-md-5 contact-form" data-parsley>
    <?php $token->output(); ?>
    <h3 class="heading--3"><?php echo t('Forgot Your Password?') ?></h3>
    <div class="u-mb">
        <?php echo isset($intro_msg) ? $intro_msg : '' ?>
    </div>
    <div class="u-mb">
        <p><?php echo t('Enter your email address below. We will send you instructions to reset your password.'); ?></p>
    </div>
    <div class="form-group">
        <input name="uEmail" type="email" placeholder="<?php echo t('Email Address') ?>" class="form-control" required />
    </div>
    <div class="form-group">
        <button name="resetPassword" class="btn btn-sm btn-primary py-3 px-5"><span class="button__text"><?php echo t('Recuperar password'); ?></span></button>
    </div>
    <div class="form-group">
        <p><a href="<?php echo URL::to('/login'); ?>" class="link"><?php echo t('Voltar à página de login'); ?></a></p>
    </div>
</form>
