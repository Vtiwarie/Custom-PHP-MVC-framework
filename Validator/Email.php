<?php

class Validator_Email extends Validator {
    
    public function isValid($fieldValue)
    {
         
        if(!filter_var($fieldValue, FILTER_VALIDATE_EMAIL ))
        {
            $this->errors[] = "Field is not a valid email address.";
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
