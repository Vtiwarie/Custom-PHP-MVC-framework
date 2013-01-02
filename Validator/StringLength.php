<?php

class Validator_StringLength extends Validator {

    protected $maxLength;

    public function __construct($maxLength) {
        if(!is_int($maxLength))
            throw new Exception('String Length must be an integer');
        $this->maxLength = $maxLength;
    }

    public function isValid($fieldValue) {
        if (strlen($fieldValue) > $this->maxLength)
            $this->errors[] = "Field length cannot exceed $this->maxLength characters";

        if (empty($this->errors))
            return true;

        return false;
    }

    public function getErrors() {
        return $this->errors;
    }

}

?>
