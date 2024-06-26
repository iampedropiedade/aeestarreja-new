<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Application\Constants\Attributes;
use \Concrete\Core\Area\Area;

$this->inc('includes/doc_header.php');
$this->inc('includes/header.php');
$this->inc('elements/widgets/heading.php', ['headingImage' => true]);
?>
<main>
    <?php if(!$user->isRegistered() || $c->isEditMode()) : ?>
        <?php
        $a = new Area('Public only');
        $a->display($c);
        ?>
    <?php endif; ?>

    <?php
    $a = new Area('Main');
    $a->display($c);
    ?>

    <?php if($user->isRegistered() || $c->isEditMode()) : ?>
        <?php
        $a = new Area('Private only');
        $a->display($c);
        ?>
        <?php $this->inc('elements/pages/list.php', ['pages'=>$pages]); ?>
    <?php endif; ?>
</main>
<?php
$this->inc('includes/footer.php');
$this->inc('includes/doc_footer.php');
?>
