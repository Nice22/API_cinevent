<?php

require_once('core/database.php');

class PaymentsModel {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getAllPayments() {
        $query = "SELECT * FROM payments";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $payments;
    }

    public function getPayment($id) {
        $query = "SELECT * FROM payments WHERE id = :id";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);
        return $payment;
    }

    public function addPayment($data) {
        $status = $data['status'];
        $userNumber = $data['userNumber'];
        $clientEmail = $data['clientEmail'];
        $clientName = $data['clientName'];
        $sessionId = $data['sessionId'];

        $query = "INSERT INTO payments (status, userNumber, clientEmail, clientName, sessionId)
                  VALUES (:status, :userNumber, :clientEmail, :clientName, :sessionId)";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':userNumber', $userNumber, PDO::PARAM_INT);
        $stmt->bindParam(':clientEmail', $clientEmail, PDO::PARAM_STR);
        $stmt->bindParam(':clientName', $clientName, PDO::PARAM_STR);
        $stmt->bindParam(':sessionId', $sessionId, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function updatePayment($id, $data) {
        $status = $data['status'];
        $userNumber = $data['userNumber'];
        $clientEmail = $data['clientEmail'];
        $clientName = $data['clientName'];
        $sessionId = $data['sessionId'];

        $query = "UPDATE payments SET status = :status, userNumber = :userNumber, clientEmail = :clientEmail,
                  clientName = :clientName, sessionId = :sessionId WHERE id = :id";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':userNumber', $userNumber, PDO::PARAM_INT);
        $stmt->bindParam(':clientEmail', $clientEmail, PDO::PARAM_STR);
        $stmt->bindParam(':clientName', $clientName, PDO::PARAM_STR);
        $stmt->bindParam(':sessionId', $sessionId, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function deletePayment($id) {
        $query = "DELETE FROM payments WHERE id = :id";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
}

?>
