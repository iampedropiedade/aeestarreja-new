<?php
use Application\Container\EventRegistration;

include sprintf('%s/%s/vendor/autoload.php', DIR_APPLICATION, DIRNAME_CLASSES);

Core::bind('manager/view/pagination', function($app) {
    return new \Application\Search\Pagination\View\Manager($app);
});

(new EventRegistration())->registerEvents($this->app);