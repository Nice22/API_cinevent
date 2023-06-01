<?php

require_once('core/database.php');

class MovieModel {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getAllMovies() {
        $stmt = $this->dbh->prepare('SELECT * FROM movies');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMovie($id) {
        $stmt = $this->dbh->prepare('SELECT * FROM movies WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addMovie($data) {
        $stmt = $this->dbh->prepare('INSERT INTO movies (title, director, release_date) VALUES (:title, :director, :release_date)');
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':director', $data['director'], PDO::PARAM_STR);
        $stmt->bindParam(':release_date', $data['release_date'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateMovie($id, $data) {
        $stmt = $this->dbh->prepare('UPDATE movies SET title = :title, director = :director, release_date = :release_date WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':director', $data['director'], PDO::PARAM_STR);
        $stmt->bindParam(':release_date', $data['release_date'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteMovie($id) {
        $stmt = $this->dbh->prepare('DELETE FROM movies WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>
