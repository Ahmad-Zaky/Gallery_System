<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>

<?php 
if(!empty($_GET['user_id']) && isset($_GET['user_id'])){
    
    $id = $_GET['user_id'];
    
    $user = User::find_byID($id);
    if($user){
        
        $user->delete_with_file();
        redirect("users.php");
    }
    else
        redirect("users.php");

}else{
    echo "Missing id!";
}
?>

<!-- List of features to add in future -->