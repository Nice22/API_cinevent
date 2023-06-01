<?php

require_once('core/database.php');
require_once('models/TrailersModel.php');


$database = new Database();
$dbh = $database->getDBConnection();

$trailerModel = new TrailersModel($dbh);

// GET all trailers
function getAllTrailers() {
    global $trailerModel;
    $trailers = $trailerModel->getAllTrailers();
    echo json_encode($trailers);
}

// GET trailer by ID
function getTrailerById() {
    global $trailerModel;
    $id = $_GET['id'];
    $trailer = $trailerModel->getTrailer($id);
    echo json_encode($trailer);
}

// POST add trailer
function addTrailer() {
    global $trailerModel;
    $data = json_decode(file_get_contents('php://input'), true);
    $trailerModel->addTrailer($data);
}

// PUT update trailer
function updateTrailer() {
    global $trailerModel;
    $id = $_GET['id'];
    $data = json_decode(file_get_contents('php://input'), true);
    $trailerModel->updateTrailer($id, $data);
}

// DELETE delete trailer
function deleteTrailer() {
    global $trailerModel;
    $id = $_GET['id'];
    $trailerModel->deleteTrailer($id);
}

?>
