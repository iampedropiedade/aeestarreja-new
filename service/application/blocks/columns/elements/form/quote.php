<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-02-28
 * Time: 17:13
 */

?>
<div class="list_item sortable_item">
    <?php echo $controller->getItemTitle('Quote', $code, $type); ?>
    <div class="list_item-main">
        <fieldset>
            <div class="form-group">
                <?php echo $form->label('quote', t('Quote')); ?>
                <?php echo $form->textarea('items[' . $code . '][quote]', $data['quote'], ['rows'=>5, 'required'=>'required']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('author', t('Author')); ?>
                <?php echo $form->text('items[' . $code . '][author]', $data['author'], ['required'=>'required']); ?>
            </div>
        </fieldset>
    </div>
</div>