<?php 

// function to load unincluded classes by finding them in includes directory

// --- better way ---
function classAutoLoad($class){
    
    $class = strtolower($class);
    $path = "includes/classes/{$class}.php";
    
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
function check_post_password($obj_password_hash){
    
    // updating the password
    if(password_verify($_POST['password'], $obj_password_hash)){

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
    
    redirect("users.php");
}

// ------ set new photo status function ------
function set_photo_status($photo_id, $photo_status){
    
    global $session; 
    // find user by id
    $photo = Photo::find_byID($photo_id);
    
    // check if photo's properties are specified in case we wanna publish the photo
    if($photo->is_property_empty() && $photo_status == "published"){
        $session->message("Sorry, Can not publish uncomplete gallery photo!");
        redirect("photos.php");
        return;
    }
    
    if($photo){
        
        // set the new user role
        $photo->photo_status = $photo_status;

        // save the user new infos, save() is from the DB_object class
        $photo->save();
    }
    redirect("photos.php");
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
    redirect("comments.php");
}


/* 
 --- Registeration Form function ---

        *--- Description ---* 
    
    + checks:
    |
    |_  + check if post is submitted
        |
        |_ check if email is right formatted with our reg_expr
            |
            |_ if yes get the email data
            |_ if no return error message
        |
        |_ check if username is used before
            |
            |_ if yes return error message
        |
        |_ check if any field is empty (by $_POST[''])
            |
            |_ if yes return error message
        |
        |_ check if the two password fields are equal
            |
            |_ if yes return error message
        |
        |_ check if every thing is right then set the password hash
    
    
    -> return value: array of messages. 
*/

function registeration(){
    
    $check = true;
    $message = array();
    $properties = array();
    
    if(isset($_POST['submit'])){
        
        // get user infos
        $properties['username'] = trim($_POST['username']);
        $properties['first_name'] = trim($_POST['first_name']);
        $properties['second_name'] = trim($_POST['second_name']);
        $properties['user_register_date'] = date('Y-m-d H:i:s');
        $properties['user_role'] = "subscriber";
        
         
        // check email regular expression with this
        // pattern " ^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$ "
        $reg_expr = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
        if(preg_match($reg_expr, trim($_POST['email'])))
            $properties['user_email'] = trim($_POST['email']);
        else{
            $message[] = "Wrong Email!, plz write a right formatted email";
            return $message;
        }
            
        
        
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        
        // create a new user
        $new_user = User::create_obj($properties);
        
        // check if this username is used before
        $get_username = User::find_byUsername($properties['username']);
        
        // display msg if username is used before
        if($get_username){
            
            $message[] = "<h4 class='text-center bg-danger'>username already exists, Plz try a new username.</h4>";
            $check = false;
        }
        
        // display msg if any field is empty
        if(is_post_empty($_POST['submit'])){
            
            $message[] = "<h4 class='text-center bg-danger'>one or more fields are still empty!</h4>";
            $check = false;
        }
        
        // display msg if password and confirm_password does not match
        if($password !== $confirm_password){
            $message[] = "<h4 class='text-center bg-danger'>password does NOT MATCH!, Plz try again.</h4>";
            $check = false;
        }
        
        // if registeration is fine then encrypt password
        if($check){
            
            // save the row password and the password hash
            $new_user->password_hash = $new_user->set_password_hash($password);
            $new_user->password = $password;
            
            if($new_user->save())
                $message[] = "<p class='text-center bg-success'>Successfuly registered! </p>";
            else
                $message[] = "<p class='text-center bg-warning'>Something went wrong, Plz try again! </p>";
        }
        
        return $message;
    }
    
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
    
    // in case we are in comments_photo.php 
    if(isset($_GET['id']))
        $id = $_GET['id'];
    
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
                    redirect("photos.php");
                break;
                case 'admin':
                case 'subscriber':
                    set_user_status($ValID, $bulkOption);
                    redirect("users.php");
                break;
                case 'pinned':
                case 'unpinned':
                    set_comment_status($ValID, $bulkOption);
                    if($_GET['id'])
                        redirect("comments_photo.php?id=$id");
                    else
                        redirect("comments.php");
                break;
                case 'delete_photo':
                    $photo = Photo::find_byID($photoValID);
                    if($photo)
                        $photo->delete_with_file();
                    redirect("photos.php");
                break;
                case 'delete_user':
                    $user = Ucommentser::find_byID($ValID);
                    if($user)
                        $user->delete_with_file();
                    redirect("users.php");
                break;
                case 'delete_comment':
                    $comment = Comment::find_byID($ValID);
                    if($comment)
                        $comment->delete();
                    if($_GET['id'])
                        redirect("comments_photo.php?id=$id");
                    else
                        redirect("comments.php");
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
        $user->user_register_date = date('Y-m-d H:i:s');
        $user->user_role = trim($_POST['user_role']);
        $user->set_file($_FILES['file_upload']);
        
        // check email regular expression with this
        // pattern " ^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$ "
        $reg_expr = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
        if(preg_match($reg_expr, trim($_POST['user_email'])))
            $user -> user_email = $_POST['user_email'];
        else{
            $message = "Wrong Email!, plz write a right formatted email";
            redirect("add_user.php?msg=$message");
        }
        
        // check if post has empty fields
        if(is_post_empty($_POST['add_user'])){
            
            $message = "There is one or more fields empty";
            redirect("add_user.php?msg=$message");
        }
        
        // check the password and confirm password
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        if($password === $confirm_password){

            // create and set the password hash and set the plain password
            $user->password = trim($_POST['password']);
            $user->password_hash = $user->set_password_hash(trim($_POST['password']));
            
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


/* 
        *--- update a user ---*
         
         *--- Description ---*
        
    + checks:
    |
    |_  + check $_POST['update'] if it is set and if it is not empty.
        |
        |_ check email reg_expr.
            |
            |_ if yes then set updated email.
            |_ if no then set error message.
        |
        |_ check empty fields.
            |
            |_ if yes then we check if the empty fields are not the password fields.
                |
                |_ if the empty fields are not the password fields then return error message.
        |
        |_  + check if the password field is the right password of the user.
            |
            |_ if yes then check the new_password field.
                |
                |_ if yes then check the new password with confirm if equal.
                    |
                    |_ if yes then set the new password.
                    |_ if not then return error message.
                |
                |_ check if photo is not uploaded properly.
                    |
                    |_ if yes then we unset the photo data.
                |
                |_ check if the user is updated properly.
                    |
                    |_ if yes then set success message and return any error messages if there is ones.
                    |_ if no then check if nothing changed and then return error messages.
            
            |_ if no then 
                    

*/
function update_user(){
    
    global $user, $message;
    
    if(isset($_POST['update']) && !empty($_POST['update'])){
      
        $user -> username = trim($_POST['username']);
        $user -> first_name = trim($_POST['first_name']);
        $user -> second_name = trim($_POST['second_name']);
        $user -> user_role = $_POST['user_role'];
        $user -> set_file($_FILES['file_upload']);
        
        
        // check email regular expression with this
        // pattern " ^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$ "
        $reg_expr = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
        if(preg_match($reg_expr, trim($_POST['user_email'])))
            $user -> user_email = $_POST['user_email'];
        else{
            $message = "Wrong Email!, plz write a right formatted email";
            return;
        }
            
        
        // check if post has empty fields
        if(is_post_empty($_POST['update'])){
            
            // we make here an exception for password fields
            if(!empty($_POST['password']) || !empty($_POST['new_password']) || !empty($_POST['confirm_password'])){
                
                $message = "There is one or more fields empty";
                return;
            }
        }
        
        // check the password field with the user password
        if(check_post_password($user->password_hash)){
            
            // it will only assigned if I really changed the password
            // if left the fields empty nothing will happen
            if(!empty($_POST['new_password'])){
                
                if(trim($_POST['new_password']) === trim($_POST['confirm_passsword'])){
                    
                    // create and set the password hash and set the plain password
                    $user->password = trim($_POST['new_password']);
                    $user->password_hash = $user->set_password_hash(trim($_POST['new_password']));
                }else{
                    
                    // return nothing with error message if the two password fields did not match
                    $message = "Password does NOT MATCH!, plz try again.";
                    return;
                }
                
            }
            
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
    
    // to be available for both one upload and multi upload files
    if(isset($_POST['submit']) || isset($_FILES['file'])){
        
        // create photo object
        $photo = new Photo();
        $photo -> photo_title = trim($_POST['title']);
        $photo -> photo_caption = trim($_POST['caption']);
        $photo -> photo_description = strip_tags(trim($_POST['description']));
        $photo -> set_file($_FILES['file']);
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
                
                // in case the commenter is not a user
                if(isset($_SESSION['user_id']))
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
        
        
        // Line : 2
        // --------
        
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