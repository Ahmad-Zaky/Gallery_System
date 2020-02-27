<?php 

    class Photo extends DB_object implements Photoface{
    
        /* ----- PROPERTIES ----- */
        
        /* --- GENERIC NAMES --- */
        protected static $db_table_fields = array("photo_id", "photo_title", "photo_caption", "photo_description", "photo_name", "photo_alternate_text", "photo_type", "photo_size", "photo_upload_date", "photo_status", "user_id");
        protected static $db_table = "photos";

        /* --- Class Table Properties --- */
        protected $photo_id = 0;
        protected $photo_title = "";
        protected $photo_caption = "";
        protected $photo_description = "";
        protected $photo_alternate_text = "";
        protected $photo_upload_date = "";
        protected $photo_status = "";
        protected $user_id = "";
        
        protected $photo_type = "";
        protected $photo_size = 0;
        
        /* ----- METHODS ----- */
        
        // Magic method (constructor)
        function __construct(){
            
            $this->placeholder_photo = "image.png"; 
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
                $this->errors[] = "Failed to get $property!";
        }
        
        
        // get photo username function
        public function find_photo_username(){
            
            $user = User::find_byID($this->user_id);
            
            return $user->username;
        }
        
        
        // find Photos by user ID
        public static function find_photos_by_userID($user_id = 0){
            
            global $db;
            
            $qeury = "SELECT * FROM photos ";
            $qeury .= "WHERE user_id = " . $db->escape_string($user_id);
            $qeury .= " ORDER BY photo_id ";
            
            return self::makeQuery($qeury);
            
        }
        
        // get approved photos count and user photos if specified
        public static function custom_counter_approved($user_id = 0){
            
            global $db;
            
            $query = "SELECT COUNT(*) FROM photos ";
            $query .= "WHERE (photo_status = 'published' AND photo_name != '') ";
            
            // Add user_id condition
            if($user_id)
                $query .= "AND (user_id = $user_id)";
            
            $result = $db->query($query);
            
            $row = $result->fetch_array(MYSQLI_NUM);
            
            return !empty($row) ? $row[0] : false;
        }
        
        
                /* ----- ABSTRACT METHODS ----*/

        // get Nr. of published photos
        public static function counter_approved(){
            
            global $db;
            
            $query = "SELECT COUNT(*) FROM photos ";
            $query .= "WHERE (photo_status = 'published') ";
           
            $result = $db->query($query);
            
            $row = $result->fetch_array(MYSQLI_NUM);
            
            return !empty($row) ? $row[0] : false;
            
        }
                            
        // get Nr. of draft photos
        public static function counter_unapproved(){
            
            global $db;
            
            $query = "SELECT COUNT(*) FROM photos ";
            $query .= "WHERE (photo_status = 'draft') ";
           
            $result = $db->query($query);
            
            $row = $result->fetch_array(MYSQLI_NUM);
            
            return !empty($row) ? $row[0] : false;
            
        }
                /* ----- ABSTRACT METHODS ----*/

        
                            /* ----- Page photos ----- */

        // get the page photos from DB
        public static function get_page_photos($paginator, $user_id){

            $query = "SELECT * FROM photos ";
            $query .= "WHERE (photo_status = 'published' AND photo_name != '') ";
            
            // Add user_id condition
            if($user_id)
                $query .= "AND (user_id = $user_id) ";
                
            $query .= "LIMIT {$paginator->IPP} ";
            $query .= "OFFSET {$paginator->offset()}";

            return parent::makeQuery($query);
        }

    }
?>

                    <!-- List of features to add in future -->


<!-- 

    ----------
    TODO List:
    ----------

    1.
-->

                            <!-- Deprecated code -->
                            
<!-- 

 
  
   
    
 -->