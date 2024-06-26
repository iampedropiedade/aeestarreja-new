<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\View\View;
assert(isset($c));

$toolbar = (new Permissions($c))->canViewToolbar();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php View::element('header_required'); ?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?php echo $this->getThemePath() ?>/app/stylesheets/main.css">
    <?php if (!$toolbar) : ?>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <?php endif; ?>
</head>
<body>
    <div class="page <?php echo $c->getPageWrapperClass(); ?> <?php echo $c->isEditMode() ? 'page-edit-mode' : ''; ?> <?php echo $toolbar ? 'page-toolbar-mode' : ''; ?>" data-behaviour="page" data-page-id="<?php echo $c->getCollectionID(); ?>">
