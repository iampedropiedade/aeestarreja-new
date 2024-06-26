<?php
namespace Application\Models\Page;

class Model extends AbstractModel
{

    protected function setDefaults() : void
    {
        $this->itemsPerPage = -1;
        $this->sortByDisplayOrder();
    }

}
