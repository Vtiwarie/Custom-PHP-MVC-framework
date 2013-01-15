<?php

class Comment {

    protected $id = null;
    protected $postId = null;
    protected $userId = null;
    protected $body = null;
    protected $dateAdded = null;

    //"get" function properties - __call overloading
    //example: getId(), getPostId()
    public function __call($name, $arguments) {
        if (substr($name, 0, 3) == 'get') {
            $name = lcfirst(str_replace('get', '', $name));
            $n = get_class_vars(get_class($this));
            return (isset($n[$name])) ? $n[$name] : null;
        }
    }


}

?>
