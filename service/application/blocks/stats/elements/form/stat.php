<div class="list_item sortable_item">
    <?php echo $controller->getItemTitle('Stat', $code, $type); ?>
    <div class="list_item-main">
        <fieldset>
            <div class="form-group">
                <?php echo $form->label('items[' . $code . '][icon]', t('Icon')); ?>
                <?php echo $form->text('items[' . $code . '][icon]', $data['icon'], ['required'=>'required']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('items[' . $code . '][value]', t('Value')); ?>
                <?php echo $form->text('items[' . $code . '][value]', $data['value'], ['required'=>'required']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('items[' . $code . '][text]', t('Text')); ?>
                <?php echo $form->text('items[' . $code . '][text]', $data['text'], ['required'=>'required']); ?>
            </div>
        </fieldset>
    </div>
</div>