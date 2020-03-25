<?php 

// function to load unincluded classes by finding them in includes directory

// --- better way ---

// for class autoload
function resourceAutoLoad($resource){
    
    $resource = strtolower($resource);
    $path = "includes/classes/{$resource}.php";
    
    // check if the file and the class both exists
    if(is_file($path))
        require_once($path);
    else 
        throw new Exception("Unable to load {$class}.php file!");
        die("Unable to load {$class}.php file!");
}

spl_autoload_register('resourceAutoLoad');



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
    
    // this condition is for get into the update part of the code in update_user()
    if(isset($_POST['password']))
        return true;
    
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
                    $photo = Photo::find_byID($ValID);
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




?>




<!-- List of features to add in future -->


<!-- 
   
    ----------
    TODO List:
    ----------

    1. When I change nothing and click upload it will update successfully but
       if I hit the botton again and also without changing anything then it will
       output the msg: Nothing changed to UPDATE. why NOT from the first time? (DONE)
    2. Add utilities classes for the functions here.
    3. user utilities for static methods and do not use static methods for the main classes.
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

        // Line : 3
        // --------
        
        
        // function to load unincluded classes by finding them in includes directory

// --- better way ---

// for class autoload
function classAutoLoad($class){
    
    $class = strtolower($class);
    $path = "includes/classes/{$class}.php";
    
    // check if the file and the class both exists
    if(is_file($path) && !class_exists($class))
        require_once($path);
    else // better do not throw any excpeption to allow other autoloader
        throw new Exception("Unable to load {$class}.php file!");
        die("Unable to load {$class}.php file!");
}
        
                        
// for interface autoload (Could there be more than one autoloader?)
function interfaceAutoLoad($interface){
    
    $interface = strtolower($interface);
    $path = "includes/interfaces/{$interface}.php";
    
    // check if the file and the interface both exists
    if(is_file($path) && !interface_exists($interface))
        require_once($path);
//    else
//        throw new Exception("Unable to load {$interface}.php file!");
}

spl_autoload_register('classAutoLoad');
spl_autoload_register('interfaceAutoLoad');




        // Line : 24
        // ---------
        
                        
//// for interface autoload (Could there be more than one autoloader?)
//function interfaceAutoLoad($interface){
//    
//    $interface = strtolower($interface);
//    $path = "includes/interfaces/{$interface}.php";
//    
//    // check if the file and the interface both exists
//    if(is_file($path) && !interface_exists($interface))
//        require_once($path);
//    else
//        throw new Exception("Unable to load {$interface}.php file!");
//}
//
//spl_autoload_register('interfaceAutoLoad');

        
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