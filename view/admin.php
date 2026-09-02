<?php
session_start();
require_once '../config.php';

// Provera da li je korisnik ulogovan i da li je admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true || $_SESSION['tipKorisnika'] != 1) {
    // Ako nije admin, preusmeri ga na dashboard ili login
    header("Location: dashboard.php");
    exit();
}

try {
    // Dohvatanje svih korisnika
    $korisnici_stmt = $pdo->query("SELECT korisnikID, email, ime, prezime, status FROM korisnik ORDER BY ime, prezime");
    $korisnici = $korisnici_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Dohvatanje svih kategorija
    $kategorije_stmt = $pdo->query("SELECT kategorijaID, naziv, tipKategorije FROM kategorija ORDER BY naziv");
    $kategorije = $kategorije_stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Greška pri dohvatanju podataka iz baze: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <form action="../model/logout.php" method="POST" class="logout-form">
            <button type="submit" class="logout-button">Odjavi se</button>
        </form>
        <h2>Admin Panel</h2>

        <!-- Upravljanje korisnicima -->
        <div class="admin-section">
            <h3>Korisnici</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Ime i Prezime</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Akcija</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($korisnici as $korisnik): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($korisnik['ime'] . ' ' . $korisnik['prezime']); ?></td>
                            <td><?php echo htmlspecialchars($korisnik['email']); ?></td>
                            <td><?php echo $korisnik['status'] == 1 ? 'Aktivan' : 'Neaktivan'; ?></td>
                            <td>
                                <a href="../model/toggle_user_status.php?id=<?php echo $korisnik['korisnikID']; ?>" class="action-button">
                                    <?php echo $korisnik['status'] == 1 ? 'Deaktiviraj' : 'Aktiviraj'; ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Upravljanje kategorijama -->
        <div class="admin-section">
            <h3>Kategorije</h3>
            <div class="category-management">
                <form action="../model/add_category.php" method="POST" class="category-form">
                    <h4>Dodaj Novu Kategoriju</h4>
                    <div class="form-group">
                        <label for="naziv">Naziv Kategorije:</label>
                        <input type="text" id="naziv" name="naziv" required>
                    </div>
                    <div class="form-group">
                        <label for="tipKategorije">Tip Kategorije:</label>
                        <select id="tipKategorije" name="tipKategorije" required>
                            <option value="1">Prihod</option>
                            <option value="0">Rashod</option>
                        </select>
                    </div>
                    <button type="submit" class="submit-button">Dodaj</button>
                </form>

                <table class="admin-table category-table">
                    <thead>
                        <tr>
                            <th>Naziv</th>
                            <th>Tip</th>
                            <th>Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kategorije as $kategorija): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($kategorija['naziv']); ?></td>
                                <td><?php echo $kategorija['tipKategorije'] == 1 ? 'Prihod' : 'Rashod'; ?></td>
                                <td>
                                    <!-- Funkcionalnost za izmenu i brisanje se može dodati ovde -->
                                    <a href="#" class="action-button edit">Izmeni</a>
                                    <a href="../model/delete_category.php?id=<?php echo $kategorija['kategorijaID']; ?>" class="action-button delete">Obriši</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
