<?php defined('C5_EXECUTE') or die("Access Denied.");

$responsiveClass = 'youtubeBlockResponsive16by9';
$sizeDisabled = '';

if (isset($vWidth) && $vWidth && isset($vHeight) && $vHeight) {
    $sizeargs = 'width="' . $vWidth . '" height="' . $vHeight . '"';
    $sizeDisabled = 'style="width:' . $vWidth . 'px; height:' . $vHeight . 'px"';
    $responsiveClass = '';
} elseif ($sizing === '4:3') {
    $responsiveClass = 'youtubeBlockResponsive4by3';
}

$params = array();

if (isset($playlist) && $playlist) {
    $params[] = 'playlist='. $playlist;
    $videoID = '';
}

if (isset($playListID) && $playListID) {
    $params[] = 'listType=playlist';
    $params[] = 'list=' . $playListID;
}

if (isset($autoplay) && $autoplay) {
    $params[] = 'autoplay=1';
}

if (isset($color) && $color) {
    $params[] = 'color=' . $color;
}

if (isset($controls) && $controls != '') {
    $params[] = 'controls=' . $controls;
}

$params[] = 'hl=' . Localization::activeLanguage();

if (isset($iv_load_policy) && $iv_load_policy > 0) {
    $params[] = 'iv_load_policy=' . $iv_load_policy;
}

if (isset($loopEnd) && $loopEnd) {
    $params[] = 'loop=1';
    if (!isset($playlist) && $videoID !== '') {
        $params[] = 'playlist='.$videoID;
    }
}

if (isset($modestbranding) && $modestbranding) {
    $params[] = 'modestbranding=1';
}

if (isset($rel) && $rel) {
    $params[] = 'rel=1';
} else {
    $params[] = 'rel=0';
}

if (isset($showinfo) && $showinfo) {
    $params[] = 'showinfo=1';
} else {
    $params[] = 'showinfo=0';
}

if (!empty($startSeconds)) {
    $params[] = 'start=' . $startSeconds;
}

$paramstring = '?' . implode('&', $params);
?>
<?php if (Page::getCurrentPage()->isEditMode()) : ?>
    <?php
    $loc = Localization::getInstance();
    $loc->pushActiveContext(Localization::CONTEXT_UI);
    ?>
    <section class="ftco-section py-5">
        <div class="container">
            <div class="row">
                <div class="ccm-edit-mode-disabled-item embed-responsive embed-responsive-16by9">
                    <div><?php echo t('YouTube Video disabled in edit mode.'); ?></div>
                </div>
            </div>
        </div>
    </section>
    <?php $loc->popActiveContext(); ?>
<?php else : ?>
    <section class="ftco-section py-5">
        <div class="container">
            <div class="row">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" <?php echo $sizeargs ?? ''; ?> src="//<?= $youtubeDomain; ?>/embed/<?= $videoID;?><?= $paramstring;?>" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
