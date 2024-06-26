<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Error\ErrorList\ErrorList;

/** @var ErrorList $error */
if(!($error instanceof ErrorList) || !$error->has()) {
    return;
}
$errors = $error->getList();
?>
<section class="ftco-section py-2">
    <div class="container">
        <?php foreach($errors as $error) : ?>
            <div class="alert alert-danger ftco-animate fadeInUp ftco-animated" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
