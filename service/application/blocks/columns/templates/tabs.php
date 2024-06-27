<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Application\Block\Columns\Controller;

$count = count($items);
$containerModifier = 'container--standard';
if($count === 1 && $items[0]['type'] === Controller::ITEM_TYPE_VIDEO) {
    $containerModifier = 'container--small';
}
if(!is_array($items) || $count === 0) {
    return;
}
$style = isset($style) ? $style : '';
?>
<section class="ftco-section bg-light <?php echo $style; ?>" id="<?php echo $anchor; ?>">
    <div class="container">
        <?php if($title) : ?>
            <div class="row justify-content-center mb-5">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading subheading__dark"><?php echo $title; ?></span>
                </div>
            </div>
        <?php endif;?>
        <nav>
            <div class="nav nav-tabs" role="tablist">
                <?php foreach($items as $key => $item) : ?>
                    <?php
                    if($item['type'] !== 'title_content') {
                        continue;
                    }
                    ?>
                    <a class="nav-item nav-link <?php echo $key === 0 ? 'active' : ''; ?>"
                       id="<?php echo sprintf('tab-%s-%s-tab', $bID, $key); ?>"
                       data-toggle="tab"
                       href="<?php echo sprintf('#tab-%s-%s', $bID, $key); ?>"
                       role="tab"
                       aria-controls="<?php echo sprintf('tab-%s-%s', $bID, $key); ?>"
                       aria-selected="<?php echo $key === 0 ? 'true' : 'false'; ?>"
                    >
                        <h5><?php echo $item['title']; ?></h5>
                    </a>
                <?php endforeach; ?>
            </div>
        </nav>
        <div class="tab-content mt-4" id="tabs-block-<?php echo $bID; ?>">
            <?php foreach($items as $key => $item) : ?>
                <?php
                if($item['type'] !== 'title_content') {
                    continue;
                }
                ?>
                <div class="tab-pane fade <?php echo $key === 0 ? 'show active' : ''; ?> cards-style-list"
                     id="<?php echo sprintf('tab-%s-%s', $bID, $key); ?>"
                     role="tabpanel"
                     aria-labelledby="<?php echo sprintf('tab-%s-%s', $bID, $key); ?>"
                >
                    <?php echo $item['content']; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>