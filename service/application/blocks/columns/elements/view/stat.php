<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>
<div class="stat" data-entrance>
    <div class="stat__icon a-fade-pop">
        <?php echo $item['icon']; ?>
    </div>
    <p class="stat__content">
        <span class="stat__percentage">
            <?php echo $item['heading']; ?>
        </span>
        <span class="stat__copy">
            <?php echo nl2br($item['copy']); ?>
        </span>
    </p>
</div>