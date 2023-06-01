<?php

require_once('core/database.php');
require_once('models/TrailersModel.php');

$database = new Database();
$dbh = $database->getDBConnection();

$trailerModel = new TrailersModel($dbh);

// GET all trailers
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    getAllTrailers();
}

// GET trailer by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    getTrailerById();
}

// POST add trailer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addTrailer();
}

// PUT update trailer
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    updateTrailer();
}

// DELETE delete trailer
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    deleteTrailer();
}

function getAllTrailers() {
    global $trailerModel;
    $trailers = $trailerModel->getAllTrailers();
    header('Content-Type: application/json');
    echo json_encode($trailers);
}

function getTrailerById() {
    global $trailerModel;
    $id = $_GET['id'];
    $trailer = $trailerModel->getTrailer($id);
    header('Content-Type: application/json');
    echo json_encode($trailer);
}

function addTrailer() {
    global $trailerModel;
    $data = json_decode(file_get_contents('php://input'), true);
    $trailerModel->addTrailer($data);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Trailer ajouté avec succès']);
}

function updateTrailer() {
    global $trailerModel;
    $id = $_GET['id'];
    $data = json_decode(file_get_contents('php://input'), true);
    $trailerModel->updateTrailer($id, $data);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Trailer mis à jour avec succès']);
}

function deleteTrailer() {
    global $trailerModel;
    $id = $_GET['id'];
    $trailerModel->deleteTrailer($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Trailer supprimé avec succès']);
}

?>
