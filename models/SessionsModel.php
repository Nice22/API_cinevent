<?php

require_once('core/database.php');

class SessionsModel {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getAllSessions() {
        $stmt = $this->dbh->prepare('SELECT * FROM sessions');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSession($id) {
        $stmt = $this->dbh->prepare('SELECT * FROM sessions WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSession($data) {
        $stmt = $this->dbh->prepare('INSERT INTO sessions (name, duration, remaining_passes) VALUES (:name, :duration, :remaining_passes)');
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':duration', $data['duration'], PDO::PARAM_STR);
        $stmt->bindParam(':remaining_passes', $data['remaining_passes'], PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateSession($id, $data) {
        $stmt = $this->dbh->prepare('UPDATE sessions SET name = :name, duration = :duration, remaining_passes = :remaining_passes WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':duration', $data['duration'], PDO::PARAM_STR);
        $stmt->bindParam(':remaining_passes', $data['remaining_passes'], PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteSession($id) {
        $stmt = $this->dbh->prepare('DELETE FROM sessions WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getRemainingPasses($sessionId) {
        $stmt = $this->dbh->prepare('SELECT remaining_passes FROM sessions WHERE id = :sessionId');
        $stmt->bindParam(':sessionId', $sessionId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}

?>
