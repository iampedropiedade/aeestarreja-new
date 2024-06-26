<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\Utility\Service\Text;
$text = new Text();
?>
<div class="clipboard-overwrite">
    <h4><?php echo $sectionTitle; ?></h4>
    <p><?php echo $text->shortenTextWord($sectionIntro, 50); ?></p>
    <p><?php echo t2('%s items', '%s items', count($items)); ?></p>
</div>
