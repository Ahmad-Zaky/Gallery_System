<?php 

    interface Sessionface{
        
        // get the session sign_is status
        public function is_signedIn();
        
        // set the first user login session by passing its object
        public function login($user);
        
        // unset the session and object properties to log out
        public function logout();
        
        // check if session is setted up for a user
        private function check_login();
        
        // get a message and set a message if there is not 
        public function message($msg);
        
        // custom function to turn message to empty
        public function set_msg_empty();
        
        // check at first begin of session obj decl. (__construct() function)
        private function check_msg();
        
        // check views by refreshing
        public function views_counter();
        
    }

?>