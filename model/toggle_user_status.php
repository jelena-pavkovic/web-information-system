<?php
session_start();
require_once '../config.php';

// Provera da li je korisnik ulogovan i da li je admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['tipKorisnika'] != 1) {
    header("Location: ../view/dashboard.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $korisnikID = $_GET['id'];

    try {
        // Prvo proveri trenutni status korisnika
        $stmt = $pdo->prepare("SELECT status FROM korisnik WHERE korisnikID = :id");
        $stmt->bindParam(':id', $korisnikID);
        $stmt->execute();
        $korisnik = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($korisnik) {
            // Promeni status (ako je 1 postavi na 0, ako je 0 postavi na 1)
            $noviStatus = $korisnik['status'] == 1 ? 0 : 1;

            $update_stmt = $pdo->prepare("UPDATE korisnik SET status = :status WHERE korisnikID = :id");
            $update_stmt->bindParam(':status', $noviStatus);
            $update_stmt->bindParam(':id', $korisnikID);
            $update_stmt->execute();
        }
    } catch (PDOException $e) {
        // U idealnom slučaju, ovde bi se logovala greška
    }
}

// Vrati admina na admin panel
header("Location: ../view/admin.php");
exit();
?>
