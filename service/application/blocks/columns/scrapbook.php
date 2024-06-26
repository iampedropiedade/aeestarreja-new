<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\Utility\Service\Text;
$text = new Text();
?>
<div class="clipboard-overwrite">
    <h4><?php echo $title; ?></h4>
    <?php foreach($items as $index=>$item) : ?>
        <?php if($item['type'] === 'content' || $item['type'] === 'contentvideo') : ?>
            <p><?php echo $text->shortenTextWord($item['content'], 50); ?></p>
        <?php elseif($item['type'] === 'quote') : ?>
            <p><?php echo $text->shortenTextWord($item['quote'], 50); ?></p>
        <?php elseif($item['type'] === 'video') : ?>
            <p><?php echo t('Video'); ?></p>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
