<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-02-28
 * Time: 17:13
 */
?>
<div class="list_item sortable_item">
    <?php echo $controller->getItemTitle('Stat', $code, $type); ?>
    <div class="list_item-main">
        <small>Please notice that for stat items to be on the same column they need to be sequential. If there's other types between 2 stat items, stats will be on different columns.</small>
        <fieldset>
            <div class="form-group">
                <?php echo $form->label('items[' . $code . '][icon]', t('Icon')); ?>
                <?php echo $form->select('items[' . $code . '][icon]', $iconsList, $data['icon'], ['required'=>'required']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('items[' . $code . '][heading]', t('Heading')); ?>
                <?php echo $form->text('items[' . $code . '][heading]', $data['heading'], ['required'=>'required']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('items[' . $code . '][copy]', t('Text')); ?>
                <?php echo $form->textarea('items[' . $code . '][copy]', $data['copy'], ['rows'=>5, 'required'=>'required']); ?>
            </div>
        </fieldset>
    </div>
</div>