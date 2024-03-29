<?php

class User {

    protected $id = null;
    protected $userName = null;
    protected $email = null;
    protected $userType = null;
    protected $dateAdded = null;
    protected $dateModified = null;

    //"get" function properties - __call overloading
    //example: getId(), getUserName()
    public function __call($name, $arguments) {
        if (substr($name, 0, 3) == 'get') {
            $name = lcfirst(str_replace('get', '', $name));
            $n = get_object_vars(($this));
            return (isset($n[$name])) ? $n[$name] : null;
        }
    }

    public function isAdmin() {
        return ($this->userType == 'admin');
    }

}

?>
