<?php 

    class Session implements Sessionface{
        
        // --- Properties ---
        
        private $signed_in = false;
        private $user_id;
        private $username;
        private $user_role;
        private $message;
        private $views = 1;
        
        // --- Methods ---
        
        // magic method constructor
        function __construct(){
            session_start();
            $this -> views_counter();
            $this -> check_login();
            $this -> check_msg();
        }
        
        // get the session sign_is status
        public function is_signedIn(){
            return $this -> signed_in;
        }
        
        // set the first user login session by passing its object
        public function login($user){
            
            $this -> user_id = $_SESSION['user_id'] = $user -> user_id;
            $this -> username = $_SESSION['username'] = $user -> username;
            $this -> user_role = $_SESSION['user_role'] = $user -> user_role;
            
            $this -> signed_in = true;
        }
        
        // unset the session and object properties to log out
        public function logout(){
            
            unset($_SESSION['user_id']);
            unset($this -> user_id);
            
            unset($_SESSION['username']);
            unset($this -> username);
            
            unset($_SESSION['user_role']);
            unset($this -> user_role);
            
            $this -> signed_in = false;
        }
        
        // check if session is setted up for a user
        private function check_login(){
            
            if(isset($_SESSION['user_id'])){
                
                $this -> user_id = $_SESSION['user_id'];
                $this -> signed_in = true;
            }else{
                
                unset($this -> user_id);
                $this -> signed_in = false;                
            }
        }
        
        // get a message and set a message if there is not 
        public function message($msg=""){
            
            if(!empty($msg)){
                
                $this -> message = $_SESSION['message'] = $msg;
            
            }else
                return $this -> message;
            
        }
        
        // custom function to turn message to empty
        public function set_msg_empty(){
            $this->message = "";
        }
        
        // check at first begin of session obj decl. (__construct() function)
        private function check_msg(){
            
            if(isset($_SESSION['message'])){
                $this -> message = $_SESSION['message'];
                unset($_SESSION['message']);
            }else
                $this -> message = "";
        }
        
        // check views by refreshing
        public function views_counter(){
            
            if(isset($_SESSION['views']))
                $this->views = $_SESSION['views']++;
            else
                $_SESSION['views'] = 1;
        }
    }

    $session = new Session(); 

?>


<!-- List of features to add in future -->


<!-- 
    
    ----------
    TODO List:
    ----------
    
    1. Turn the properties to private and use set and get instead or superglobal $_SESSSION[''] variables (DONE)
    2. check again this feature in video "205. Creating Session Methods for Notifications in the Edit User Page Part # 1" (DONE)



-->