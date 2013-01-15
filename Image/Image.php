<?php

class Image extends Markup_HTML_Element {

    const DEFAULT_WIDTH = 300;
    const DEFAULT_HEIGHT = 300;

    protected $id = null;
    protected $fileName = null;
    protected $fileType = null;
    protected $fileSize = null;
    protected $dateAdded = null;
    protected $imageDirectory = IMAGES_DIR;
    protected $width = self::DEFAULT_WIDTH;
    protected $height = self::DEFAULT_HEIGHT;

    //"get" function properties - __call overloading
    //example: getId(), getFileType()
    public function __call($name, $arguments) {
        if (substr($name, 0, 3) == 'get') {
            $name = lcfirst(str_replace('get', '', $name));
            $n = get_class_vars(get_class($this));
            return (isset($n[$name])) ? $n[$name] : null;
        }
    }

    public function __construct(array $attrs = array()) {
        $this->directory = basename($this->imageDirectory) . '/';
        $attrs = array('src' => $this->directory . $this->fileName, 'width' => $this->width, 'height' => $this->height);
        $this->attributes = $attrs;
        parent::__construct($attrs);
    }

    public function setDirectory($dir) {
        $this->directory = $dir;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function resize($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    public function displayImage() {
        $this->Html = "<img ";

        foreach ($this->attributes AS $key => $value) {
            $this->Html .= ' ';
            $this->Html .= $key;
            $this->Html .= ' = ';
            $this->Html .= "'$value'";
            $this->Html .= ' ';
        }

        $this->Html .= "/>";

        return $this->Html;
    }

    public function __toString() {
        return $this->displayImage();
    }

}

?>
