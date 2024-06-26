<?php
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Core\Form\Service\Widget\PageSelector;
use Concrete\Core\Application\Service\FileManager;

$ps = new PageSelector();
$al = new FileManager();
?>
<fieldset>
    <div class="form-group">
        <?php echo $form->label('caption', t('Link caption')); ?>
        <?php echo $form->text('caption', $caption, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('linkToPageId', t('Link to an internal page (priority: 1)')); ?>
        <?php echo $ps->selectPage('linkToPageId', $linkToPageId); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('linkToFileId', t('Link to a file (priority: 2)')); ?>
        <?php echo $al->file('linkToFileId', 'linkToFileId', t('Please select a file'), $linkToFileId); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('linkToUrl', t('Link to an external URL (priority: 3)')); ?>
        <?php echo $form->text('linkToUrl', $linkToUrl); ?>
    </div>
</fieldset>
