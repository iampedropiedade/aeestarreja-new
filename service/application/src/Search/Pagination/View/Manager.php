<?php
namespace Application\Search\Pagination\View;

use Concrete\Core\Support\Manager as CoreManager;
use Concrete\Core\Search\Pagination\View\ConcreteBootstrap4View;

class Manager extends CoreManager
{
    protected function createApplicationDriver()
    {
        return new ConcretePagerfantaDefaultView();
    }
    
    protected function createDashboardDriver()
    {
        return new ConcreteBootstrap4View();
    }
}