<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-03-16
 * Time: 09:25
 */
namespace Application\Blocks;

use \Concrete\Core\Error\ErrorList\ErrorList;
use \Concrete\Core\File\File;
use \Concrete\Core\Support\Facade\Application;
use Concrete\Core\Validator\String\EmailValidator;

class ValidationService
{
    public const VALID_NOT_EMPTY = 'not_empty';
    public const VALID_EMAIL = 'email';
    public const VALID_INTEGER = 'integer';
    public const VALID_FILE = 'file';
    public const VALID_IMAGE = 'image';
    public const VALID_TOKEN = 'csrf_token';

    protected $validationFields = [];
    protected $invalidFields = [];
    protected $error;
    protected $app;
    protected $validators;

    public function __construct()
    {
        $this->error = new ErrorList();
        $this->app = Application::getFacadeApplication();
        $this->validators['strings'] = $this->app->make('helper/validation/strings');
        $this->validators['numbers'] = $this->app->make('helper/validation/numbers');
        $this->validators['token'] = $this->app->make('helper/validation/token');
        $this->validators['email'] = new EmailValidator();
    }

    /**
     * @param $value
     * @param $errorDescription
     * @param string $validate
     */
    public function addRequired($value, $errorDescription, $validate=self::VALID_NOT_EMPTY) : void
    {
        if(is_array($value)) {
            foreach($value as $itemPosition=>$itemValue) {
                $this->addRequired($itemValue, t('%s on item in position %s', $errorDescription, $itemPosition), $validate);
            }
            return;
        }
        $validationObject = new \stdClass;
        $validationObject->message = $errorDescription;
        $validationObject->value = $value;
        $validationObject->validate = $validate;
        $this->validationFields[] = $validationObject;
    }

    /**
     * @param $value
     * @param $errorDescription
     * @param string $validate
     */
    public function addRequiredFile($value, $errorDescription, $validate=self::VALID_FILE) : void
    {
        if(is_array($value)) {
            foreach($value as $itemPosition=>$itemValue) {
                $this->addRequiredFile($itemValue, t('%s on item in position %s', $errorDescription, $itemPosition), $validate);
            }
            return;
        }
        $validationObject = new \stdClass;
        $validationObject->message = $errorDescription;
        $validationObject->value = $value;
        $validationObject->validate = $validate;
        $this->validationFields[] = $validationObject;
    }

    /**
     * @return bool
     */
    public function test() : bool
    {
        foreach ($this->validationFields as $field) {
            $validate = $field->validate;
            $fieldValue = $field->value;
            switch ($validate) {
                case self::VALID_TOKEN:
                    if (!$this->validators['token']->validate($fieldValue)) {
                        $this->invalidFields[] = $field;
                    }
                    break;
                case self::VALID_INTEGER:
                    if ((!$this->validators['numbers']->integer($fieldValue)) && $this->validators['strings']->notempty($fieldValue)) {
                        $this->invalidFields[] = $field;
                    }
                    break;
                case self::VALID_FILE:
                    if (!$this->validateRequiredFile($fieldValue)) {
                        $this->invalidFields[] = $field;
                    }
                    break;
                case self::VALID_IMAGE:
                    if(!$this->validateRequiredFile($fieldValue, true)) {
                        $this->invalidFields[] = $field;
                    }
                    break;
                case self::VALID_EMAIL:
                    if(!$this->validators['email']->isValid($fieldValue)) {
                        $this->invalidFields[] = $field;
                    }
                    break;
                default:
                    if (!$this->validators['strings']->notempty($fieldValue)) {
                        $this->invalidFields[] = $field;
                    }
                    break;
            }
        }
        $this->setErrorsFromInvalidFields();
        return count($this->invalidFields) === 0;
    }

    /**
     *
     */
    protected function setErrorsFromInvalidFields() : void
    {
        foreach ($this->invalidFields as $field) {
            $this->error->add($field->message);
        }
    }


    /**
     * @return ErrorList
     */
    public function getError() : ErrorList
    {
        return $this->error;
    }

    /**
     * @param $value
     * @param bool $image
     * @return bool
     */
    protected function validateRequiredFile($value, $image=false) : bool
    {
        $value = (int)$value;
        if(!is_int((int)$value) || ($value === 0)) {
            return false;
        }
        $file = File::getByID($value);

        if(!$file) {
            return false;
        }

        if($image === true && $file->getVersion()->getGenericTypeText() !== 'Image') {
            return false;
        }
        return true;
    }

}