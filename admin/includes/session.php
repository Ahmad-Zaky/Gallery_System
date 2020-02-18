<?php 

    class Session{
        
        // --- Properties ---
        
        private $signed_in = false;
        public $user_id;
        public $message;
        public $views = 1;
        
        // --- Methods ---
        
        // constructor
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
            $this -> signed_in = true;
        }
        
        // unset the session and object properties to log out
        public function logout(){
            unset($_SESSION['user_id']);
            unset($this -> user_id);
            $this -> signed_in = false;
        }
        
        // check if session is setted for a user
        private function check_login(){
            
            if(isset($_SESSION['user_id'])){
                
                $this -> user_id = $_SESSION['user_id'];
                $this -> signed_in = true;
            }else{
                
                unset($this -> user_id);
                $this -> signed_in = false;                
            }
        }
        
        // get a message 
        public function message($msg=""){
            
            if(!empty($msg)){
                
                $_SESSION['message'] = $msg;
            
            }else
                return $this -> message;
            
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

    TODO List:
    
    1. Turn the properties to private and use set and get instead.


-->