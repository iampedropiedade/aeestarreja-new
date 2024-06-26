<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\Utility\Service\Text;
$text = new Text();
?>
<div class="clipboard-overwrite">
    <?php foreach($items as $index=>$item) : ?>
        <?php if($item['type'] === 'stat') : ?>
            <p><strong><?php echo $item['heading']; ?></strong> <?php echo $text->shortenTextWord($item['copy'], 50); ?></p>
        <?php elseif($item['type'] === 'images') : ?>
            <p><strong><?php echo t('Images item'); ?></strong></p>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
