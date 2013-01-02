<?php

class DB_Handler {

    private static $_instance = null;

    private function __construct() {
        
    }

    private function __clone() {
        ;
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            $conn = sprintf("%s:host=%s;dbname=%s", DB_DRIVER, DB_HOST, DB_NAME);
            self::$_instance = new DB($conn, DB_USER, DB_PASS);
        }

        return self::$_instance;
    }

}

?>
