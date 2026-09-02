<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: ../index.php");
    exit();
}

$korisnikID = $_SESSION['korisnikID'];
$ime = $_SESSION['user_ime'];
$prezime = $_SESSION['user_prezime'];

try {
    // Dohvatanje SVIH kategorija, zajedno sa njihovim tipom
    $kategorije_stmt = $pdo->query("SELECT kategorijaID, naziv, tipKategorije FROM kategorija ORDER BY naziv");
    $kategorije = $kategorije_stmt->fetchAll(PDO::FETCH_ASSOC);

    $trans_stmt = $pdo->prepare(
        "SELECT t.datum, k.naziv AS kategorija_naziv, t.tipTransakcije, t.iznos 
         FROM transakcija t 
         JOIN kategorija k ON t.kategorijaID = k.kategorijaID 
         WHERE t.korisnikID = :korisnikID 
         ORDER BY t.datum DESC"
    );
    $trans_stmt->bindParam(':korisnikID', $korisnikID);
    $trans_stmt->execute();
    $transakcije = $trans_stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Greška pri dohvatanju podataka iz baze.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <form action="../model/logout.php" method="POST" class="logout-form">
            <button type="submit" class="logout-button">Odjavi se</button>
        </form>
        <h2>Dobrodošli, <?php echo htmlspecialchars($ime . ' ' . $prezime); ?>!</h2>
        
        <h3>Unos Nove Transakcije</h3>
        <form action="../model/add_transaction.php" method="POST">
            <div class="form-group">
                <label for="datum">Datum:</label>
                <input type="date" id="datum" name="datum" required>
            </div>
            <div class="form-group">
                <label for="tipTransakcije">Tip Transakcije:</label>
                <select id="tipTransakcije" name="tipTransakcije" required>
                    <option value="" disabled selected>Prvo izaberite tip</option>
                    <option value="1">Prihod</option>
                    <option value="0">Rashod</option>
                </select>
            </div>
            <div class="form-group">
                <label for="kategorijaID">Kategorija:</label>
                <select id="kategorijaID" name="kategorijaID" required disabled>
                    <option value="" disabled selected>Izaberite kategoriju</option>
                    <?php foreach ($kategorije as $kategorija): ?>
                        <option value="<?php echo $kategorija['kategorijaID']; ?>" data-tip="<?php echo $kategorija['tipKategorije']; ?>" style="display:none;">
                            <?php echo htmlspecialchars($kategorija['naziv']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="iznos">Iznos:</label>
                <input type="number" id="iznos" name="iznos" step="0.01" required>
            </div>
            <button type="submit" class="submit-button">Dodaj Transakciju</button>
        </form>

        <h3>Pregled Transakcija</h3>
        <table class="transactions-table">
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Kategorija</th>
                    <th>Tip</th>
                    <th>Iznos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transakcije as $t): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($t['datum']); ?></td>
                        <td><?php echo htmlspecialchars($t['kategorija_naziv']); ?></td>
                        <td><?php echo $t['tipTransakcije'] == 1 ? 'Prihod' : 'Rashod'; ?></td>
                        <td><?php echo number_format($t['iznos'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($transakcije)): ?>
                    <tr>
                        <td colspan="4">Nema unetih transakcija.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipSelect = document.getElementById('tipTransakcije');
            const kategorijaSelect = document.getElementById('kategorijaID');
            const kategorijaOptions = kategorijaSelect.querySelectorAll('option[data-tip]');

            tipSelect.addEventListener('change', function() {
                const selectedTip = this.value;
                
                // Resetuj i omogući izbor kategorije
                kategorijaSelect.value = '';
                kategorijaSelect.disabled = false;

                // Prikazi samo relevantne kategorije
                kategorijaOptions.forEach(function(option) {
                    if (option.getAttribute('data-tip') === selectedTip) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            });
        });
    </script>

</body>
</html>