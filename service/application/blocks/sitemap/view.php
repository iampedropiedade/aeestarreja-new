<?php
defined('C5_EXECUTE') or die('Access Denied.');
if(!$sitemapPageList || !is_array($sitemapPageList)) {
    return false;
}
?>
<div class="section">
    <div class="container">
        <?php $this->inc('elements/level.php', ['sitemapPageList' => $sitemapPageList]); ?>
    </div>
</div>