<?php
defined('C5_EXECUTE') or die('Access Denied.');

use \Concrete\Core\Form\Service\Widget\PageSelector;
use Concrete\Core\Application\Service\FileManager;

$ps = new PageSelector();
$al = new FileManager();
?>
<fieldset>
    <div class="form-group">
        <?php echo $form->label('subtitle', t('Heading')); ?>
        <?php echo $form->text('subtitle', $subtitle, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('title', t('Main title')); ?>
        <?php echo $form->text('title', $title, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('content', t('Content')); ?>
        <?php echo \Core::make('editor')->outputStandardEditor('content', $content, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('backgroundImageFileId', t('Background image')); ?>
        <?php echo $al->image('backgroundImageFileId', 'backgroundImageFileId', t('Please select an image'), $backgroundImageFileId, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('buttonCaption', t('Button caption')); ?>
        <?php echo $form->text('buttonCaption', $buttonCaption); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('buttonLinkToPageId', t('Link to an internal page (priority: 1)')); ?>
        <?php echo $ps->selectPage('buttonLinkToPageId', $buttonLinkToPageId); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('buttonLinkToFileId', t('Link to a file (priority: 2)')); ?>
        <?php echo $al->file('buttonLinkToFileId', 'buttonLinkToFileId', t('Please select a file'), $buttonLinkToFileId); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('buttonLinkToUrl', t('Link to an external URL or section #ID (priority: 3)')); ?>
        <?php echo $form->text('buttonLinkToUrl', $buttonLinkToUrl); ?>
    </div>
</fieldset>
