<?php 

 
//    * ob_start() should be always at the top otherwise we will get a problem like this
//        - “Warning: Cannot modify header information - headers already sent by” error


    ob_start();  

    require_once("functions.php");
    require_once("new_config.php");
    require_once("database.php");
    require_once("db_object.php");
    require_once("user.php"); 
    require_once("photo.php"); 
    require_once("comment.php");
    require_once("paginator.php");
    require_once("session.php"); 
?>