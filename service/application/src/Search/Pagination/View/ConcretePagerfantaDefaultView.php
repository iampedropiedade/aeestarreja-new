<?php
namespace Application\Search\Pagination\View;

use Pagerfanta\View\DefaultView;
use Concrete\Core\Search\Pagination\View\ViewInterface;

class ConcretePagerfantaDefaultView extends DefaultView implements ViewInterface
{
    protected function createDefaultTemplate()
    {
        return new \Application\Search\Pagination\View\Bootstrap4Template();
    }
    
    public function getArguments()
    {
        return array(
            'prev_message' => 'Prev',
            'next_message' => 'Next'
        );
    }
}