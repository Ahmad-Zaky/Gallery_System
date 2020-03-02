<?php 

    // DATABASE CONNECTION CONSTANTS
    defined('DB_HOST') ? null : define('DB_HOST', 'localhost');
    defined('DB_USER') ? null : define('DB_USER', 'root');
    defined('DB_PASS') ? null : define('DB_PASS', 'Ahmed@2017');
    defined('DB_NAME') ? null : define('DB_NAME', 'gallery_db');


    // ROOTS PATHES CONSTANTS
    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
    defined('SITE_ROOT') ? null : define('SITE_ROOT', 'c:xampp'. DS .'htdocs'. DS .'oop'. DS .'gallery');
    defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin' . DS . 'includes');

?>




<!-- List of features to add in future -->