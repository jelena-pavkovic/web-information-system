<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_logged_in']) || $_SESSION['tipKorisnika'] != 1) {
    header("Location: ../view/dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['naziv'], $_POST['tipKategorije'])) {
        $naziv = trim($_POST['naziv']);
        $tipKategorije = $_POST['tipKategorije'];

        if (!empty($naziv) && is_numeric($tipKategorije)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO kategorija (naziv, tipKategorije) VALUES (:naziv, :tip)");
                $stmt->bindParam(':naziv', $naziv);
                $stmt->bindParam(':tip', $tipKategorije);
                $stmt->execute();
            } catch (PDOException $e) {
                // Log error
            }
        }
    }
}

header("Location: ../view/admin.php");
exit();
?>
