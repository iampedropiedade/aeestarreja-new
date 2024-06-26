<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>
<section class="pb_section pb-0 bg-<?php echo $style; ?>" id="services">
    <div class="container">
        <div class="box">
            <?php if ($icon) : ?>
                <div class="icon"><a href=""><i class="fa <?php echo $icon; ?>"></i></a></div>
            <?php endif;?>
            <?php if ($sectionTitle) : ?>
                <h4 class="title mb4"><?php echo $sectionTitle; ?></h4>
            <?php endif;?>
            <?php if ($sectionIntro) : ?>
                <p><?php echo nl2br($sectionIntro); ?></p>
            <?php endif;?>
            <?php if(is_array($items) && count($items) > 0) : ?>
                <div class="description">
                    <?php foreach($items as $index=>$item) : ?>
                        <?php $this->inc('elements/view/card.php', ['item'=>$item, 'style'=>$style]); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif;?>
        </div>
    </div>
</section>
