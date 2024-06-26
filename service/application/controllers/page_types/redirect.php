<?php
namespace Application\Controller\PageType;

use Application\Constants\Attributes;
use Application\Page\Controller\PageController;
use Concrete\Core\Routing\Redirect as RoutingRedirect;

/**
 * Class Redirect
 * @package Application\Controller\PageType
 */
class Redirect extends PageController
{

    public function on_start()
    {
        if(!$this->canEditPage()) {
            $url = $this->c->getAttribute(Attributes::REDIRECT_TO_EXTERNAL_URL);
            if($url) {
                return RoutingRedirect::to($url);
            }
        }
    }

}