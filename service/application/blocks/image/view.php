<?php
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Core\Support\Facade\Application;
use \Concrete\Core\File\File;

$app = Application::getFacadeApplication();

/** @var File $f */
if (!is_object($f) || !$f->getFileID()) {
    return;
}
$image = $app->make('html/image', [$f]);
$tag = $image->getTag();
$tag->alt($altText ? h($altText) : '');
$tag->addClass('mx-auto d-block img-fluid');
if ($title) {
    $tag->title(h($title));
}

?>
<section class="ftco-section py-4">
    <div class="container img-fluid">
        <?php if ($linkURL) : ?>
            <a href="<?php echo $linkURL; ?>" <?php echo ($openLinkInNewWindow ? 'target="_blank"' : ''); ?>>
        <?php endif; ?>

        <?php echo $tag; ?>

        <?php if ($linkURL) : ?>
            </a>
        <?php endif; ?>
    </div>
</section>