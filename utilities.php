<?php

//directory definitions
define('CLASSES_DIR', 'classes' . DIRECTORY_SEPARATOR);
define('VIDEOS_DIR', 'videos' . DIRECTORY_SEPARATOR);
define('IMAGES_DIR', 'images' . DIRECTORY_SEPARATOR);

//database definitions
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_NAME', 'metube');
define('DB_PASS', '');

//database tables
define('DB_TABLE_USERS', 'users');
define('DB_TABLE_VIDEOS', 'videos');
define('DB_TABLE_COMMENTS', 'comments');

//class definitions
define('CLASS_USER', 'User');
define('CLASS_DBHandler', 'DB_Handler');
define('CLASS_DB', 'DB');
define('CLASS_AUTH', 'Auth');

//autoload classes
function class_loader($class) {
    //include(CLASSES_DIR . "{$class}.php");
    $dir = CLASSES_DIR;

    if (strpos($class, '_') !== false) {
        $dir .= ucfirst(str_replace('_', DIRECTORY_SEPARATOR, $class));
        $dir .= ".php";
    } else {
        $dir .= sprintf(("%s%s%s.php"), ucfirst($class), DIRECTORY_SEPARATOR, ucfirst($class));
    }

    if (!file_exists($dir))
        throw new Exception('Class file does not exist');
    include_once($dir);
}

spl_autoload_register('class_loader');

try {
    $db = DB_Handler::getInstance();
} catch (Exception $e) {
    echo $e->getMessage();
}


//attempt to start the user session
session_start();

$auth = Auth::getInstance();
?>
