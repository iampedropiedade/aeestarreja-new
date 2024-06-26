<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-02-28
 * Time: 17:13
 */

?>
<div class="list_item sortable_item">
    <?php echo $controller->getItemTitle('Content', $code, $type); ?>
    <div class="list_item-main">
        <fieldset>
            <div class="form-group">
                <?php echo \Core::make('editor')->outputStandardEditor('items[' . $code . '][content]', $data['content'], ['required'=>'required']); ?>
            </div>
        </fieldset>
    </div>
</div>