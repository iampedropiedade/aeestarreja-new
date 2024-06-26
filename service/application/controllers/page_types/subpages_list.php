<?php
namespace Application\Controller\PageType;

use Application\Page\Controller\PageController;

/**
 * Class SubpagesList
 * @package Application\Controller\PageType
 */
class SubpagesList extends PageController
{
    public function view()
    {
        $this->setChildren();
    }

}