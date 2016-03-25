<?php

class near_connect {

    private $conn;

    function __construct() {        
    }

    /**
     * Establishing database connection
     * @return database connection handler
     */
    function connect() {
        /**
         * Database configuration
         */
        $near_config['DB_HOST'] = 'localhost';
        $near_config['DB_USERNAME'] = 'root';
        $near_config['DB_PASSWORD'] = '123';
        $near_config['DB_NAME'] = 'neardb';
        // Connecting to mysql database
        $this->conn = new mysqli($near_config['DB_HOST'],$near_config['DB_USERNAME'],$near_config['DB_PASSWORD'],$near_config['DB_NAME']);

        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // returing connection resource
        return $this->conn;
    }

}

?>
