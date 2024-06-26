<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>
<fieldset>
    <div class="form-group">
        <?php echo $form->label('heading', t('Heading')); ?>
        <?php echo $form->text('heading', $heading, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('title', t('Title')); ?>
        <?php echo $form->text('title', $title, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('address', t('Address')); ?>
        <?php echo $form->textarea('address', $address, ['required'=>'required', 'rows'=>5]); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('phone', t('Phone')); ?>
        <?php echo $form->text('phone', $phone, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('email', t('Email')); ?>
        <?php echo $form->text('email', $email, ['required'=>'required']); ?>
    </div>
</fieldset>
