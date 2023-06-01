<?php

require_once('core/database.php');

class TrailerModel {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getAllTrailers() {
        $query = "SELECT * FROM trailers";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Add methods for getting, adding, updating, and deleting trailers
}

?>