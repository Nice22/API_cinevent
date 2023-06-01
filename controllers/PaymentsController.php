<?php

require_once('core/database.php');
require_once('models/PaymentsModel.php');

$database = new Database();
$dbh = $database->getDBConnection();

$paymentsModel = new PaymentsModel($dbh);

// GET all payments
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
    getAllPayments();
}

// GET payment by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    getPaymentById();
}

// POST add payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addPayment();
}

// PUT update payment
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    updatePayment();
}

// DELETE delete payment
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    deletePayment();
}

function getAllPayments() {
    global $paymentsModel;
    $payments = $paymentsModel->getAllPayments();
    echo json_encode($payments);
}

function getPaymentById() {
    global $paymentsModel;
    $id = $_GET['id'];
    $payment = $paymentsModel->getPayment($id);
    echo json_encode($payment);
}

function addPayment() {
    global $paymentsModel;
    $data = json_decode(file_get_contents('php://input'), true);
    $paymentsModel->addPayment($data);
}

function updatePayment() {
    global $paymentsModel;
    $id = $_GET['id'];
    $data = json_decode(file_get_contents('php://input'), true);
    $paymentsModel->updatePayment($id, $data);
}

function deletePayment() {
    global $paymentsModel;
    $id = $_GET['id'];
    $paymentsModel->deletePayment($id);
}

?>
