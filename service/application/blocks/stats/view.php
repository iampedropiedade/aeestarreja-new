<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>
<section class="ftco-counter" id="section-counter">
    <div class="container-fluid">
        <div class="row no-gutters">
            <?php if(is_array($items)) : ?>
                <?php if($title) : ?>
                    <h2 class="heading--2 heading--underline"><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php foreach($items as $index=>$item) : ?>
                    <?php $this->inc('elements/view/' . $item['type'] . '.php', ['item' => $item]); ?>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
</section>
