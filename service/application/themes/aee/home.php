<?php
defined('C5_EXECUTE') or die('Access Denied.');
use \Concrete\Core\Area\Area;
$this->inc('includes/doc_header.php');
$this->inc('includes/header.php', ['navStyle'=>'navbar-transparent']);
?>

<?php
$a = new Area('Main');
$a->setCustomTemplate('news_list', 'templates/pull_up.php');
$a->display($c);
?>

<?php
$this->inc('includes/footer.php');
$this->inc('includes/doc_footer.php');
?>
