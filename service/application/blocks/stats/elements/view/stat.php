<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>
<div class="col justify-content-center counter-wrap ftco-animate">
    <div class="block-18 text-center py-5">
        <div class="text">
            <div class="icon d-flex justify-content-center align-items-center">
                <?php echo $item['icon']; ?>
            </div>
            <strong class="number" data-number="<?php echo $item['value']; ?>">0</strong>
            <span><?php echo $item['text']; ?></span>
        </div>
    </div>
</div>
