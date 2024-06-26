<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Application\Block\Columns\Controller;

$count = count($items);
$containerModifier = 'container--standard';
if($count === 1 && $items[0]['type'] === Controller::ITEM_TYPE_VIDEO) {
    $containerModifier = 'container--small';
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
        <?php if(is_array($items) && $count>0) : ?>
            <div class="row">
                <?php foreach($items as $key=>$item) : ?>
                    <div class="col-md-<?php echo $count>=3 ? '4' : '6'; ?>">
                        <div class="ftco-animate">
                            <div class="text pt-3 text-center">
                                <?php $this->inc('elements/view/' . $item['type'] . '.php', ['item' => $item, 'index'=>$key]); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif;?>
    </div>
</section>
