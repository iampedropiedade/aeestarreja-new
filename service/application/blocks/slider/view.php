<?php
defined('C5_EXECUTE') or die('Access Denied.');
$count = count($items);
?>
<div class="section">
    <div class="container">
        <?php if(is_array($items) && $count>0) : ?>
            <div class="slider" data-behaviour="slider">
                <?php foreach($items as $index=>$item) : ?>
                    <div class="grid__item">
                        <?php $this->inc('elements/view/' . $item['type'] . '.php', ['item' => $item, 'index'=>$index]); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif($currentPage && $currentPage->isEditMode()) : ?>
            <h2 class="heading--2 heading--underline">Empty block</h2>
            <p>Please edit the block and add content.</p>
        <?php endif;?>
    </div>
</div>
