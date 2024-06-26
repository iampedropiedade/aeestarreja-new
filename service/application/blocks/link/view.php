<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<?php if($buttonLinkUrl && $caption) : ?>
<div class="container">
    <div class="u-align-center u-pv-double">
        <a href="<?php echo $buttonLinkUrl; ?>" class="button" <?php echo $target ? 'target="' . $target . '"' : ''; ?>><span class="button__text"><?php echo $caption; ?></span></a>
    </div>
</div>
<?php endif; ?>
