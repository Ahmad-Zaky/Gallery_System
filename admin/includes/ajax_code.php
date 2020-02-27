<?php 

    /* --- Not used in the Project --- */

    if(isset($_POST['id'])){
        
        $id = intval($_POST['id']);
        redirect("edit_photo.php?photo_id=$id");
    }else
        echo "not found";

?>