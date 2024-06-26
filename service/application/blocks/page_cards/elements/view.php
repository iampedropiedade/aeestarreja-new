<?php
defined('C5_EXECUTE') or die('Access Denied.');
$count = count($items) <= 4 ? count($items) : 4;
?>
<div class="section <?php echo $sectionExtraClasses; ?>">
    <div class="container">
        <?php if(is_array($items) && $count>0) : ?>
            <?php if($sectionTitle) : ?>
                <div class="u-align-center">
                    <h3 class="<?php echo $sectionTitleHeadingOverrideClasses ?: 'heading--2'; ?> heading--underline heading--underline-center"><?php echo $sectionTitle; ?></h3>
                </div>
            <?php endif; ?>
            <?php if($sectionIntro) : ?>
                <h4 class="heading--4 u-align-center"><?php echo nl2br($sectionIntro); ?></h4>
            <?php endif; ?>
            <div class="slider slider--resources" data-behaviour="slider" data-type="<?php echo $dataType ?: 'resources-4'; ?>">
                <?php foreach($items as $index=>$item) : ?>
                    <?php $this->inc('elements/view/card.php', ['item'=>$item]); ?>
                <?php endforeach; ?>
            </div>
        <?php elseif($currentPage && $currentPage->isEditMode()) : ?>
            <h2 class="heading--2 heading--underline">Empty block</h2>
            <p>Please edit the block and add content.</p>
        <?php endif;?>
    </div>
</div>