<?php 
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Core\Form\Service\Widget\PageSelector;
$ps = new PageSelector();
?>
<fieldset>
    <div class="form-group">
        <?php echo $form->label('rootPageId', t('Root page')); ?>
        <?php echo $ps->selectPage('rootPageId', $rootPageId, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('excludedPageTypes', t('Excluded page types')); ?>
        <select multiple="" data-placeholder="<?php echo t('Please select page types or leave empty for all pages types...'); ?>" name="excludedPageTypes[]" id="excludedPageTypes" style="width: 100%">
            <?php foreach($pageTypesOptions as $key=>$option) : ?>
                <option value="<?php echo $key; ?>"<?php echo (is_array($excludedPageTypes) && in_array($key, $excludedPageTypes, false) ? ' selected' : ''); ?>><?php echo $option; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <?php echo $form->label('excludedPageTemplates', t('Excluded page templates')); ?>
        <select multiple="" data-placeholder="<?php echo t('Please select page templates or leave empty for all page templates...'); ?>" name="excludedPageTemplates[]" id="excludedPageTemplates" style="width: 100%">
            <?php foreach($pageTemplatesOptions as $key=>$option) : ?>
                <option value="<?php echo $key; ?>"<?php echo (is_array($excludedPageTemplates) && in_array($key, $excludedPageTemplates, true) ? ' selected' : ''); ?>><?php echo $option; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</fieldset>
<script>
    $(function() {
        $("[name='excludedPageTypes[]']").select2();
        $("[name='excludedPageTemplates[]']").select2();
    });
</script>