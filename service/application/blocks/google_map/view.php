<?php
defined('C5_EXECUTE') or die('Access Denied.');
$c = Page::getCurrentPage();
?>
<section class="ftco-section pt-4 pb-0">
    <?php if ($c->isEditMode()) : ?>
        <div class="container">
            <p class="pb-4"><?php echo t('Google Map disabled in edit mode.'); ?></p>
        </div>
    <?php else : ?>
        <?php if($title) : ?>
            <div class="container">
                <h2 class="pb-4"><?php echo $title; ?></h2>
            </div>
        <?php endif; ?>
        <div data-behaviour="map"
             style="width: <?php echo $width; ?>; height: <?php echo $height; ?>"
             data-zoom="<?php echo $zoom; ?>"
             data-latitude="<?php echo $latitude; ?>"
             data-longitude="<?php echo $longitude; ?>"
             data-scrollwheel="<?php echo (bool)$scrollwheel ? 'true' : 'false'; ?>"
             data-draggable="<?php echo (bool)$scrollwheel ? 'true' : 'false'; ?>"
             data-marker="<?php echo $this->getThemePath() ?>/app/images/loc.png"
        >
        </div>
    <?php endif; ?>
</section>
