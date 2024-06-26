<?php
use \Concrete\Core\Form\Service\Widget\PageSelector;
use \Concrete\Core\File\File;

$ps = new PageSelector();

if($data['fileId']) {
    $file = File::getByID($data['fileId']);
}
?>
<div class="list_item sortable_item">
    <?php echo $controller->getItemTitle('Page card', $code, $type); ?>
    <div class="list_item-main">
        <fieldset>
            <div class="form-group">
                <?php echo $form->label('title', t('Title')); ?>
                <?php echo $form->text('items[' . $code . '][title]', $data['title'], ['required'=>'required']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('description', t('Description')); ?>
                <?php echo $form->textarea('items[' . $code . '][description]', $data['description'], ['rows'=>2]); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('label', t('Label')); ?>
                <?php echo $form->text('items[' . $code . '][label]', $data['label']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('items[' . $code . '][pageId]', t('Link to internal page')); ?>
                <?php echo $ps->selectPage('items[' . $code . '][pageId]', $data['pageId']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('fileId', t('Link to file')); ?>
                <div class="ccm-file-selector" data-file-selector="file-selector<?php echo $code; ?>"></div>
                <script type="text/javascript">
                    $(function() {
                        $('[data-file-selector="file-selector<?php echo $code; ?>"]').concreteFileSelector({
                            'inputName': 'items[<?php echo $code; ?>][fileId]',
                            <?php echo ($file ? 'fID: ' . $file->getFileID() . ',' : ''); ?>
                            'chooseText': "<?php echo t('Please select a file'); ?>"
                        });
                    });
                </script>
            </div>
            <div class="form-group">
                <?php echo $form->label('items[' . $code . '][url]', t('Link to external URL')); ?>
                <?php echo $form->text('items[' . $code . '][url]', $data['url'], ['placeholder'=>'http://']); ?>
            </div>
        </fieldset>
    </div>
</div>