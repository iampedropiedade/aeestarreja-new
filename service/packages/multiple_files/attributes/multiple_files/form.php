<?php
defined('C5_EXECUTE') or die('Access Denied.');
$akID = $attributeKey->getAttributeKeyID();
/** @var \Concrete\Core\Validation\CSRF\Token $token */
?>
<script id="file-input-template-ak<?php echo $akID?>" type="text/x-jquery-tmpl">
    <div class="selected-file ui-state-default" data-fid="${fID}">
        <div title="${filename}" class="icon"></div>
        <div class="title">ID: ${filename}</div>
        <input class="fileID" type="hidden" name="akID[<?php echo $akID?>][value][]" value="${fID}"/>
        <span title="<?php echo t('Remove')?>" class="delete"><i class="fa-regular fa-trash-can"></i></span>
    </div>
</script>

<div class="multiple-files-wrapper">
    <span class="help-block">
        <?php echo t('Drag and drop to sort.'); ?>
        <?php if($akMaxFilesCount) : ?>
            <?php echo t2('Max: %s file', 'Max: %s files', $akMaxFilesCount); ?>
        <?php endif; ?>
    </span>
    <div id="multiple-files-ak<?php echo $akID?>" class="multiple-files-selected-list"></div>
</div>
<div class="button-wrapper">
	<button type="button" data-akid="<?php echo $akID?>" data-launch="file-manager" class="btn btn-sm btn-primary">
        <?php echo t('Add files'); ?>
    </button>
</div>
<script type="text/javascript">
    $(function() {
        let akID = <?php echo $akID?>;
        let token = "<?php echo $token->generate('get_files_info')?>";
        let max_count = <?php echo $akMaxFilesCount; ?>;
        let multipleFilesCurrentSelected = <?php echo json_encode($currentFilesJson); ?>;
        MultipleFilesAttribute.init(akID, multipleFilesCurrentSelected, max_count, token);
    });
</script>