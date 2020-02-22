<?php 

    class Comment extends DB_object{
    
        /* ----- PROPERTIES ----- */
        
        /* --- GENERIC NAMES --- */
        protected static $db_table_fields = array("comment_id", "photo_id", "comment_author", "comment_body", "comment_date", "comment_status", "user_id");
        protected static $db_table = "comments";
        
        /* --- Class Table Properties --- */
        protected $comment_id = 0;
        protected $photo_id = 0;
        protected $comment_author = "";
        protected $comment_body = "";
        protected $comment_date = "";
        protected $comment_status = "";
        protected $user_id = 0;
        
        
        /* ----- METHODS ----- */
        
        
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
        
        
        // find comments by photo ID
        public static function find_comm_by_photoID($photo_id = 0){
            
            global $db;
            
            $qeury = "SELECT * FROM comments ";
            $qeury .= "WHERE photo_id = " . $db->escape_string($photo_id);
            $qeury .= " ORDER BY photo_id ";
            
            return self::makeQuery($qeury);
        } 
        
        
                     
        // get Nr. of pinned comments
        public static function pinned_counter(){
            
            global $db;
            
            $query = "SELECT COUNT(*) FROM comments ";
            $query .= "WHERE (comment_status = 'pinned') ";
           
            $result = $db->query($query);
            
            $row = $result->fetch_array(MYSQLI_NUM);
            
            return !empty($row) ? $row[0] : false;
            
        }
        
                     
        // get Nr. of unpinned comments
        public static function unpinned_counter(){
            
            global $db;
            
            $query = "SELECT COUNT(*) FROM comments ";
            $query .= "WHERE (comment_status = 'unpinned') ";
           
            $result = $db->query($query);
            
            $row = $result->fetch_array(MYSQLI_NUM);
            
            return !empty($row) ? $row[0] : false;
            
        }
        
    }
?>

<!-- List of features to add in future -->

<!-- 

    ----------
    TODO List:
    ----------
    
        1. try make generic create() function using array and properties_exist()
           and put it in db_object class.
-->

                               
                                <!-- DEPRECATED CODE -->

<!--
       
        Line : 60
        ---------
            
            
            if(!empty($photo_id) && !empty($comment_author) && !empty($comment_body) && !empty($comment_date) && !empty($user_id))
            {
                $comment = new Comment();
                
                $comment -> photo_id = (int)$photo_id;
                $comment -> comment_author = $comment_author;
                $comment -> comment_body = $comment_body;
                
                
                return $comment;
            }else
                return false;-->
