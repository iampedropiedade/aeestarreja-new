<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Application\Constants\Attributes;
use Concrete\Core\Page\Page;

if(!$pages || empty($pages)) {
    return;
}
/** var Page $page; */
?>

<section class="ftco-section py-5">
    <div class="container">
        <div class="row">
            <?php foreach($pages as $page): ?>
                <?php $this->inc('elements/pages/page.php', ['page'=>$page]); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>


