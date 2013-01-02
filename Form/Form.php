<?php

/* * *****************************
 * AUTHOR: Vishaan Tiwarie
 * 
 * DESCRIPTION: A lightweight Form builder class, with form validation tools and error handling
 * functions
 * ***************************** */

class Form extends Markup_HTML_Element {

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    protected $errorMessages = array();
    protected $request;
    public $formElements = array();

    public function __get($fieldName = null) {
        return $this->getFieldByName($fieldName);
    }

    public function getMethod() {
        return (isset($this->attributes['method'])) ? $this->attributes['method'] : self::METHOD_POST;
    }

    public function getAction() {
        return (isset($this->attributes['action'])) ? $this->attributes['action'] : '';
    }

    public function getErrorMessages() {
        return $this->errorMessages;
    }

    public function getFieldByName($fieldName = null) {
        if (!isset($fieldName))
            throw new Exception('You must enter a field name');
        else if (!in_array($fieldName, array_keys($this->formElements)))
            throw new Exception("Element $fieldName does not exist");
        return $this->formElements[$fieldName];
    }

    public function clearErrorMessages() {
        $this->errorMessages = array();
        unset($this->errorMessages);
    }

    public function setMethod($method = null) {
        if ($method === '' || !isset($method))
            throw new Exception('Field \'method\' cannot be empty');
        $this->attributes['method'] = strtoupper($method);
        return $this;
    }

    public function setAction($action = null) {
        if ($action === '' || !isset($action))
            throw new Exception('Field \'action\' cannot be empty');
        $this->attributes['action'] = $action;
        return $this;
    }

    public function addElement(Form_Element $elem) {
        if ($elem->getFieldName() && in_array($elem->getFieldName(), array_keys($this->formElements)))
            throw new Exception('an element with that name has already been added');

        $this->formElements[$elem->getFieldName()] = $elem;
        return $this;
    }

    public function isValid(Array $postArray) {

        foreach ($postArray AS $key => $value) {
            if (!in_array($key, array_keys($this->formElements))) {
                throw new Exception("Field $key does not exist");
            }
            if (!$this->formElements[$key]->isValid($value)) {
                $this->errorMessages[$key] = $this->formElements[$key]->getErrorMessages();
            }
        }

        if (empty($this->errorMessages))
            return true;

        return false;
    }

    public function displayForm() {
        $this->Html = "<form ";

        foreach ($this->attributes AS $key => $value) {
            $this->Html .= ' ';
            $this->Html .= $key;
            $this->Html .= ' = ';
            $this->Html .= "'$value'";
            $this->Html .= ' ';
        }

        $this->Html .= ">";

        //display the elements
        foreach ($this->formElements AS $elem) {
            $this->Html .= $elem;
        }
        //end the form
        $this->Html .= "</form>";
        return $this->Html;
    }

    public function __toString() {
        return $this->displayForm();
    }

}

?>
