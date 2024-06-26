<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Application\Constants\Attributes;
use Application\Models\Page\Articles;
use Concrete\Core\Page\Page;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValue;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption;

/** @var Page $page */
$model = new Articles();
$indexPageLink = Articles::getIndexPage()->getCollectionLink();
$attributes = new Attributes();
?>
<p>
    <a href="<?php echo $indexPageLink; ?>" class="btn btn-primary py-2 px-4">Remover filtros</a>
</p>