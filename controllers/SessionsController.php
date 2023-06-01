<?php

require_once('core/database.php');
require_once('models/SessionsModel.php');

$database = new Database();
$dbh = $database->getDBConnection();

$sessionModel = new SessionsModel($dbh);

// GET all sessions
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    getAllSessions();
}

// GET session by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    getSessionById();
}

// POST add session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addSession();
}

// PUT update session
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    updateSession();
}

// DELETE delete session
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    deleteSession();
}

function getAllSessions() {
    global $sessionModel;
    $sessions = $sessionModel->getAllSessions();
    header('Content-Type: application/json');
    echo json_encode($sessions);
}

function getSessionById() {
    global $sessionModel;
    $id = $_GET['id'];
    $session = $sessionModel->getSession($id);
    header('Content-Type: application/json');
    echo json_encode($session);
}

function addSession() {
    global $sessionModel;
    $data = json_decode(file_get_contents('php://input'), true);
    $sessionModel->addSession($data);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Session ajoutée avec succès']);
}

function updateSession() {
    global $sessionModel;
    $id = $_GET['id'];
    $data = json_decode(file_get_contents('php://input'), true);
    $sessionModel->updateSession($id, $data);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Session mise à jour avec succès']);
}

function deleteSession() {
    global $sessionModel;
    $id = $_GET['id'];
    $sessionModel->deleteSession($id);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Session supprimée avec succès']);
}

?>
