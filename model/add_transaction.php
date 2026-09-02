<?php
session_start();
require_once '../config.php';

// Provera da li je korisnik ulogovan
if (!isset($_SESSION['korisnikID'])) {
    // Ako nije, preusmeri ga na login (ili prikaži grešku)
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validacija da li su sva polja poslata
    if (isset($_POST['datum'], $_POST['kategorijaID'], $_POST['tipTransakcije'], $_POST['iznos'])) {
        
        $korisnikID = $_SESSION['korisnikID'];
        $datum = trim($_POST['datum']);
        $kategorijaID = trim($_POST['kategorijaID']);
        $tipTransakcije = trim($_POST['tipTransakcije']);
        $iznos = filter_var(trim($_POST['iznos']), FILTER_VALIDATE_FLOAT);

        // Provera da li su podaci validni
        if (!empty($datum) && !empty($kategorijaID) && is_numeric($tipTransakcije) && $iznos !== false) {
            try {
                $sql = "INSERT INTO transakcija (korisnikID, kategorijaID, iznos, datum, tipTransakcije) 
                        VALUES (:korisnikID, :kategorijaID, :iznos, :datum, :tipTransakcije)";
                
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindParam(':korisnikID', $korisnikID);
                $stmt->bindParam(':kategorijaID', $kategorijaID);
                $stmt->bindParam(':iznos', $iznos);
                $stmt->bindParam(':datum', $datum);
                $stmt->bindParam(':tipTransakcije', $tipTransakcije);
                
                $stmt->execute();

            } catch (PDOException $e) {
                // Ovde bi trebalo logovati grešku, a ne je prikazivati korisniku
                // Na primer: error_log("Greška pri dodavanju transakcije: " . $e->getMessage());
                // Za sada, samo preusmeravamo nazad.
            }
        }
    }
}

// Preusmeri korisnika nazad na dashboard
header("Location: ../view/dashboard.php");
exit();
?>
