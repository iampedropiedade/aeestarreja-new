<?php
namespace Application\Block\ContactForm;

use Application\Blocks\Controller as BlockController;
use Concrete\Core\Support\Facade\Route;
use Concrete\Core\Validation\CSRF\Token;

class Controller extends BlockController
{
    public const TOKEN_ACTION = 'contact_form_submit';

    protected $btTable = 'btContactForm';
    protected $btInterfaceWidth = '900';
    protected $btInterfaceHeight = '500';
    protected $searchableFields = ['heading', 'title'];
    protected $requiredFields = [
        ['fieldName'=>'heading'],
        ['fieldName'=>'title'],
    ];

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders a Contact form');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('Contact form');
    }

    public function view()
    {
        parent::view();
        $this->set('token', new Token());
        $this->set('tokenAction', self::TOKEN_ACTION);
    }

    protected function action_process_contact_form()
    {
        var_dump($this->post());
        exit;
    }

}
