<?php 

    class User extends DB_object{
        
    // ------- Properties -------
        
        /* --- GENERIC NAMES --- */
        protected static $db_table_fields = array("user_id", "username", "password", "first_name", "second_name", "photo_name");
        protected static $db_table = "users";


        /* --- Class Table Properties --- */
        // protected to let parent class handle child class properties 
        protected $user_id = 0;
        protected $username = "";
        protected $password = "";
        protected $first_name = "";
        protected $second_name = "";
        
        
                /* *** Generic name custom value *** */
        
        // related to user image (not saved in DB yet!)
        
        
        
    // ------- Methods -------
        
        // Magic method (constructor)
        function __construct(){
            
            $this->placeholder_photo = "usr.jpg"; 
            $this->upload_dir = "images"; 
            $this->placeholder_photo_url = "http://placehold.it/400X400?text=image"; 
        }
        
        // Magic methods (set and get)
        public function __set($property, $value){
            
            if(property_exists($this, $property))
                $this->$property = $value;
            else
                $this->errors[] = "Failed to set $property to $value!";
        }
        
        public function __get($property){
            
            if(property_exists($this, $property))
                return $this->$property;
            else
                $this->errors[] =  "Failed to get $property!";
        }
        
        
        // verify usr and pwd with DB
        public static function verify_user($username, $password){
            global $db;
            
            $username = $db->escape_string($username);
            $password = $db->escape_string($password);
            
            $query = "SELECT * FROM ". self::$db_table ." WHERE ";
            $query .= "username = '$username' AND ";
            $query .= "password = '$password' ";
            
            $user_found = self::makeQuery($query);
            
            return !empty($user_found) ? array_shift($user_found) : false;
        }
        
        
    }

?>


<!-- List of features to add in future -->


<!--
       /* ----- DEPRECATED CODE ----- */ 

        
        
        // set methods
            
        // I will keep those because I already used them
        public function set_user_id($id){
            $this->user_id = $id;
        }
        
        public function set_username($usr){
            $this->username = $usr;
        }
        
        public function set_password($pwd){
            $this->password = $pwd;
        }
        
        public function set_first_name($fName){
            $this->first_name = $fName;
        }
        
        public function set_second_name($sName){
            $this->second_name = $sName;
        }
        
        // get methods
        public function get_user_id(){
            return $this->user_id;
        }
        
        public function get_username(){
            return $this->username;
        }
        
        public function get_password(){
            return $this->password;
        }
        
        public function get_first_name(){
            return $this->first_name;
        }
        
        public function get_second_name(){
            return $this->second_name;
        }
        
        
        
        
        
        
        
        -->
