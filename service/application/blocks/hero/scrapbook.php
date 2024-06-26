<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\Utility\Service\Text;
$text = new Text();
?>
<div class="clipboard-overwrite">
    <h4><?php echo $title; ?></h4>
    <h6><?php echo $subtitle; ?></h6>
    <p><?php echo $text->shortenTextWord($content, 50); ?></p>
</div>
