<?php

abstract class Markup_HTML_Element {

    protected $attributes = array();
    protected $Html = '';

    public function __construct(Array $attrs = array()) {
        $this->attributes = $attrs;
    }

    public function getAttrib($attr) {
        return $this->attributes[$attr];
    }

    public function setAttrib($attr = null, $value = null) {
        if ($attr === null || $attr === '') {
            throw new Exception('Field name cannot be blank');
        }
        $this->attributes[$attr] = $value;
        return $this;
    }

    public function setAttribs(Array $attrs = null) {
        if (empty($attrs)) {
            throw new Exception('Field must be a non-empty array');
        }
        $this->attributes = $attrs;
    }

    public function getAttribs() {
        return $this->attributes;
    }

    public function getId() {

        return (isset($this->attributes['id'])) ? $this->attributes['id'] : -1;
    }

    public function setId($id = null) {
        if ($id === '' || !isset($id))
            throw new Exception('Field \'id\' cannot be empty');
        $this->attributes['id'] = (string) $id;
        return $this;
    }

    public function getName() {
        return (isset($this->attributes['name'])) ? $this->attributes['name'] : -1;
    }

    public function setName($name = null) {
        if ($name === '' || !isset($name)) {
            throw new Exception('Field \'name\' cannot be empty');
        }
        $this->attributes['name'] = $name;
        return $this;
    }

    //abstract methods
    public abstract function __toString();
}

?>
