<?php

require_once('core/database.php');

class MovieModel {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getAllMovies() {
        $query = "SELECT * FROM movies";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMovie($id) {
        $query = "SELECT * FROM movies WHERE id = :id";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addMovie($movieData) {
        $query = "INSERT INTO movies (movie_name, long_name, synopsis, director, actors, release_date, trailer_id) 
                  VALUES (:movie_name, :long_name, :synopsis, :director, :actors, :release_date, :trailer_id)";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':movie_name', $movieData['movie_name'], PDO::PARAM_STR);
        $stmt->bindParam(':long_name', $movieData['long_name'], PDO::PARAM_STR);
        $stmt->bindParam(':synopsis', $movieData['synopsis'], PDO::PARAM_STR);
        $stmt->bindParam(':director', $movieData['director'], PDO::PARAM_STR);
        $stmt->bindParam(':actors', $movieData['actors'], PDO::PARAM_STR);
        $stmt->bindParam(':release_date', $movieData['release_date'], PDO::PARAM_STR);
        $stmt->bindParam(':trailer_id', $movieData['trailer_id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateMovie($id, $movieData) {
        $query = "UPDATE movies SET movie_name = :movie_name, long_name = :long_name, synopsis = :synopsis, 
                  director = :director, actors = :actors, release_date = :release_date, trailer_id = :trailer_id 
                  WHERE id = :id";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':movie_name', $movieData['movie_name'], PDO::PARAM_STR);
        $stmt->bindParam(':long_name', $movieData['long_name'], PDO::PARAM_STR);
        $stmt->bindParam(':synopsis', $movieData['synopsis'], PDO::PARAM_STR);
        $stmt->bindParam(':director', $movieData['director'], PDO::PARAM_STR);
        $stmt->bindParam(':actors', $movieData['actors'], PDO::PARAM_STR);
        $stmt->bindParam(':release_date', $movieData['release_date'], PDO::PARAM_STR);
        $stmt->bindParam(':trailer_id', $movieData['trailer_id'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteMovie($id) {
        $query = "DELETE FROM movies WHERE id = :id";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

?>