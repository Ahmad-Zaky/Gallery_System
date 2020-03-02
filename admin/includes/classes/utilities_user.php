<?php 

    class Utilities_user implements Utilities_user_interface{
        
    
      
        
            
        // check if there is user with the same username 
        public static function find_byUsername($username){
            
            // check the nr. of rows retrieved from the query if 0 then no similar username
            // if 1 or more then ther is similar username
            global $db;
            
            $query = "SELECT * FROM users WHERE ";
            $query .= "username = '$username'";

            $reuslt = $db->query($query);
            $rows_cnt = $reuslt->num_rows;
            
            return $rows_cnt;
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

        public static function registeration(){

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
                $get_username = self::find_byUsername($properties['username']);

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
        public static function login_form(){

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
    }
    
?>