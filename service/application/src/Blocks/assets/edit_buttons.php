<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div class="btn-group">
    <?php foreach($allowedItemTypes as $itemType) : ?>
        <button class="btn btn-sm btn-default" type="button" data-behaviour="item-list-add-item" data-item-type="<?php echo $itemType; ?>">
            <?php echo t('Add %s', ucwords(implode(' + ', explode('_', $itemType)))); ?>
        </button>
    <?php endforeach; ?>
</div>