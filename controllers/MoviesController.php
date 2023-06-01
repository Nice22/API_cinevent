<?php

require_once('core/database.php');
require_once('models/MovieModel.php');

$database = new Database();
$dbh = $database->getDBConnection();

$movieModel = new MovieModel($dbh);

// GET all movies
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    $movies = $movieModel->getAllMovies();
    echo json_encode($movies);
}

// GET movie by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $movie = $movieModel->getMovie($id);
    echo json_encode($movie);
}

// POST add movie
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $movieModel->addMovie($data);
}

// PUT update movie
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = json_decode(file_get_contents('php://input'), true);
    $movieModel->updateMovie($id, $data);
}

// DELETE delete movie
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $movieModel->deleteMovie($id);
}

?>
