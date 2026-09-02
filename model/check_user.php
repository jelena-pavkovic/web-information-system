<?php
session_start(); 

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Molimo popunite sva polja.";
        header("Location: ../index.php");
        exit();
    }
    
    try {
        // Priprema SQL upita za proveru korisnika u tabeli `korisnik`
        $stmt = $pdo->prepare("SELECT * FROM korisnik WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Provera da li je korisnik aktivan
            if ($user['status'] == 1) {
                // --- USPEŠNA PRIJAVA ---
                $_SESSION['user_logged_in'] = true;
                $_SESSION['korisnikID'] = $user['korisnikID'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_ime'] = $user['ime'];
                $_SESSION['user_prezime'] = $user['prezime'];
                $_SESSION['tipKorisnika'] = $user['tipKorisnika'];
                
                if ($_SESSION['tipKorisnika'] == 1) {
                    header("Location: ../view/admin.php");
                } else {
                    header("Location: ../view/dashboard.php");
                }
                exit();
            } else {
                // --- KORISNIK NIJE AKTIVAN ---
                $_SESSION['error_message'] = "Vaš nalog nije aktivan.";
                header("Location: ../index.php");
                exit();
            }
        } else {
            // --- NEUSPEŠNA PRIJAVA ---
            $_SESSION['error_message'] = "Neispravan email ili lozinka.";
            header("Location: ../index.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Greška pri radu sa bazom podataka: " . $e->getMessage();
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>