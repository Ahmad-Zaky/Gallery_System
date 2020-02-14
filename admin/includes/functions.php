<?php 
// --- autoload to scan unincluded classes files ---

// course way 
// Hint: the course instructor did change it to the better way later on

//function __autoload($class){
//    
//    $class = strtolower($class);
//    $path = "includes/{$class}.php";
//    
//    if(file_exists($path))
//        require_once($path);
//    else
//        die("FILE {$class}.php is not FOUND!");
//}

// --- better way ---

function classAutoLoad($class){
    
    $class = strtolower($class);
    $path = "includes/{$class}.php";
    
    if(is_file($path) && !class_exists($class))
        require_once($path);
    else
        throw new Exception("Unable to load {$class}.php file!");
//        die("Unable to load {$class}.php file!");
}

spl_autoload_register('classAutoLoad');


// --- redirect function ---

function redirect($location){
    header("Location: {$location}");
}


// --- check $_POST if it has empty values ---
function is_post_empty(){
    
    foreach($_POST as $key => $value)
        if(empty($value)) return true;
    
    return false;
}

// --- check password ---
function check_post_password($obj_password){
    
    // check if post empty
    if(empty($_POST['password']))
        return true;
    
    // updating the password
    if($obj_password == $_POST['password']){

        //check the new password and the confirmation
        if($_POST['new_password'] === $_POST['confirm_password']){
            return true;
        }
        else
            return -1;
    }else 
        return false;
}


// ---- Login Form function ---
function login_form(){
    
    global $session, $warning_msg;
    
    if(isset($_POST['submit'])){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        $user_found = User::verify_user($username, $password);
        
        if($user_found){
            $session->login($user_found);
            redirect("index.php");
        }else{
            if(!empty($username) && !empty($password))
                $Warning_msg = "Username or Password are not correct!, plz try again.";
            else
                $Warning_msg = "One of more fields are empty, plz fill the empty field.";
        }
    }
}



                    /* --- User Class functions --- */




// CREATE NEW USER 
function create_user(){
    
    $password = "";
    $confirm_password = "";
    $message = "";

    // Get the infos from the form 
    if(isset($_POST['add_user']) && !empty($_POST['add_user'])){
    
        // create user object
        $user = new User();

        $user->username = trim($_POST['username']);
        $user->first_name = trim($_POST['first_name']);
        $user->second_name = trim($_POST['second_name']);
        $user->set_file($_FILES['file_upload']);
        
        // check the password and confirm password
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        if($password === $confirm_password){

            $user -> password = trim($_POST['password']);

            // check if created successfully
            if($user -> save()){
                
                if($user -> upload_file())
                    $message = "User Successfully created!";
                else
                    $message = "Failed to create a new User!";

                redirect("add_user.php?msg=$message");
            }
            else{

                $message = "failed to upload the photo!";
                $message .= join("<br>", $user -> errors);

                redirect("add_user.php?msg=$message");
            }
        }else{
            
            $message = "Passwords do not Match, plz try again";
            redirect("add_user.php?msg=$message");
        }
        
    }
}


// update a user
function update_user(){
    
    global $user, $message;
    
    if(isset($_POST['update']) && !empty($_POST['update'])){
      
        $user -> username = trim($_POST['username']);
        $user -> first_name = trim($_POST['first_name']);
        $user -> second_name = trim($_POST['second_name']);
        $user -> set_file($_FILES['file_upload']);

        if(check_post_password($user->password)){
            
            // it will only assigned if I really changed the password
            // if left the fields empty nothing will happen
            if(!empty($_POST['new_password']))
                $user -> password = trim($_POST['new_password']);
            
            if($user -> save()){
                if($user -> upload_file())
                    $message = "Successfully updated!";
                else
                    $message = "Failed to upload the photo!";
            }
            else{
                
                // make a clone obj using find_byID() function
                $user_clone = User::find_byID($user->user_id); 
                $user_clone->set_file($_FILES['file_upload']);  // just to make fair comparison
                                                                // should be improved

                // check if changes happened
                if($user_clone == $user)
                    $message = "Nothing changed to make UPDATE! ";
                else
                    $message = "Failed to Update! ";
                
                // to show file upload errors 
                $message .= join("<br>", $user->errors);
            }
            
        }else{
            
            // in case password is wrong or the new pass and confirm pass doesn't match
            $pass_validation = check_post_password($user->password);
            if($pass_validation == 0)
                $message = "Wrong Password!, plz try again.";
            else
                $message = "New Password Doesn't match, plz try again.";
        }
    }   
}


                    /* --- Photo Class functions --- */

// create a photo
function create_photo(){
    
    if(isset($_POST['submit'])){
        
        // create photo object
        $photo = new Photo();
        $photo -> photo_title = $_POST['title'];
        $photo -> photo_description = $_POST['description'];
        $photo -> set_file($_FILES['file_upload']);
        // try to save the object in DB
        if($photo -> save()){
            if($photo -> upload_file()){
                
                $message = "Photo Uploaded successfully!";
                redirect("upload.php?msg=$message");
            }else{
                
                $message = join("<br>", $photo -> errors);
                redirect("upload.php?msg=$message");
            }
        }
        else{
            
            $message = "Failed to Upload the Photo!";
            redirect("upload.php?msg=$message");
        }
    }
}

// Update a photo
function update_photo(){
    
    global $photo, $message;
    
    if(isset($_POST['update']) && !empty($_POST['update'])){
        
        $photo -> photo_title = $_POST['title'];
        $photo -> photo_caption = $_POST['caption'];
        $photo -> photo_alternate_text = $_POST['alternate_text'];
        $photo -> photo_description = $_POST['description'];
        $photo -> set_file($_FILES['file_upload']);

        if($photo -> save()){
            if($photo -> upload_file())
                $message = "Successfully updated!";
            else
                $message = "Failed to upload!";
        }
        else{
            
            $photo_clone = Photo::find_byID($photo->photo_id); 
            $photo_clone->set_file($_FILES['file_upload']); // just to make fair comparison
                                                            // I think it should be improved
            
            // check if changes happened
            if($photo_clone == $photo)
                $message = "Nothing changed to make UPDATE!";
            else
                $message = "Failed to update!";
            
            $message .= join("<br>", $photo -> errors);

        }
    }   
}


                    /* --- Comment Class functions --- */


// creating a submitted comment
function create_comment(){
    
    if(isset($_POST['submit'])){
        
        $photo = Photo::find_byID($_GET['id']);
        if($photo)
        {
            $author = $_POST['author'];
            $body = $_POST['body'];
            
            $new_comment = Comment::create_obj($photo->photo_id, $author, $body);
            
            if($new_comment && $new_comment->save())
                redirect("photo.php?id=$photo->photo_id");
        }
    }
}

function delete_comment(){
    
}


?>




<!-- List of features to add in future -->


<!-- 
   
    ----------
    TODO List:
    ----------

    1. When I change nothing and click upload it will update successfully but
       if I hit the botton again and also without changing anything then it will
       output the msg: Nothing changed to UPDATE. why NOT from the first time?
-->