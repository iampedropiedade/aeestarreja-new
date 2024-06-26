<?php
defined('C5_EXECUTE') or die('Access Denied.');
$c = Page::getCurrentPage();
?>
<section class="ftco-section py-5">
    <div class="container">
        <?php if(!$content && is_object($c) && $c->isEditMode()) : ?>
            <div class="ccm-edit-mode-disabled-item"><?=t('Empty Content Block.')?></div>
        <?php else : ?>
            <?php echo $content; ?>
        <?php endif; ?>
    </div>
</section>