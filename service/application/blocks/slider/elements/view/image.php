<?php
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Package\Picture\Picture;
use \Concrete\Core\File\File;
?>
<?php echo new Picture([[File::getByID($item['imageId']), 1099, 617]]); ?>
