<?php
namespace Application\Controller\PageType;

use Application\Page\Controller\PageController;
use Concrete\Core\User\User;
use Concrete\Core\User\PostLoginLocation;

/**
 * Class PublicPrivate
 * @package Application\Controller\PageType
 */
class PublicPrivate extends PageController
{
    public function view()
    {
        $user = new User();
        $this->set('user', $user);
        if(!$user->isRegistered()) {
            $this->app->make(PostLoginLocation::class)->setSessionPostLoginUrl($this->c);
        }
        else {
            $this->getChildren();
        }
    }

}
