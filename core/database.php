<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'cinevent';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create the movies table
            $query = "CREATE TABLE IF NOT EXISTS movies (
                id INT(11) PRIMARY KEY AUTO_INCREMENT,
                movie_name VARCHAR(255) NOT NULL,
                long_name VARCHAR(255) NOT NULL,
                synopsis TEXT NOT NULL,
                director VARCHAR(255) NOT NULL,
                actors VARCHAR(255) NOT NULL,
                release_date DATE NOT NULL,
                trailer_id INT(11) NOT NULL
            )";
            $this->conn->exec($query);

            // Create the sessions table
            $query = "CREATE TABLE IF NOT EXISTS sessions (
                id INT(11) PRIMARY KEY AUTO_INCREMENT,
                movie_id INT(11) NOT NULL,
                day DATE NOT NULL,
                time TIME NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                FOREIGN KEY (movie_id) REFERENCES movies(id)
            )";
            $this->conn->exec($query);

            // Create the trailers table
            $query = "CREATE TABLE IF NOT EXISTS trailers (
                id INT(11) PRIMARY KEY AUTO_INCREMENT,
                link VARCHAR(255) NOT NULL
            )";
            $this->conn->exec($query);

            // Create the payments table
            $query = "CREATE TABLE IF NOT EXISTS payments (
                id INT(11) PRIMARY KEY AUTO_INCREMENT,
                status VARCHAR(50) NOT NULL,
                user_number VARCHAR(20) NOT NULL,
                client_email VARCHAR(255) NOT NULL,
                client_name VARCHAR(255) NOT NULL,
                session_id INT(11) NOT NULL,
                FOREIGN KEY (session_id) REFERENCES sessions(id)
            )";
            $this->conn->exec($query);
        } catch(PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    
    public function getDBConnection() {
        return $this->conn;
    }
}



?>
