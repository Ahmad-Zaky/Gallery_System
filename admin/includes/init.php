<?php 

 
//    * ob_start() should be always at the top otherwise we will get a problem like this
//        - “Warning: Cannot modify header information - headers already sent by” error


    ob_start();  

    require_once("new_config.php");
    require_once("classes/database_interface.php");
    require_once("classes/session_interface.php");
    require_once("classes/user_interface.php");
    require_once("classes/photo_interface.php");
    require_once("classes/comment_interface.php");
    require_once("classes/paginator_interface.php");
    require_once("classes/utilities_crud_interface.php");
    require_once("classes/utilities_user_interface.php");
    require_once("classes/database.php");
    require_once("classes/session.php"); 
    require_once("classes/db_object.php");
    require_once("classes/user.php"); 
    require_once("classes/photo.php"); 
    require_once("classes/comment.php");
    require_once("classes/paginator.php");
    require_once("classes/utilities_crud.php");
    require_once("classes/utilities_user.php");
    require_once("functions.php");
?>