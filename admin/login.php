<?php require_once("includes/header.php"); ?>

<?php 
    
    // initialize our usr and pwd
    $username = "";
    $password = "";
    $Warning_msg = "";

    // in case user is already loged in we redirect him back to index
    if(isset($_SESSION['user_id'])){
        redirect("index.php");
    }

    login_form();
?>





<div class="col-md-4 col-md-offset-3">

    <h4 class="bg-danger"><?php echo $Warning_msg; ?></h4>

    <form id="login-id" action="" method="post">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">
        </div>


        <div class="form-group">
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </div>


    </form>


</div>




<!-- List of features to add in future -->