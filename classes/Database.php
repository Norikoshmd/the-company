<?php
    class Database{

        private $server_name = "localhost";//127.0.0.1 -- server name
        private $username = "root"; //username
        private $password = ""; //XAMP =="", MAMP =="root"
        private $db_name = "the_company";//database name
        protected $conn; //connection object

        public function __construct(){
            #Initialization of the connection variables
            $this->conn= new mysqli($this->server_name, $this->username, $this->password, $this->db_name);

            #Check if there is an error on the connection object
            #During runtime
            if($this->conn->connect_error){//connect-error built-in function
                #Display error message if there is error
                die("unable to connect to the database. " . $this->conn->error);
            }
        }
    }
?>