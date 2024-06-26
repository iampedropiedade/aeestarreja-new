<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-02-28
 * Time: 17:13
 */
use \Concrete\Core\File\File;

if($data['imageId']) {
    $image = File::getByID($data['imageId']);
}
?>
<div class="list_item sortable_item">
    <?php echo $controller->getItemTitle('Image', $code, $type); ?>
    <div class="list_item-main">
        <fieldset>
            <div class="form-group">
                <?php echo $form->label('items[<?php echo $code; ?>][imageId]', t('Image [min: 1099x617]')); ?>
                <div class="ccm-file-selector" data-file-selector="file-selector-<?php echo $code; ?>"></div>
                <script type="text/javascript">
                    $(function() {
                        $('[data-file-selector="file-selector-<?php echo $code; ?>"]').concreteFileSelector({
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
