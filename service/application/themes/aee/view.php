<?php
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Core\Area\Area;
$this->inc('includes/doc_header.php');
$this->inc('includes/header.php');
$this->inc('elements/widgets/heading.php', ['headingImage' => true]);
?>
<main>
    <?php
    $a = new Area('Top');
    $a->display($c);
    ?>

    <section class="ftco-section bg-light">
        <div class="container">
            <?php
            View::element('system_errors', [
                'format' => 'block',
                'error' => isset($error) ? $error : null,
                'success' => isset($success) ? $success : null,
                'message' => isset($message) ? $message : null,
            ]);

            echo $innerContent;
            ?>
        </div>
    </section>

    <?php
    $a = new Area('Bottom');
    $a->display($c);
    ?>
</main>
<?php
$this->inc('includes/footer.php');
$this->inc('includes/doc_footer.php');
?>
