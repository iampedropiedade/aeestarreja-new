<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-02-28
 * Time: 17:13
 */
use \Concrete\Core\Form\Service\Widget\PageSelector;
use \Concrete\Core\File\File;

$ps = new PageSelector();

if($data['imageId']) {
    $image = File::getByID($data['imageId']);
}
?>
<div class="list_item sortable_item">
    <?php echo $controller->getItemTitle('Page card', $code, $type); ?>
    <div class="list_item-main">
        <fieldset>
            <div class="form-group">
                <?php echo $form->label('items[' . $code . '][pageId]', t('Link to page')); ?>
                <?php echo $ps->selectPage('items[' . $code . '][pageId]', $data['pageId']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('title', t('Title (defaults to page title)')); ?>
                <?php echo $form->text('items[' . $code . '][title]', $data['title']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('description', t('Description (defaults to page description)')); ?>
                <?php echo $form->textarea('items[' . $code . '][description]', $data['description'], ['rows'=>4]); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('imageId', t('Image (defaults to main page image) [min: 1024x573]')); ?>
                <div class="ccm-file-selector" data-file-selector="file-selector<?php echo $code; ?>"></div>
                <script type="text/javascript">
                    $(function() {
                        $('[data-file-selector="file-selector<?php echo $code; ?>"]').concreteFileSelector({
                            'inputName': 'items[<?php echo $code; ?>][imageId]',
                            'filters': [{"field":"type","type":1}],
                            <?php echo ($image ? 'fID: ' . $image->getFileID() . ',' : ''); ?>
                            'chooseText': "<?php echo t('Please select an image'); ?>"
                        });
                    });
                </script>
            </div>
        </fieldset>
    </div>
</div>