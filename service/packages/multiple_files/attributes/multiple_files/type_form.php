<?php
defined('C5_EXECUTE') or die('Access Denied.');
assert(isset($form, $controller));
?>
<fieldset>
	<legend><?php echo t('Multiply Files Options')?></legend>
    <div class="form-group">
        <label class="control-label"><?php echo t('Max number of files (0 for no limit)'); ?></label>
        <div class="controls">
        	<?php echo $form->number('akMaxFilesCount', $controller->get('$akMaxFilesCount')); ?>
        </div>
    </div>
</fieldset>