<?php include("header.php"); ?>

<?php 
    $session->logout();
    redirect("../login.php");
?>