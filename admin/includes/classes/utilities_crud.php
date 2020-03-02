<?php 
    
    class Utilities_CRUD implements Utilities_CRUD_interface{
        
        
                    /* --- User Class functions --- */




        // CREATE NEW USER 
        public static function create_user(){

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
        public static function update_user(){

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
        public static function create_photo(){

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
        public static function update_photo(){

            global $photo, $message;

            if(isset($_POST['update']) && !empty($_POST['update'])){

                $photo -> photo_title = $_POST['title'];
                $photo -> photo_caption = $_POST['caption'];
                $photo -> photo_alternate_text = $_POST['alternate_text'];
                $photo -> photo_description = $_POST['description'];
                $photo -> photo_status = $_POST['status'];
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
        public static function create_comment(){

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

    }

?>