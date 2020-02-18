<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>

<?php 
if(!empty($_GET['photo_id']) && isset($_GET['photo_id'])){
    
    $id = $_GET['photo_id'];
    
    $photo = Photo::find_byID($id);
    if($photo){
        
        $photo->delete_with_file();
        $session->message("Photo $photo->photo_title has been deleted");
        redirect("photos.php");
    }
    else
        redirect("photos.php");

}else{
    echo "did not get id";
}
?>

<!-- List of features to add in future -->