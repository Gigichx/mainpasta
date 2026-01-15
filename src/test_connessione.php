<?php
/**
 * File di test per verificare la connessione al database
 * IMPORTANTE: Eliminare questo file dopo il test!
 */

require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Connessione - BariPasta Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="box">
        <h1>🍝 BariPasta Manager - Test Sistema</h1>
        
        <h2>1. Connessione Database</h2>
        <?php if ($conn): ?>
            <p class="success">✅ Connessione al database riuscita!</p>
            <p>Database: <strong><?php echo DB_NAME; ?></strong></p>
        <?php else: ?>
            <p class="error">❌ Errore connessione database</p>
        <?php endif; ?>
    </div>

    <div class="box">
        <h2>2. Verifica Tabelle</h2>
        <?php
        // Verifica esistenza tabelle
        $tabelle = ['gestori', 'ordini'];
        $tutteOk = true;
        
        foreach ($tabelle as $tabella) {
            $query = "SHOW TABLES LIKE '$tabella'";
            $result = $conn->query($query);
            
            if ($result && $result->num_rows > 0) {
                echo "<p class='success'>✅ Tabella '$tabella' trovata</p>";
            } else {
                echo "<p class='error'>❌ Tabella '$tabella' non trovata</p>";
                $tutteOk = false;
            }
        }
        ?>
    </div>

    <div class="box">
        <h2>3. Verifica Utente Admin</h2>
        <?php
        $query = "SELECT username, nome FROM gestori WHERE username = 'admin'";
        $result = $conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            echo "<p class='success'>✅ Utente admin trovato</p>";
            echo "<table>";
            echo "<tr><th>Username</th><th>Nome</th></tr>";
            echo "<tr><td>{$admin['username']}</td><td>{$admin['nome']}</td></tr>";
            echo "</table>";
            echo "<p><em>Password di default: <strong>bari2024</strong></em></p>";
        } else {
            echo "<p class='error'>❌ Utente admin non trovato</p>";
        }
        ?>
    </div>

    <div class="box">
        <h2>4. Informazioni Server</h2>
        <table>
            <tr>
                <th>Parametro</th>
                <th>Valore</th>
            </tr>
            <tr>
                <td>Versione PHP</td>
                <td><?php echo phpversion(); ?></td>
            </tr>
            <tr>
                <td>Versione MySQL</td>
                <td><?php echo $conn->server_info; ?></td>
            </tr>
            <tr>
                <td>Server</td>
                <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
            </tr>
        </table>
    </div>

    <div class="box">
        <p><strong>⚠️ IMPORTANTE:</strong> Dopo aver verificato che tutto funziona, <strong>elimina questo file</strong> per sicurezza!</p>
    </div>
</body>
</html>
<?php
$conn->close();
?>