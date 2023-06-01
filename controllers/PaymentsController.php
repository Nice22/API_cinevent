<?php

require_once('models/PaymentsModel.php');

class PaymentsController {
    private $paymentsModel;

    public function __construct() {
        $this->paymentsModel = new PaymentsModel();
    }

    public function addPayment($status, $userNumber, $clientEmail, $clientName, $sessionId) {
        // Effectuer les validations nécessaires sur les données reçues

        // Appeler la méthode addPayment du modèle pour ajouter le paiement
        $result = $this->paymentsModel->addPayment($status, $userNumber, $clientEmail, $clientName, $sessionId);

        if ($result) {
            // Paiement ajouté avec succès
            echo 'Paiement effectué avec succès !';
        } else {
            // Erreur lors de l'ajout du paiement
            echo 'Erreur lors du paiement. Veuillez réessayer.';
        }
    }
}

?>
