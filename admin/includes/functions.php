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

// --- Format Date and Time ---
function format_date_time($date_time){
    
    // Date 
    $Day_nr = date('d', strtotime($date_time));
    $Day_name = date('D', strtotime($date_time));
    $Month = date('F', strtotime($date_time));
    $Year = date('Y', strtotime($date_time));
    
    // Time 
    $hour = date('h', strtotime($date_time));
    $minute = date('i', strtotime($date_time));
    $_12Sys = date('A', strtotime($date_time));
    
    // should look like this 'Tue 24 August, 2013 at 9:00 PM'
    return "$Day_name $Day_nr $Month, $Year at $hour:$minute $_12Sys";
    
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

// ------ set new user role function ------
function set_user_role($user_id, $user_role){
    
    // find user by id
    $user = User::find_byID($user_id);
    if($user){
        
        // set the new user role
        $user->user_role = $user_role;

        // save the user new infos, save() is from the DB_object class
        $user->save();
    }
}

// ------ set new photo status function ------
function set_photo_status($photo_id, $photo_status){
    
    // find user by id
    $photo = Photo::find_byID($photo_id);
    if($photo){
        
        // set the new user role
        $photo->photo_status = $photo_status;

        // save the user new infos, save() is from the DB_object class
        $photo->save();
    }
}

// ------ set new comment status function ------
function set_comment_status($comment_id, $comment_status){
    
    // find comment by id
    $comment = Comment::find_byID($comment_id);
    if($comment){
        
        // set the new comment status
        $comment->comment_status = $comment_status;

        // save the comment new infos, save() is from the DB_object class
        $comment->save();
    }
}

// --- Registeration Form function ---
function registeration(){
    
    
}

// ---- Login Form function ---
function login_form(){
    
    global $session;
    
    // check POST submitted data
    if(isset($_POST['submit'])){
        $username = trim($_POST['username']); // using trim to remove and prefix white spaces 
        $password = trim($_POST['password']);
        
        // check the user data with DB
        $user_found = User::verify_user($username, $password);
        
        // user found
        if($user_found){
            $session->login($user_found);
            redirect("index.php");
            
        }else{ 
            // 
            // if not found then we have two possibilities 1. fields are empty. 2. wrong usr or pwd 
            if(!empty($username) && !empty($password))
                $session->message("Username or Password are not correct!, plz try again.");
            else
                $session->message("One of more fields are empty, plz fill the empty field.");
            
            redirect("login.php"); // to activate the $session->message("...");
        }
    }
}

// Apply options on selected records function
function apply_selected_options(){
    
    // get the submitted form for selected check boxes
    if(isset($_POST['chkBoxArr'])){
        
        // loop through in each check box with its id value
        foreach($_POST['chkBoxArr'] as $ValID){
            
            // get the selected option to apply on each record alone
            $bulkOption = $_POST['bulkOption'];
            
            switch($bulkOption){
                    
                case 'published':
                case 'draft':
                    set_photo_status($ValID, $bulkOption);
                break;
                case 'admin':
                case 'subscriber':
                    set_user_status($ValID, $bulkOption);
                break;
                case 'pinned':
                case 'unpinned':
                    set_comment_status($ValID, $bulkOption);
                break;
                case 'delete_photo':
                    $photo = Photo::find_byID($photoValID);
                    if($photo)
                        $photo->delete_with_file();
                break;
                case 'delete_user':
                    $user = Ucommentser::find_byID($ValID);
                    if($user)
                        $user->delete_with_file();
                break;
                case 'delete_comment':
                    $comment = Comment::find_byID($ValID);
                    if($comment)
                        $comment->delete();
                break;
            } 
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
        $user->user_email = trim($_POST['user_email']);
        $user->user_register_date = date('Y-m-d H:i:s');
        $user->user_role = trim($_POST['user_role']);
        $user->set_file($_FILES['file_upload']);
        
        // check the password and confirm password
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        if($password === $confirm_password){

            $user -> password = trim($_POST['password']);
            
            // unset the file infos if the file is not uploaded properly 
            // for example the file is already exist
            if(!$user -> upload_file())
                $user -> unset_file();
                
            // CREATING THE USER
            if($user -> save()){
                
                $message = "User Successfully created!";
                
                // in case of any uploading error 
                if($user -> errors)
                    $message .= "<br>" . join("<br>", $user -> errors);

                redirect("add_user.php?msg=$message");
            }
            else{

                $message = "Failed to create a new User!";
                if($user->errors)
                    $message .= "<br>" . join("<br>", $user->errors);

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
        $user -> user_role = $_POST['user_role'];
        $user -> user_email = $_POST['user_email'];
        $user -> set_file($_FILES['file_upload']);

        if(check_post_password($user->password)){
            
            // it will only assigned if I really changed the password
            // if left the fields empty nothing will happen
            if(!empty($_POST['new_password']))
                $user -> password = trim($_POST['new_password']);
            
            // unset the file infos if the file is not uploaded properly 
            // for example the file is already exist
            if(!$user -> upload_file())
                $user -> unset_file();
            
            // UPDATING THE USER
            if($user -> save()){
                    
                $message = "Successfully updated!";
                
                // in case of any uploading error 
                if($user -> errors)
                    $message .= "<br>" . join("<br>", $user -> errors);
            }
            else{
                
                // make a clone obj using find_byID() function
                $user_clone = User::find_byID($user->user_id); 
                

                // check if changes happened
                if($user->compare_properties($user_clone))
                    $message = "Nothing changed to make UPDATE! ";
                else
                    $message = "Failed to Update! ";
                
                // to show file upload errors
                if($user->errors)
                    $message .= "<br>" . join("<br>", $user->errors);
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
        $photo -> photo_title = trim($_POST['title']);
        $photo -> photo_caption = trim($_POST['caption']);
        $photo -> photo_description = strip_tags(trim($_POST['description']));
        $photo -> set_file($_FILES['file_upload']);
        $photo -> photo_alternate_text = trim($_POST['alternate_text']);
        $photo -> photo_upload_date = date('Y-m-d H:i:s');
        $photo -> photo_status = "draft";
        $photo -> user_id = $_SESSION['user_id'];
        
        // unset the file infos if the file is not uploaded properly 
        // for example the file is already exist
        if(!$photo -> upload_file())
            $photo -> unset_file();
            
        
        // UPLOADING THE PHOTO
        if($photo -> save()){
            
            $message = "Photo Uploaded successfully!";
            
            // in case of any uploading error 
            if($photo -> errors)
                $message .= "<br>" . join("<br>", $photo -> errors);
            redirect("upload.php?msg=$message");
        }
        else{
            
            $message = "Failed to Upload the Photo!";
            if(!empty($photo->errors))
                $message .= "<br>" . join("<br>", $photo->errors);
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
        
        // unset the file infos if the file is not uploaded properly 
        // for example the file is already exist
        if(!$photo -> upload_file())
            $photo -> unset_file();
        
        // UPDATING THE PHOTO
        if($photo -> save()){
            
            $message = "Successfully updated!";
            
            // in case of any uploading error 
            if($photo -> errors)
                $message .= "<br>" . join("<br>", $photo -> errors);
        }
        else{
            
            $photo_clone = Photo::find_byID($photo->photo_id); 
            
            // check if changes happened
            if($photo->compare_properties($photo_clone))
                $message = "Nothing changed to make UPDATE!";
            else
                $message = "Failed to update!";
            
            if(!empty($photo->errors))
                $message .= "<br>" . join("<br>", $photo->errors);
        }
    }   
}


                    /* --- Comment Class functions --- */


// creating a submitted comment
function create_comment(){
    
    global $session;
    
    if(isset($_POST['submit'])){
        
        // check if any field is empty
        if(empty($_POST['body']))
            $session->message("One or more fileds are empty!");
        else{
            
            // set all properties in an array 
            $properties = array();

            $photo = Photo::find_byID($_GET['id']);
            if($photo)
            {
                // set values for comment properties 
                $properties['photo_id'] = $photo->photo_id;
                $properties['comment_author'] = trim($_POST['author']);
                $properties['comment_body'] = trim($_POST['body']);
                $properties['comment_date'] = date('Y-m-d H:i:s');
                $properties['comment_status'] = "unpinned";
                $properties['user_id'] = $_SESSION['user_id'];

                // create comment object with the properties values
                $new_comment = Comment::create_obj($properties);

                // save the comment and redirect to the same photo page
                if($new_comment && $new_comment->save())
                    redirect("photo.php?id=$photo->photo_id");
            }
        }
    }
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
        
        
<!-- 
        
                            *---- Deprecated Code ---*
        
        
        
        
        
        // Line : 43
        // ---------
        
    
//    // split the date and time apart in array string elements
//    $DateTime = split(' ', $date_time);
//    
//    // save each part in a variable
//    $Date = $DateTime[0]; $Time = $DateTime[1];
//    
//    // split Date and Time again into small pieces
//    $date_parts = split('-', $Date);
//    $time_parts = split(':', $Time);
    // save date parts and time parts in variables
        
        
        
        
        // Line : 301 , update_photo() function
        $message .= "<br>" . join("<br>", $photo -> errors); // Ques: do we need this line ?
        
        
        
        
        
        // Check if the file is already exist
        if(!$photo -> upload_file()){ // to set the error array with any upload errors
        
            // now get the photo errors array and loop through to find this error 
            $errors = $photo -> errors;

            $file_exist = 0;
            $file_exist_err = "";
    //        $exist_err_msg = "The file {$photo->photo_name} already exist";
            foreach($errors as $error){
                if($error == "The file {$photo->photo_name} already exist"){
                    $file_exist = 1;
                    $file_exist_err = "The file {$photo->photo_name} already exist";
                    $photo->photo_name = "";
                }

            }
        }
        
        
-->