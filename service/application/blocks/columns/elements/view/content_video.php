<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div class="wysiwyg">

    <?php if($item['videoPosition'] === 'above') : ?>
        <?php $pageView->inc('elements/video/player.php', ['data' => $item, 'modifierClasses'=>'video--small u-mt']); ?>
    <?php endif; ?>

    <?php echo $item['content']; ?>

    <?php if($item['videoPosition'] === 'below') : ?>
        <?php $pageView->inc('elements/video/player.php', ['data' => $item, 'modifierClasses'=>'video--small u-mt']); ?>
    <?php endif; ?>

</div>
