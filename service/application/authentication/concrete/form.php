<?php
defined('C5_EXECUTE') or die('Access denied.');

$form = Core::make('helper/form');
$session = Core::make('session');
?>
<h4><?= t('Autenticar'); ?></h4>
<hr>
<form method="post" action="<?php echo URL::to('/login', 'authenticate', $this->getAuthenticationTypeHandle()) ?>" class="bg-light p-4 p-md-5 contact-form">
    <?php Core::make('helper/validation/token')->output('login_' . $this->getAuthenticationTypeHandle()); ?>
    <div class="form-group">
        <label class="label"><?php echo Config::get('concrete.user.registration.email_registration') ? t('Email') : t('Nome de utilizador'); ?></label>
        <input type="text" name="uName" class="form-control" placeholder="<?php echo Config::get('concrete.user.registration.email_registration') ? t('Email') : t('Username'); ?>">
    </div>
    <div class="form-group">
        <label class="label"><?php echo t('Password')?></label>
        <input type="password" name="uPassword" class="form-control" placeholder="<?php echo t('Password')?>">
    </div>
    <div class="form-group">
        <label for="uMaintainLogin" class="form__checkbox-label"><input id="uMaintainLogin" type="checkbox" class="form-control" name="uMaintainLogin"><?php echo t('Manter-me autenticado'); ?></label>
    </div>
    <div class="form-group">
        <input type="submit" value="<?php echo t('Login'); ?>" class="btn btn-primary py-3 px-5">
    </div>
    <div class="form-group">
        <a href="<?php echo URL::to('/login', 'concrete', 'forgot_password'); ?>" class="link"><?php echo t('Recuperar password'); ?></a>
    </div>
</form>
