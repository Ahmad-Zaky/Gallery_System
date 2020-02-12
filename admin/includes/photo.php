<?php 

    class Photo extends DB_object{
    
        /* ----- PROPERTIES ----- */
        
        /* --- GENERIC NAMES --- */
        protected static $db_table_fields = array("photo_id", "photo_title", "photo_caption", "photo_description", "photo_name", "photo_alternate_text", "photo_type", "photo_size");
        protected static $db_table = "photos";

        /* --- Class Table Properties --- */
        protected $photo_id = 0;
        protected $photo_title = "";
        protected $photo_caption = "";
        protected $photo_description = "";
        protected $photo_name = "";
        protected $photo_alternate_text = "";
        protected $photo_type = "";
        protected $photo_size = "";
        
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
    }
?>

<!-- List of features to add in future -->