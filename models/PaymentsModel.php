<?php

require_once('Database.php');

class PaymentsModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addPayment($status, $userNumber, $clientEmail, $clientName, $sessionId) {
        $conn = $this->db->getConnection();

        $stmt = $conn->prepare("INSERT INTO payments (status, user_number, client_email, client_name, session_id) VALUES (:status, :userNumber, :clientEmail, :clientName, :sessionId)");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':userNumber', $userNumber);
        $stmt->bindParam(':clientEmail', $clientEmail);
        $stmt->bindParam(':clientName', $clientName);
        $stmt->bindParam(':sessionId', $sessionId);

        if ($stmt->execute()) {
            // Décrémenter le nombre de tickets restants dans la table sessions
            $this->decrementRemainingTickets($sessionId);

            // Générer le QR code et envoyer l'email
            $this->generateQRCodeAndSendEmail($clientEmail, $sessionId);
        } else {
            return false;
        }
    }

    private function decrementRemainingTickets($sessionId) {
        $conn = $this->db->getConnection();

        $stmt = $conn->prepare("UPDATE sessions SET remaining_tickets = remaining_tickets - 1 WHERE id = :sessionId");
        $stmt->bindParam(':sessionId', $sessionId);
        $stmt->execute();
    }

    private function generateQRCodeAndSendEmail($email, $sessionId) {
        // Obtenir les informations nécessaires pour générer le QR code (par exemple, le numéro de session)
        $qrCodeData = $this->getSessionInfoForQRCode($sessionId);

        // Générer le QR code
        $qrCode = $this->generateQRCode($qrCodeData);

        // Envoyer l'email avec le QR code en pièce jointe
        $subject = 'Confirmation d\'achat de billet';
        $message = 'Merci d\'avoir acheté un billet. Veuillez trouver ci-joint le QR code de votre billet.';
        $this->sendEmailWithQRCode($email, $subject, $message, $qrCode);
    }

    private function getSessionInfoForQRCode($sessionId) {
        // Récupérer les informations nécessaires pour générer le QR code à partir de la session (par exemple, numéro de session, date, heure, etc.)
        // Vous pouvez implémenter votre propre logique pour récupérer ces informations à partir de votre base de données
        // Par exemple, vous pouvez effectuer une requête pour obtenir les détails de la session avec l'ID donné

        // Exemple fictif de récupération des informations de session
        $sessionInfo = [
            'sessionId' => $sessionId,
            'date' => '2023-06-01',
            'time' => '19:30',
            'location' => 'CinEvents Theater'
        ];

        // Convertir les informations de session en une chaîne JSON pour le QR code
        $qrCodeData = json_encode($sessionInfo);

        return $qrCodeData;
    }

    private function generateQRCode($data) {
        // Utilisez une bibliothèque ou un service approprié pour générer le QR code à partir des données fournies
        // Par exemple, vous pouvez utiliser la bibliothèque "endroid/qr-code" en l'installant via Composer
        // Assurez-vous d'ajouter "endroid/qr-code" à votre fichier composer.json et d'exécuter "composer install" pour l'installer
        require_once 'vendor/autoload.php';

        $qrCode = new \Endroid\QrCode\QrCode();
        $qrCode->setText($data);
        $qrCode->setSize(200);

        // Retourne l'image du QR code sous forme de chaîne
        return $qrCode->writeString();
    }

    private function sendEmailWithQRCode($email, $subject, $message, $qrCode) {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->setFrom('noreply@example.com', 'CinEvents');
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Attache le QR code en pièce jointe
        $mail->addStringAttachment($qrCode, 'ticket_qr_code.png');

        // Configuration de l'envoi d'email
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';  // Remplacez par votre serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'your_username';  // Remplacez par votre nom d'utilisateur SMTP
        $mail->Password = 'your_password';  // Remplacez par votre mot de passe SMTP
        $mail->Port = 587;  // Port SMTP à utiliser (peut varier selon votre configuration)

        // Envoi de l'email
        if (!$mail->send()) {
            // Échec de l'envoi de l'email
            echo 'Erreur lors de l\'envoi de l\'email : ' . $mail->ErrorInfo;
        }
    }
}
?>
