<?php

class Validator_NotEmpty extends Validator {
    
    public function isValid($fieldValue)
    {
        if(empty($fieldValue))
        {
            $this->errors[] = 'Field cannot be empty';
        }
        
        if(empty($this->errors))
            return true;
             
        return false;
    }
    
    public function getErrors() {
        return $this->errors;
    }
}

?>
