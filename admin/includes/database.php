<?php require_once("new_config.php");

    class Database{
        
    // ------- Properties -------
        private static $instance = NULL;
        private $connection;
         
    // ------- Methodes -------
        
        // Constructor
        // The db connection function is called within the private constructor.
        private function __construct(){
            $this->open_connection_db();
        }
        
        
        // Establish a DB Connection using mysqli object
        public function open_connection_db(){
            $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            // Validation
            if($this->connection->connect_errno)
                echo "CONNECTION FAILED! " . $this->connection->connect_error;
        }
        
        
        // create one object within the class (singleton)
        public static function get_instance(){
            if(!self::$instance)
                self::$instance = new Database();
            
            return self::$instance;
        }
        
        public function get_connection(){
            return $this->connection;
        }
        
        
        // Making a Query
        public function query($sql){
            $q_result = $this->connection->query($sql);
            
            // Validation
            if(!$q_result)
                die("QUERY FAILED! " . $this->connection->connect_error);
            
            return $q_result;
        }
        
        // escaping sql strings
        public function escape_string($string){
            
            return $this->connection->real_escape_string($string);
        }
        
        
        // getting the already inserted id
        public function inserted_id(){
            return $this->connection->insert_id;
        }
        
        // getting affected rows from last operation
        public function affected_query(){
            return $this->connection->affected_rows;
        }
    }
    
    $db = Database::get_instance(); 
    $connection = $db->get_connection();
?>




<!-- List of features to add in future -->


<!-- Deprecated Code -->
<?php 
                    
                    /* query() function line : 43 */
//            $q_result = mysqli_query($this->connection, $sql);

?>

