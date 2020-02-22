 <?php 

    class DB_object{
        
        
        /* ----- PROPERTIES -----*/
        
        protected $file_status = -1; // value 1 => uploaded properly
                                     // value 0 => didn't upload properly
                                     // value -1 => no file uploaded error
        
        protected $photo_name = "";      
        protected $placeholder_photo = ""; 
        protected $tmp_path = "";    
        protected $upload_dir = "";
        protected $placeholder_photo_url = ""; 
        
        protected $errors = array();
        protected $upload_errors = array(

            UPLOAD_ERR_OK           => "There is no Error.",
            UPLOAD_ERR_INI_SIZE     => "The uploaded file exceeds the upload_max_file directive in php.ini.",
            UPLOAD_ERR_FORM_SIZE    => " The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
            UPLOAD_ERR_PARTIAL      => "The upload file was only partially uploaded.",
            UPLOAD_ERR_NO_FILE      => "No file was uploaded.",
            UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
            UPLOAD_ERR_CANT_WRITE   => "Failed to write file to Disk.",
            UPLOAD_ERR_EXTENSION    => "A PHP extension stoped the file upload"
        );
        
        /* ----- METHODS -----*/
        
        // Instantiate a new object
        protected static function instantiation($record){
           
            $called_class = get_called_class();
            $obj = new $called_class;
            foreach($record as $attribute => $value)
            {
                if($obj->has_attribute($attribute)){
                    $obj->$attribute = $value;
                }
            }
            return $obj;
        }
        
        // has_Attr function (a helper function for Instantiation() function)
        private function has_attribute($attr){
            $obj_properties = get_object_vars($this);
            return array_key_exists($attr, $obj_properties);
        }
        
        
        // create a new object
        public static function create_obj($properties){
            
            
            if(isset($properties) && !empty($properties)){
                
                // create a new object
                $called_class = get_called_class();
                $new_obj = new $called_class;
                
                // loop in class properties
                foreach($properties as $propertie => $value){
                    
                    // check each $property if exists
                    if($new_obj->has_attribute($propertie)){
                        $new_obj->$propertie = $value;
                    }else
                        return false;
                }
                return $new_obj;
            }
            return false;
        }
        

        // get class properties
        protected function properties(){
            
            $properties = array();
            
            foreach(static::$db_table_fields as $table_field){
                if(property_exists($this, $table_field)){
                    $properties[$table_field] = $this->$table_field;
                }
            }
            return $properties;
        }
        
        // get class properties after escaping the string 
        protected function clean_properties(){
            
            global $db;
            $clean_properties = array();
            
            foreach($this->properties() as $key => $value){
                $clean_properties[$key] = $db->escape_string($value);
            }
            return $clean_properties;
        }
        
                        /* ----- CRUD FUNCTIONS ----- */
        
            
        // select all objects from DB
        public static function find_all(){
            
            return static::makeQuery("SELECT * FROM ". static::$db_table ."");
        }
        
        // select one object from DB by id
        public static function find_byID($obj_id){
            
            $id = static::$db_table_fields[0];
            $obj_found = static::makeQuery("SELECT * FROM ". static::$db_table ." WHERE {$id} = $obj_id");
            
            // array_shift() is to return only one object
            return !empty($obj_found) ? array_shift($obj_found) : false;
        }
        
        
        // save a object to switch between create and update
        // if object exists then we update if not then we create 
        public function save(){
            $id = static::$db_table_fields[0];
            return !empty($this->$id) ? $this->update() : $this->create();
        }
    
        
        
        // create an object 
        public function create(){
            
            global $db;
            
            $id = static::$db_table_fields[0];
            $properties = $this->clean_properties();
            
            // get the id out from the propeties
            array_shift($properties);
            
            // put property value between '' if string and remove '' if they are numbers
            $properties_vals = array();
            foreach($properties as $key => $value){
                if(ctype_digit($value))
                    $properties_vals[] = "{$value}";
                else
                    $properties_vals[] = "'{$value}'";
            }
            
            
            $query = "INSERT INTO ". static::$db_table ." (". implode(", ", array_keys($properties)) .") ";
            $query .= "VALUES (". implode(", ", $properties_vals) .")";
            
            
            
            // verify query
            if($db->query($query)){
                
                $this->$id = $db->inserted_id();
                return true;
            }else
                return false;
        }
        
        
        
        // update an object
        public function update(){
            
            global $db;
            
            $id = static::$db_table_fields[0];            
            $properties = $this->clean_properties();
            
            // put the (table_field and property) value together in correct form
            $properties_pairs = array();
            foreach($properties as $key => $value){
                if(ctype_digit($value))
                    $properties_pairs[] = "{$key} = {$value} ";
                else
                    $properties_pairs[] = "{$key} = '{$value}' ";
            }
            
            $query = "UPDATE ". static::$db_table ." SET ";
            $query .= implode(", ", $properties_pairs);
            $query .= " WHERE {$id} = " . $db->escape_string($this->$id); 
            
            $db->query($query);
            
            // verify query
            return ($db->affected_query() == 1) ? true : false;
        }
        
        // delete an object
        public function delete(){
            
            global $db;

            $id = static::$db_table_fields[0];            

            $query = "DELETE FROM ". static::$db_table ." ";
            $query .= "WHERE {$id} = " . $db->escape_string($this->$id);
            
            $db->query($query);
            
            // verify query
            return ($db->affected_query() == 1) ? true : false;            
        }
        
        public function delete_with_file(){
            
            if($this->delete()){
                if($this->photo_name){
                    
                    $target_path = SITE_ROOT . DS . 'admin' . DS . $this->photo_path();
                    return unlink($target_path) ? true : false;
                }
            }else
                return false;
        }
        
                    /* ----- END OF CRUD FUNCTIONS ----- */

        
        // make a Query specific for selecting data from DB
        protected static function makeQuery($sql){
            
            global $db;
            
            $obj_arr = array();
            
            $q_result = $db->query($sql);
            while($row = mysqli_fetch_assoc($q_result))
            {
                $obj_arr[] = static::instantiation($row);                  
            }
            
            return $obj_arr;
        }
        
        
        // photo path and place holder path
        public function photo_path(){
            return !empty($this->photo_name) ? $this -> upload_dir . DS . $this -> photo_name : $this->upload_dir . DS . $this->placeholder_photo;
        }
        
        
        // The function will get $_FILES['upload_file'] superglobal variable as an argument
        public function set_file($file){
            
            if(empty($file) || !$file || !is_array($file)){
            
                $this -> errors[] = "Sorry!, No file uploaded";
            
            }elseif($file['error'] != 0){
                
                // make exception for UPLOAD_ERR_NO_FILE error
                if(UPLOAD_ERR_NO_FILE != $file['error']){
                    
                    $this -> file_status = 0;
                    $this -> errors[] = $this -> upload_errors[$file['error']];
                    return $this -> file_status;
                }
                return $this -> file_status; // byDefault = -1
            
            // Update Case: Check if the new photo name is the same our photo name
            }elseif($this -> photo_name == basename($file['name'])){  
                
                return $this -> file_status;
            }else{
                
                $this -> file_status = 1; 
                
                
                
                // base properties for each file set
                $this -> photo_name = basename($file['name']);
                $this -> tmp_path = $file['tmp_name'];
                
                // extra properties for each file set if exist
                $class_name = get_class($this);
                if(property_exists($class_name, 'photo_type'))
                   $this -> photo_type = $file['type'];
                   
                if(property_exists($class_name, 'photo_size'))
                    $this -> photo_size = $file['size'];
                
                return $this -> file_status;
            }
        }
        
        // in case we wanna unset the file info because for example the file already exist
        public function unset_file(){
            
            // base properties for each file set
            $this -> photo_name = "";
            $this -> tmp_path = "";

            // extra properties for each file set if exist
            $class_name = get_class($this);
            if(property_exists($class_name, 'photo_type'))
               $this -> photo_type = "";

            if(property_exists($class_name, 'photo_size'))
                $this -> photo_size = 0;

            return $this -> file_status;
        }
            
        
        // Ques. #1 is the checkings here only for create or may they can also be used for update
        // Ques. #2 is these if checks down right or should they be nested lik if else statements
        
        public function upload_file(){
            
            $id = static::$db_table_fields[0];
            
            // check first if the file is uploaded properly
            if($this->check_uploaded_file()){
                unset($this->tmp_path);
                return true;
            }
            
            // if could not upload then we reset photo name
            $this -> photo_name = "";
            return false;
        }
    
        // check if the file is uploaded properly
        protected function check_uploaded_file(){
            
            $id = static::$db_table_fields[0];            
            
            // check if errors array is empty
            if(!empty($this->errors) && $this->file_status == 0)
                return false;

            // check if the file status returns -1:
            // -> this case will hapen if we didn't upload a photo
            //    for the user when we created or updated him
            if($this->file_status < 0)
                return true;

            // check if the photo is uploaded properly
            if(empty($this->photo_name) || empty($this->tmp_path)){
                $this -> errors[] =  "The file is not available!";
                return false;
            }

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->photo_path();


            // check the $target_path
            if(file_exists($target_path)){
                
                $this->errors[] = "The file {$this->photo_name} already exist";
                return false;
            }

            // check if uploaded to premanent path properly 
            if(move_uploaded_file($this->tmp_path, $target_path))
                return true;
            else{
                $this->errors[] = "File directory may not have read permission!";
                return false;
            }
        }
        
        // Count table rows
        public static function counter(){
            
            global $db;
            
            $query = "SELECT COUNT(*) FROM " . static::$db_table;
            
            $result = $db->query($query);
            
            $row = $result -> fetch_array(MYSQLI_NUM);
            
            return !empty($row) ? $row[0] : false; 
            
        }
        
        public function compare_properties($obj){
            
            $properties = array();
            
            foreach(static::$db_table_fields as $table_field){
                if(property_exists($this, $table_field))
                    if($this->$table_field != $obj->$table_field)
                        return false;
            }
            return true;
        }
        
        // function to format the file size in more readable way with units
        public function format_bytes($bytes, $precision = 2){
            $units = array('B', 'KB', 'MB', 'GB', 'TB');

            // in case negative input
            $bytes = max($bytes, 0);

            // get the power which indicates one of the units above
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));

            // in case the unit is larger than 'TB'
            $pow = min($pow, count($units) - 1);

            // convert bytes to its closest unit
            $bytes /= (1 << (10 * $pow)); // bit wise method

            return round($bytes, $precision) . ' ' . $units[$pow];
        }
    }

?>

<!-- List of features to add in future -->
<!-- 

    ----------
    TODO List:
    ----------
    
        1. change save_with_file() and save() function to upload file and save.
    
-->


<?php   /* ----- DEPRECATED CODE ----- */ 


                /* --- function Instantiation() : Line 19, 20 --- */




//                    $object_attribute = "set_$object_attribute";
//                    $usr_obj->$object_attribute($value);


    // function has_attribute() alter function : Line 29-32

        // custom function works only for object
//        private function has_attribute($usr_attr){
//            
//            $called_class = get_called_class();
//            $reflectionClass = new ReflectionClass($this);
//            
//            $properties_obj = $reflectionClass->getDefaultProperties();
//
//            $keys = array_keys($properties_obj);
//            if($called_class == 'object'){
//                foreach($keys as $key => $value)
//                    if($usr_attr == $value) return true;
//                return false;
//            }
//        }



                /* --- function save_with_file() : Line 113 - 133 --- */


// changed the function to upload_file()

//public function save_with_file(){
//            
//            $id = static::$db_table_fields[0];
//            
//            // check first if the file is uploaded properly
//            if($this->check_uploaded_file()){
//                
//                if($this->$id){
//                    
//                    if($this->update()){
//                        unset($this->tmp_path);
//                        return true;
//                    }
//                }else{
//
//                    if($this->create()){
//                        unset($this->tmp_path);
//                        return true;
//                    }
//                }
//            }
//            return false;
//        }


                /* --- function create() : Line 128 - 157 --- */

//
// // Hint: Works generic only if properties are strings not numbers
//        // create an object 
//        public function create(){
//            
//            global $db;
//            
//            $id = static::$db_table_fields[0];
//            $properties = $this->clean_properties();
//            
//            // get the id out from the propeties
//            array_shift($properties);
//            
//            $query = "INSERT INTO ". static::$db_table ." (". implode(", ", array_keys($properties)) .") ";
//            $query .= "VALUES ('". implode("', '", array_values($properties)) ."')";
//            
//            // verify query
//            if($db->query($query)){
//                
//                $this->$id = $db->inserted_id();
//                return true;
//            }else
//                return false;
//        }

?>