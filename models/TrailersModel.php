<?php

require_once('core/database.php');

class TrailersModel {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getAllTrailers() {
        $stmt = $this->dbh->prepare('SELECT * FROM trailers');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTrailer($id) {
        $stmt = $this->dbh->prepare('SELECT * FROM trailers WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTrailer($data) {
        $stmt = $this->dbh->prepare('INSERT INTO trailers (title, duration) VALUES (:title, :duration)');
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':duration', $data['duration'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateTrailer($id, $data) {
        $stmt = $this->dbh->prepare('UPDATE trailers SET title = :title, duration = :duration WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':duration', $data['duration'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteTrailer($id) {
        $stmt = $this->dbh->prepare('DELETE FROM trailers WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>
