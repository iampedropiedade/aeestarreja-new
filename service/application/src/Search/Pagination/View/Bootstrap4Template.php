<?php

namespace Application\Search\Pagination\View;

use Pagerfanta\View\Template\Template;

class Bootstrap4Template extends Template
{
    static protected $defaultOptions = array(
        'previous_message'              => '',
        'next_message'                  => '',
        'css_disabled_class'            => 'disabled',
        'css_dots_class'                => 'dots',
        'css_current_class'             => 'active',
        'dots_text'                     => '...',
        'container_template'            => '<ul class="pagination justify-content-center">%pages%</ul>',
        'page_template'                 => '<li class="page-item"><a href="%href%" class="page-link">%text%</a></li>',
        'span_template'                 => '<li class="page-item active"><a href="#" class="page-link">%text%</a></li>',
        'next_template'                 => '<li class="page-item"><a href="%href%" class="page-link">Seguinte</a></li>',
    	'next_template_disabled'        => '<li class="page-item disabled"><a class="page-link">Seguinte</a></li>',
        'previous_template'             => '<li class="page-item"><a href="%href%" class="page-link">Anterior</a></li>',
		'previous_template_disabled'    => '<li class="page-item disabled"><a class="page-link">Anterior</a></li>'
    );

    public function container()
    {
        return $this->option('container_template');
    }

    public function page($page)
    {
        $text = $page;
        return $this->pageWithText($page, $text);
    }

    public function pageWithText($page, $text)
    {
        $search = array('%href%', '%text%');
        $href = $this->generateRoute($page);
        $replace = array($href, $text);

        return str_replace($search, $replace, $this->option('page_template'));
    }

    public function previousDisabled()
    {
        $search = array('%href%', '%text%');
        $replace = array("#", $this->option('previous_message'));
        return str_replace($search, $replace, $this->option('previous_template_disabled'));
    }

    public function previousEnabled($page)
    {
        $search = array('%href%', '%text%');
        $href = $this->generateRoute($page);
        $replace = array($href, $this->option('previous_message'));
        return str_replace($search, $replace, $this->option('previous_template'));
    }

    public function nextDisabled()
    {
        $search = array('%href%', '%text%');
        $replace = array("#", $this->option('next_message'));
        return str_replace($search, $replace, $this->option('next_template_disabled'));        
    }

    public function nextEnabled($page)
    {
        $search = array('%href%', '%text%');
        $href = $this->generateRoute($page);
        $replace = array($href, $this->option('next_message'));
        return str_replace($search, $replace, $this->option('next_template'));
    }

    public function first()
    {
        return $this->page(1);
    }

    public function last($page)
    {
        return $this->page($page);
    }

    public function current($page)
    {
        $search = array('%text%');
        $replace = array($page);
        return str_replace($search, $replace, $this->option('span_template'));
    }

    public function separator()
    {
        return '<li class="page-item"><span class="page-link">...</span></li>';
    }

}