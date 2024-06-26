<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>
<section class="ftco-section ftco-no-pt ftco-no-pb ftco-about-section" id="about-section">
    <div class="container-fluid">
        <div class="row d-md-flex text-wrapper">
            <?php if($this->controller->get('disposition') === 'content') : ?>
                <?php $this->inc('elements/content.php', ['title' => $this->controller->get('title'), 'content' => $this->controller->get('content')]); ?>
                <?php $this->inc('elements/image.php', ['image' => $this->controller->get('image')]); ?>
            <?php else : ?>
                <?php $this->inc('elements/image.php', ['image' => $this->controller->get('image')]); ?>
                <?php $this->inc('elements/content.php', ['title' => $this->controller->get('title'), 'content' => $this->controller->get('content')]); ?>
            <?php endif; ?>
        </div>
    </div>
</section>