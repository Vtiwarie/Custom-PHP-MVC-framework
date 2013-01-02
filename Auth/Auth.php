<?php

require_once('includes/utilities.php');

class Auth {

    protected static $_instance = null;
    protected $user = null;
    protected $db = null;
    protected $errorMessages;

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

        return self::$_instance;
    }

    public function setConnection(DB $db) {
        $this->db = $db;
        $this->checkConnection();
    }

    private function checkConnection() {
        if ($this->db == null) {
            throw new Exception('No connection established');
        }
    }

    //USER AUTHENTICATION
    public function getIdentity() {
        return $this->user;
    }

    public function isAdmin() {
        return (isset($this->user) && ($this->user->getUserType() == 'admin' )) ? true : false;
    }

    public function canEditPage($pageId) {
        return (($this->user->getUserType() == 'admin') || $this->user->getId() == $pageId);
    }

    public function login($email, $password) {
        //check for connection
        $this->checkConnection();

        
        //check if a user is alread logged in
        if (isset($_SESSION['auth']) || isset($this->user)) {
            throw new Exception('A user is already logged in');
        }

        $email = trim(htmlentities($email));
        $password = sha1(trim(htmlentities($password)));
       
        $query = 'SELECT id, userName, email, userType, dateAdded, dateModified FROM :table WHERE email=:email AND password=:password';
        $stmt = $this->db->prepare($query);
        $r = $stmt->execute(array(':table' => DB_TABLE_USERS, ':email' => $email, ':password' => $password));

        $stmt->setFetchMode(PDO::FETCH_CLASS, CLASS_USER);
        $this->user = $stmt->fetch();
        print_r($this->user);

        if (empty($this->user)) {
            throw new Exception('user could not be logged in');
        } else {
            $_SESSION['auth'] = $this->user;
            header('Location:index.php');
        }
    }

    public function logout() {
        $this->user = null;

        $_SESSION['auth'] = null;

        session_destroy();
    }

    //CRUD functions
    public function updateUser() {
        
    }

    public function deleteUser() {
        //delete from database
        //delete from class
        $this->user = null;
    }

    public function createUser() {
        //check if a user already exists
   
        //encrypt the password with sha1 or SHA
    }

    public function __toString() {
        
    }

}

?>
