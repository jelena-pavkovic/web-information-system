<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_logged_in']) || $_SESSION['tipKorisnika'] != 1) {
    header("Location: ../view/dashboard.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $kategorijaID = $_GET['id'];

    try {
        // Pre brisanja kategorije, razmislite o tome šta uraditi sa transakcijama koje je koriste.
        // Najjednostavnija opcija je brisanje, ali to može narušiti integritet podataka.
        // Alternativa je postaviti kategorijaID na NULL u transakcijama, ako je dozvoljeno.
        // Za sada, brišemo samo kategoriju.
        
        $stmt = $pdo->prepare("DELETE FROM kategorija WHERE kategorijaID = :id");
        $stmt->bindParam(':id', $kategorijaID);
        $stmt->execute();
    } catch (PDOException $e) {
        // Log error
    }
}

header("Location: ../view/admin.php");
exit();
?>
