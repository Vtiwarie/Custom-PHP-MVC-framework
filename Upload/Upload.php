<?php

abstract class Upload {

    protected $db = null;
    protected $source = null;
    protected $maxFileSize = null;
    protected $uploadDirectory = IMAGES_DIR;
    protected $validExtensions = null;
    protected $errorMessages = array();

    public function __construct() {
        $sourceKey = each($_FILES);
        if (!empty($_FILES))
            $this->source = $_FILES[$sourceKey['key']];
    }

    public function setConnection($db) {
        $this->db = $db;
    }

    protected function checkConnection() {
        if ($this->db == null) {
            throw new Exception('No connection established');
        }
    }

    public function getErrorMessages() {
        return $this->errorMessages;
    }

    public function upload() {
        $this->checkConnection();

        if (empty($_FILES))
            $this->errorMessages[] = 'No file was uploaded';
        elseif ($this->source['error'])
            $this->errorMessages[] = 'There was an error uploading file';
        elseif ($this->source['size'] > $this->maxFileSize)
            $this->errorMessages[] = 'File size too large';
        elseif (!in_array(str_replace('image/', '', $this->source['type']), $this->validExtensions))
            $this->errorMessages[] = 'Invalid file extension';
        elseif (!@$this->db->insert(DB_TABLE_IMAGES, array('fileName' => $this->source['name'], 'fileType' => $this->source['type'], 'fileSize' => $this->source['size']))) {
            $this->errorMessages[] = 'Could not add file';
            return false;
        } elseif (!@move_uploaded_file($this->source['tmp_name'], $this->uploadDirectory . $this->source['name']))
            $this->errorMessages[] = 'File could not be uploaded';


        if (!empty($this->errorMessages))
            return false;
        else
            return true;
    }

    public function isPostUploaded() {
        return (!empty($_FILES));
    }

    public function delete() {
        if (!$this->db->delete(DB_TABLE_IMAGES, $this->id));
        //remove picture from folder
    }

    public function createDirectory($dirName) {
        if (!file_exists($dirName))
            mkdir($dirName);
        else
            throw new Exception('The file already exists');
        return $this;
    }

    public function setDirectory($dirName) {
        if (!file_exists($dirName))
            $this->errorMessages[] = 'No such directory exists';
        $this->uploadDirectory = $dirName;
        return $this;
    }

    public function setSource(array $source) {
        if (array_key_exists($source, $_FILES))
            $this->source = $source;
        return $this;
    }

    protected function clearSource() {
        $_FILES = array();
        unset($_FILES);
        return $this;
    }

}

?>
