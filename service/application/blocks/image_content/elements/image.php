<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\File\File;
use Concrete\Package\Picture\Adapter\ImageCow\ImageCow;

$image = (new ImageCow(File::getById($imageId), 1272, 600))->zoomCrop();
?>
<div class="one-half img" style="background-image: url('<?php echo $image; ?>');"></div>