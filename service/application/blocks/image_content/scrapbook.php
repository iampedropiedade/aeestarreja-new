<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\File\File;
use Concrete\Package\Picture\Picture;
?>
<div class="clipboard-overwrite">
    <div class="grid grid--2-col">
        <div class="grid__item">
            <?php echo new Picture([[File::getByID($imagePos1Id), 160, 90]]); ?>
        </div>
        <div class="grid__item">
            <?php echo new Picture([[File::getByID($imagePos2Id), 160, 90]]); ?>
        </div>
    </div>
</div>
