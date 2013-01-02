<?php

class Validator_Alnum extends Validator {

    public function isValid($fieldValue) {

        if (!filter_var($fieldValue, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z\s]+$/i")))) {
            $this->errors[] = "Field must be alphanumeric.";
        }

        if (empty($this->errors))
            return true;

        return false;
    }

    public function getErrors() {
        return $this->errors;
    }

}

?>
