<?php if (isset($error)) : ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<?php if (isset($message)) : ?>
    <div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<?php if (isset($show_email) && $show_email) : ?>
    <form action="<?= \URL::to('/login/callback/google/handle_register') ?>">
        <?php
        // It's best to show full name here for regional variations of display order of names
        if (isset($fullName) && !empty($fullName)) {?>
        <span><?= t('Register an account for "%s"', $fullName) ?></span>
        <?php  } else {
            ?>
        <span><?= t('Register an account for "%s"', $username) ?></span>
            <?php
        }?>
        <hr />
        <div class="input-group">
            <input type="email" name="uEmail" placeholder="email" class="form-control" />
            <span class="input-group-btn">
                <button class="btn btn-primary"><?= t('Register') ?></button>
            </span>
        </div>
        <?=$token->output('google_register')?>
    </form>
<?php else : ?>
    <?php if ($user->isLoggedIn()) : ?>

        <?php if (!$authenticationType->isHooked($user)) : ?>
            <h4><?= t('Attach a %s account', t('Google')); ?></h4>
            <hr>
            <div class="form-group">
                <a href="<?= \URL::to('/ccm/system/authentication/oauth2/google/attempt_attach'); ?>" class="btn btn-primary py-3 px-5">
                    <i class="fa fa-google"></i>
                    <?= t('Attach a %s account', t('Google')) ?>
                </a>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <h4><?php echo t('Autenticar com %s', t('Google')); ?></h4>
        <hr>
        <div class="bg-light p-4 p-md-5 contact-form">
            <div class="form-group">
                <a href="<?= \URL::to('/ccm/system/authentication/oauth2/google/attempt_auth'); ?>" class="btn btn-primary py-3 px-5">
                    <i class="fa-brands fa-google"></i>
                    <?= t('Log in with %s', 'Google') ?>
                </a>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<style>
    .ccm-ui .btn-google {
        border-width: 0px;
        background: #dd4b39;
    }
    .ccm-ui .btn-google:focus {
        background: #dd4b39;
    }
    .ccm-ui .btn-google:hover {
        background: #f04f3d;
    }
    .ccm-ui .btn-google:active {
        background: #c74433;
    }

    .btn-google .fa-google {
        margin: 0 6px 0 3px;
    }
</style>
