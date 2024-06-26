<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-02-28
 * Time: 17:13
 */
use \Concrete\Core\File\File;
if($data['posterImageId']) {
    $image = File::getByID($data['posterImageId']);
}
?>
<div class="list_item sortable_item">
    <?php echo $controller->getItemTitle('Content + Video', $code, $type); ?>
    <div class="list_item-main">
        <fieldset>
            <legend><?php echo t('Content'); ?></legend>
            <div class="form-group">
                <?php echo \Core::make('editor')->outputStandardEditor('items[' . $code . '][content]', $data['content'], ['required'=>'required']); ?>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo t('Video'); ?></legend>
            <div class="form-group">
                <?php echo $form->label('title', t('Title')); ?>
                <?php echo $form->text('items[' . $code . '][title]', $data['title']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('brightcoveVideoId', t('Brightcove video ID')); ?>
                <?php echo $form->text('items[' . $code . '][brightcoveVideoId]', $data['brightcoveVideoId'], ['required'=>'required']); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('posterImageId', t('Poster image [min: 1261x709]')); ?>
                <div class="ccm-file-selector" data-file-selector="file-selector<?php echo $code; ?>"></div>
                <script type="text/javascript">
                    $(function() {
                        $('[data-file-selector="file-selector<?php echo $code; ?>"]').concreteFileSelector({
                            'inputName': 'items[<?php echo $code; ?>][posterImageId]',
                            'filters': [{"field":"type","type":1}],
                            <?php echo ($image ? 'fID: ' . $image->getFileID() . ',' : ''); ?>
                            'chooseText': "<?php echo t('Please select an image'); ?>"
                        });
                    });
                </script>
            </div>
            <div class="form-group">
                <?php echo $form->label('items[' . $code . '][videoPosition]', t('Video position')); ?>
                <?php echo $form->select('items[' . $code . '][videoPosition]', ['below'=>'Below content', 'above'=>'Above content'], $data['videoPosition']); ?>
            </div>
        </fieldset>
    </div>
</div>