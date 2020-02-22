<?php 

    class User extends DB_object{
        
    // ------- Properties -------
        
        /* --- GENERIC NAMES --- */
        protected static $db_table_fields = array("user_id", "username", "password", "password_hash", "first_name", "second_name", "photo_name", "user_email", "user_register_date", "user_role");
        protected static $db_table = "users";


        /* --- Class Table Properties --- */
        // protected to let parent class handle child class properties 
        protected $user_id = 0;
        protected $username = "";
        protected $password = "";
        protected $password_hash = ""; /* Generic Name */
        protected $first_name = "";
        protected $second_name = "";
        protected $user_email = "";
        protected $user_register_date = "";
        protected $user_role = "";
        
        
        
        
        
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
            $query .= "username = '$username'";
            
            $user_found = self::makeQuery($query);
            
            $user = array_shift($user_found);
            
            if($user){
                
                // check if there is a password_hash
                if($user->password_hash !== ""){
                    
                    if(!password_verify($password, $user->password_hash))
                        return false;
                }else{
                    
                    if($password !== $user->password)
                        return false;
                    
                    // set a password hash if there is no one
                    $user->password_hash = $user->set_password_hash($password);
                    $user->save();
                }
                return $user;
            }
            return false;
        }
        
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
        
        public static function get_admin_users(){
            
            global $db;
            
            $query = "SELECT * FROM users ";
            $query .= "WHERE user_role = 'admin'";
           
            $result = self::makeQuery($query);
            
            return $result;
        }   
        
        // get Nr. of admin users
        public static function admin_counter(){
            
            global $db;
            
            $query = "SELECT COUNT(*) FROM users ";
            $query .= "WHERE (user_role = 'admin') ";
           
            $result = $db->query($query);
            
            $row = $result->fetch_array(MYSQLI_NUM);
            
            return !empty($row) ? $row[0] : false;
            
        }
        
                   
        // get Nr. of subscriber users
        public static function subscriber_counter(){
            
            global $db;
            
            $query = "SELECT COUNT(*) FROM users ";
            $query .= "WHERE (user_role = 'subscriber') ";
           
            $result = $db->query($query);
            
            $row = $result->fetch_array(MYSQLI_NUM);
            
            return !empty($row) ? $row[0] : false;
            
        }
    }

?>


<!-- List of features to add in future -->


<!--
                   /* ----- DEPRECATED CODE ----- */ 

            // LINE : 75
            // ---------
             

//            $query = "SELECT * IFNULL( (SELECT * FROM users WHERE ";
//            $query .= "username = '$username'), 'NOT FOUND') ";
//            $query .= "AS my_username FROM users";
        
        
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
        
        
        Line : 22
        ---------
        
        
                /* *** Generic name custom value *** */
        
        // related to user image (not saved in DB yet!)
        
        
        
        -->
