<?php include("includes/header.php"); ?>
<?php if(!$session->is_signedIn()) redirect("login.php"); ?>

<?php 

// if we come from comments.php
if(!empty($_GET['comment_id']) && isset($_GET['comment_id'])){
    
    $id = $_GET['comment_id'];
    
    $comment = Comment::find_byID($id);
    if($comment){
        
        $comment->delete();
        redirect("comments.php");
    }
    else
        redirect("comments.php");

}


// if we come from comments_photo.php
if(!empty($_GET['comment_photo_id']) && isset($_GET['comment_photo_id'])){
    
    $id = $_GET['comment_photo_id'];
    
    $comment = Comment::find_byID($id);
    if($comment){
        
        $comment->delete();
        redirect("comments_photo.php?id=$id");
    }
    else
        redirect("comments_photo.php?id=$id");

}
    

?>

<!-- List of features to add in future -->