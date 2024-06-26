<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\Form\Service\Form;
/** @var Form $form */
?>
<style>
    .ccm-ui .form-control.custom-select2 {
        border: none;
        padding: 0;
    }
</style>
<fieldset>
    <div class="form-group">
        <?php echo $form->label('title', t('Main title')); ?>
        <?php echo $form->text('title', $title, ['required'=>'required']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('subtitle', t('Heading')); ?>
        <?php echo $form->text('subtitle', $subtitle); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('intro', t('Intro')); ?>
        <?php echo \Core::make('editor')->outputStandardEditor('intro', $intro); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('maxItems', t('Max articles')); ?>
        <?php echo $form->number('maxItems', $maxItems ?? 6); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('handle', t('Section handle')); ?>
        <?php echo $form->text('handle', $handle); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('buttonCaption', t('Button caption override')); ?>
        <?php echo $form->text('buttonCaption', $buttonCaption); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('style', t('Style')); ?>
        <?php echo $form->select('style', ['white'=>'White section', 'light'=>'Light gray section', 'dark'=>'Dark gray section'], $style); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('tags', t('Display articles with the following tag only')); ?>
        <?php echo $form->selectMultiple('tags', $tagsList, $tags, ['data-behaviour'=>'select2', 'class'=>'custom-select2']); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label('tagsFilterOut', t('Do not display articles with the following tag')); ?>
        <?php echo $form->selectMultiple('tagsFilterOut', $tagsList, $tagsFilterOut, ['data-behaviour'=>'select2', 'class'=>'custom-select2']); ?>
    </div>
</fieldset>
<script>
    $(document).ready(function() {
        $("[data-behaviour='select2']").select2();
    });
</script>