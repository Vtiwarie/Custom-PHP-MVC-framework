<?php

abstract class Ecommerce_Products_Product {
    protected $id = null;
    protected $title = null;
    protected $price = null;
    protected $description = null;
 
    CONST INTRO = 70;
    //"get" function properties - __call overloading
    //example: getId(), getName()
    public function __call($name, $arguments) {
        if (substr($name, 0, 3) == 'get') {
            $name = lcfirst(str_replace('get', '', $name));
            $n = get_object_vars(($this));
            return (isset($n[$name])) ? $n[$name] : null;
        }
    }
    
    public function getClassVars()
    {
        return get_class_vars($this);
    }

    public function getVars()
    {
        return get_object_vars($this);
    }

    public function getProductType()
    {
        $prod_name = get_class($this);
        $prod_name = str_replace('_', '/', $prod_name);
        
        return basename($prod_name);
    }
    
    public function getIntro()
    {
        return substr($this->description, 0, self::INTRO) . '...';
    }
}

?>
