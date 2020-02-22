<?php 

 
//    * ob_start() should be always at the top otherwise we will get a problem like this
//        - “Warning: Cannot modify header information - headers already sent by” error


    ob_start();  

    require_once("new_config.php");
    require_once("classes/session.php"); 
    require_once("database.php");
    require_once("classes/db_object.php");
    require_once("functions.php");
    require_once("classes/user.php"); 
    require_once("classes/photo.php"); 
    require_once("classes/comment.php");
    require_once("classes/paginator.php");
?>