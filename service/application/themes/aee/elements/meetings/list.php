<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<div class="list-group">
    <?php foreach($meetings as $meeting) : ?>
        <?php $this->inc('elements/meetings/meeting.php', ['meeting'=>$meeting]); ?>
    <?php endforeach; ?>
</div>
