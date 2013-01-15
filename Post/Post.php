<?php

class Post {

    protected $id = null;
    protected $userId = null;
    protected $body = null;
    protected $dateAdded = null;

    //"get" function properties - __call overloading
    //example: getId(), getFileType()
      public function __call($name, $arguments) {
        if (substr($name, 0, 3) == 'get') {
            $name = lcfirst(str_replace('get', '', $name));
            $n = get_object_vars(($this));
            return (isset($n[$name])) ? $n[$name] : null;
        }
    }


}

?>
