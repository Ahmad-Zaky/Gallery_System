<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>
<?php if($_SESSION['user_role'] == "subscriber") redirect("../index.php");?>

<?php 
if(!empty($_GET['user_id']) && isset($_GET['user_id'])){
    
    $id = $_GET['user_id'];
    
    // We will delete the photos related to this user to remove the files from the directory
    $photos = Photo::find_photos_by_userID($id);
    foreach($photos as $photo){
        
        $photo -> delete_with_file();
    }
    
    
    // Now we delete the user without any problems
    $user = User::find_byID($id);
    if($user){
        
        $user->delete_with_file();
        $session->message("User $user->username has been deleted");
        redirect("users.php");
    }
    else
        redirect("users.php");

}else{
    echo "Missing id!";
}
?>
<!-- List of features to add in future -->