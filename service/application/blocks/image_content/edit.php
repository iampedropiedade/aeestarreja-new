<?php 
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\Application\Service\FileManager;
$al = new FileManager();
?>
<fieldset>
    <div class="form-group">
        <?php echo $form->label('imageId', t('Image')); ?>
        <?php echo $al->image('imageId', 'imageId', t('Please select an image'), $imageId, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('title', t('Title')); ?>
        <?php echo $form->text('title', $title, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('content', t('Content')); ?>
        <?php echo \Core::make('editor')->outputStandardEditor('content', $content, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('disposition', t('Options')); ?>
        <?php echo $form->select('disposition', $dispositionOptions, $disposition, ['required'=>'required']); ?>
    </div>
</fieldset>