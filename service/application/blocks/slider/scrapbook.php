<?php
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Package\Picture\Picture;
use \Concrete\Core\File\File;

$count = count($items);
?>
<div class="clipboard-overwrite">
    <div class="grid">
        <?php if(is_array($items) && $count>0) : ?>
            <?php foreach($items as $index=>$item) : ?>
                <div class="grid__item">
                    <?php echo new Picture([[File::getByID($item['imageId']), 50, 50]]); ?>
                </div>
            <?php endforeach; ?>
        <?php endif;?>
    </div>
</div>
