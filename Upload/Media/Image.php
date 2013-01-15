<?php

class Upload_Media_Image extends Upload {


    public function __construct() {
        
        $this->validExtensions = array('pjpeg', 'jpeg', 'jpg', 'png', 'gif');
        $this->maxFileSize = 20000000;
        parent::__construct();
    }
}


?>
