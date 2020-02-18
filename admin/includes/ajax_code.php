<?php 

    if(isset($_POST['id'])){
        
        $id = intval($_POST['id']);
//        echo $id;
        redirect("edit_photo.php?photo_id=$id");
    }else
        echo "not found";

?>