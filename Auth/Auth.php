<?php

class Auth {

    protected static $_instance = null;
    protected static $user = null;
    protected $db = null;
    protected $encryptionType = 'sha1';
    protected $requiredFields = array('id', 'userName', 'email', 'userType', 'dateAdded', 'dateModified');

    private function __construct() {
        ;
    }

    private function __clone() {
        ;
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new Auth();
        }

        if (isset($_SESSION['auth']))
            self::$user = $_SESSION['auth'];

        return self::$_instance;
    }

    public function setConnection(DB $db) {
        $this->db = $db;
        $this->checkConnection();
    }

    protected function checkConnection() {
        if ($this->db == null) {
            throw new Exception('No connection established');
        }
    }

    //USER AUTHENTICATION
    public function getIdentity() {
        return (isset(self::$user)) ? self::$user : $_SESSION['auth'];
    }

    public function isAdmin() {
        return ($this->getIdentity()->isAdmin());
    }

    public function canEditPage($pageId) {
        return (($this->getIdentity()->isAdmin()) || self::$user->getId() == $pageId);
    }

    public function login($email, $password) {
        //check for connection
        $this->checkConnection();

        //check if a user is alread logged in
        if (isset($_SESSION['auth']) || isset(self::$user)) {
            throw new Exception('A user is already logged in');
        }

        $enc = $this->encryptionType;
        $email = trim(htmlentities($email));
        $password = $enc(trim(htmlentities($password)));

        $where = sprintf("email='%s' AND password='%s'", $email, $password);
        $result = $this->db->select(DB_TABLE_USERS, implode(', ', $this->requiredFields), $where)->submitQuery();
        $user = $result[0];

        if (!$user) {
            self::$user = null;
            throw new Exception('email and password combination incorrect');
        } else {
            self::$user = $user;
            $_SESSION['auth'] = self::$user;
            ;
        }
    }

    public function logout() {
        self::$user = null;

        $_SESSION = null;

        session_destroy();
    }

    public function isLoggedIn() {
        return isset(self::$user);
    }

}

?>
