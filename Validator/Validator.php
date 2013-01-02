<?php

abstract class Validator {

     protected $errors = array();
     
     public abstract function getErrors();

     public abstract function isValid($fieldValue);
}

?>
