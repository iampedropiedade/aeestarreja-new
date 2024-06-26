<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<fieldset>
    <div class="form-group">
        <?php echo $form->label('rootPath', t('Base folder')); ?>
		<?php echo $form->text('rootPath', $rootPath, ['required'=>'required']); ?>
	</div>
    <div class="form-group">
        <?php echo $form->label('sort', t('Sort')); ?>
		<?php echo $form->select('sort', $sortList, $sort, ['required'=>'required']); ?>
	</div>
    <div class="form-group">
        <label><input type="checkbox" name="clear_cache" value="true"> <?php echo t('Clear cache'); ?></label>
	</div>		
</fieldset>