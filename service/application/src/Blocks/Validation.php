<?php
/**
 * Created by PhpStorm.
 * User: pedropiedade
 * Date: 2019-03-15
 * Time: 23:41
 */
namespace Application\Blocks;

trait Validation
{
    protected $requiredFields = [];
    protected $requiredSubFields = [];
    protected $validation;
    protected $args;

    /**
     * @param $args
     * @return mixed
     */
    public function validate($args)
    {
        $this->args = $args;
        $this->validation = new ValidationService();
        $this->addRequiredFields($this->requiredFields);
        $this->validation->test();
        return $this->validation->getError();
    }

    protected function addRequiredFields() : void
    {
        foreach ($this->requiredFields as $fieldData) {
            $this->addFieldToValidation($fieldData);
        }
    }

    protected function addFieldToValidation($data) : bool
    {
        if(!isset($data['fieldName'])) {
            return false;
        }
        $errorDescription = $data['message'] ?? $this->getErrorMessage($data['fieldName'], $data['validationType'] ?? null);
        if(isset($data['parent']) && is_array($this->args[$data['parent']])) {
            $value = [];
            $itemPosition = 0;
            foreach($this->args[$data['parent']] as $itemKey=>$itemData) {
                $itemPosition++;
                if($itemData['type'] === $data['whenType']) {
                    $value[$itemPosition] = $itemData[$data['fieldName']];
                }
            }
        }
        else {
            $value = $this->args[$data['fieldName']];
        }

        if(isset($data['validationType']) && $data['validationType'] === 'email') {
            $this->validation->addRequiredEmail($value, $errorDescription);
        }
        elseif(isset($data['validationType']) && $data['validationType'] === 'integer') {
            $this->validation->addInteger($value, $errorDescription);
        }
        elseif(isset($data['validationType']) && $data['validationType'] === 'file') {
            $this->validation->addRequiredFile($value, $errorDescription);
        }
        elseif(isset($data['validationType']) && $data['validationType'] === 'image') {
            $this->validation->addRequiredFile($value, $errorDescription, ValidationService::VALID_IMAGE);
        }
        else {
            $this->validation->addRequired($value, $errorDescription);
        }
        return true;
    }

    protected function getErrorMessage($field, ?bool $validationType = null) : string
    {
        $re = '/(?<=[a-z])(?=[A-Z])/x';
        $a = preg_split($re, ucwords($field));
        $fieldName = implode(' ', $a);
        if(!$validationType) {
            return t('%s is a required field', $fieldName);
        }
        return t('%s needs to be a valid %s', $fieldName, $validationType);
    }

}