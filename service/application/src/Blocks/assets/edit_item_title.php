<div class="list_item-title sort_handle">
    <h3><?php echo $blockItemHeaderTitle; ?></h3>
    <div class="form-group form-group-control-buttons">
        <button class="btn btn-sm btn-success" type="button" data-behaviour="item-list-expand-item"><i class="fa fa-angle-double-down"></i></button>
        <button class="btn btn-sm btn-danger" type="button" data-behaviour="item-list-remove-item"><i class="fa fa-trash"></i></button>
        <input type="hidden" name="items[<?php echo $blockItemHeaderCode; ?>][type]" value="<?php echo $blockItemHeaderType; ?>" />
    </div>
</div>