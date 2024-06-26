<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\File\File;
use Concrete\Core\Entity\File\File as FileEntity;
use Concrete\Core\Page\Page;

$target = '_blank';
if(($file = File::getByID($item['fileId'])) instanceof FileEntity) {
    $url = $file->getVersion()->getDownloadURL();
}
else if(($page = Page::getByID($item['pageId'])) instanceof Page && $page->cID) {
    $url = $page->getCollectionLink();
    $target = '_self';
}
else {
    $url = $item['url'];
}
?>
<p>
    <?php if ($url) : ?>
        <a href="<?php echo $url; ?>">
    <?php endif; ?>
    <?php echo $item['title']; ?>
    <?php if ($url) : ?>
        </a>
    <?php endif; ?>
    <?php if ($item['label']) : ?>
        <span class="badge badge-info"><?php echo ($item['label']); ?></span>
    <?php endif; ?>
    <?php if ($item['description']) : ?>
        <br /><small><?php echo nl2br($item['description']); ?></small>
    <?php endif; ?>
</p>
