<?php

abstract class Form_Element extends Markup_HTML_Element {

    const FORM_TEXT = 'text';
    const FORM_PASSWORD = 'password';
    const FORM_SUBMIT = 'submit';
    const FORM_EMAIL = 'email';
    const FORM_SELECT = 'select';
    const FORM_CHECKBOX = 'checkbox';
    const FORM_COLOR = 'color';
    const FORM_DATE = 'date';
    const FORM_DATETIME = 'datetime';
    const FORM_FILE = 'file';
    const FORM_IMAGE = 'image';
    const FORM_NUMBER = 'number';
    const FORM_TEL = 'tel';
    const FORM_URL = 'url';
    const FORM_HIDDEN = 'hidden';

    protected $errorMessages = array();
    protected $validators = array();
    protected $fieldName;
    protected $label;

    public function __construct(array $attrs = array(), $fieldName = null) {
        $this->fieldName = (isset($attrs['name'])) ? $attrs['name'] : $fieldName;

        parent::__construct($attrs);
    }

    public function isRequired() {
        return (isset($this->attributes['required'])) ? (bool) $this->attributes['required'] : false;
    }

    public function setRequired($req = true) {
        $this->attributes['required'] = (bool) $req;
        return $this;
    }

    public function getFieldName() {
        return $this->fieldName;
    }

    public function setFieldName($fieldName) {
        $this->attributes['name'] = $fieldName;
        $this->fieldName = $fieldName;
    }

    //Validators
    public function addValidator(Validator $val) {
        //check if validator already included
        foreach ($this->validators AS $v) {
            $class = get_class($val);
            if ($v instanceof $class)
                return $this;
        }

        $this->validators[] = $val;
        return $this;
    }

    public function addValidators(Array $validators = array()) {
        foreach ($validators AS $key => $val) {
            if (!($val instanceof Validator)) {
                throw new Exception("Element {$key} must be a validator");
            } elseif (!is_int($key))
                throw new Exception('All keys must be numeric');
        }

        $this->validators = array_merge($this->validators, $validators);
        return $this;
    }

    public function isValid($fieldValue = null) {
        $this->clearErrorMessages();

        //if field name not provided
        if (!($this->getFieldName())) {
            $this->errorMessages[] = 'no field name provided';
            return false;
        }

        //get errors from validators if applicable
        foreach ($this->validators AS $val) {
            if (!$val->isValid($fieldValue)) {
                $errors = $val->getErrors();
                foreach ($errors AS $err) {
                    $this->errorMessages[] = $this->fieldName . ': ' . $err;
                }
            }
        }

        //if field is required
        if (($this->isRequired()) && ($fieldValue == null)) {
            $this->errorMessages[] = $this->getFieldName() . ' is a required field';
        }

        if (empty($this->errorMessages))
            return true;

        return false;
    }

    //error handling
    public function getErrorMessages() {
        return $this->errorMessages;
    }

    public function clearErrorMessages() {
        $this->errorMessages = array();
        unset($this->errorMessages);
        return $this;
    }

    //display element
    protected function displayElement($inputType = null) {
        if (!is_string($inputType) && isset($inputType))
            throw new Exception('No input type specified');

        $this->Html = sprintf("<input type = '%s'", $inputType);
        foreach ($this->attributes AS $key => $value) {
            $this->Html .= ' ';
            $this->Html .= $key;
            $this->Html .= ' = ';
            $this->Html .= "'$value'";
            $this->Html .= ' ';
        }

        $this->Html .= '/>';
        return $this->Html;
    }

}

?>
