<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-03-06
 * Time: 15:16
 */

namespace Application\Page\Controller;

use Application\Constants\Attributes;
use Application\Models\Page\Model;
use Concrete\Core\Page\Controller\PageController as CorePageTypeController;
use Concrete\Core\Page\Page;
use Concrete\Core\User\Group\Group;
use Concrete\Core\User\User;
use Symfony\Component\HttpFoundation\JsonResponse as SymfonyJsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Error\ErrorList\ErrorList;
use Concrete\Core\Form\Service\Validation;
use Concrete\Core\Permission\Checker as Permissions;

/**
 * Class PageController
 * @package Application\Page\Controller
 */
class PageController extends CorePageTypeController
{
    protected const HEADER_CONTENT_TYPE_JSON = 'application/json';
    protected const MAX_ITEMS_PER_PAGE = 12;

    /** @var ErrorList $error */
    protected $error;
    /** @var Validation $validation */
    protected $validation;
    protected $allowJsonResponse = false;
    protected $jsonTemplate;
    protected $jsonDataSets = [];

    public function on_start()
    {
        parent::on_start();
        $this->error = new ErrorList();
        $this->validation = new Validation();
    }

    /**
     * @param $jsonData
     * @param int $code
     * @param array $headers
     */
    protected function sendJsonResponse($jsonData, $code=200, $headers=[]) : void
    {
        $response = new SymfonyJsonResponse($jsonData, $code, $headers);
        $response->send();
        Application::shutdown();
    }

    protected function getRequestContentTypeIsJson() : bool
    {
        $request = Request::createFromGlobals();
        return $request->headers->get('Content-Type') === self::HEADER_CONTENT_TYPE_JSON;
    }

    public function on_before_render()
    {
        parent::on_before_render();
        $this->set('error', $this->error);
        $this->sendJsonResponseIfJsonRequest();
    }

    /**
     * @return bool|null
     */
    protected function sendJsonResponseIfJsonRequest() : ?bool
    {
        if($this->allowJsonResponse !== true || !$this->getRequestContentTypeIsJson()) {
            return false;
        }

        $code = 200;
        $jsonData = [];
        foreach($this->jsonDataSets as $jsonDataSet) {
            if($this->get($jsonDataSet)) {
                $jsonData[$jsonDataSet] = $this->get($jsonDataSet);
            }
        }

        if($this->error->has()) {
            $jsonData['errors'] = $this->getErrorList();
            $code = 400;
        }
        elseif($this->jsonTemplate !== null) {
            $view = $this->getViewObject();
            ob_start();
            $view->inc($this->jsonTemplate, $this->getSets());
            $jsonData['html'] = trim(ob_get_clean());
        }
        $this->sendJsonResponse($jsonData, $code);
    }

    /**
     * @return array
     */
    protected function getErrorList() : array
    {
        $errors = [];
        foreach($this->error->getList() as $error) {
            $errors[] = $error->getMessage();
        }
        return $errors;
    }

    /**
     * @param bool $csrfToken
     * @return bool
     */
    protected function validate($csrfToken=true) : bool
    {
        if($csrfToken === true) {
            $this->validation->addRequiredToken('submit');
        }
        $this->validation->setData($this->request());
        $valid = $this->validation->test();
        $this->error = $this->validation->getError();
        return $valid;
    }

    /**
     * @param $list
     * @return array|null
     */
    protected function clearEmptyParams($list)
    {
        if(!is_array($list)) {
            if($list !== '') {
                return $list;
            }
            return null;
        }
        $newList = [];
        foreach($list as $key=>$item) {
            if($item !== '') {
                $newList[$key] = $item;
            }
        }
        return $newList;
    }

    /**
     * @return bool
     */
    protected function canEditPage() : bool
    {
        $cp = new Permissions($this->c);
        if(!$cp->canEditPageContents()) {
            return false;
        }
        return true;
    }


    protected function setChildren(): void
    {
        $this->set('pages', $this->c->getCollectionChildren());
    }

}