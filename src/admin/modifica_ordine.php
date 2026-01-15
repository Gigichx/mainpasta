<?php
/**
 * Modifica Ordine
 * BariPasta Manager
 */

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

richiedeLogin();

$messaggio = '';
$errore = '';
$ordine = null;

// Verifica ID ordine
$ordine_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($ordine_id <= 0) {
    header("Location: dashboard.php");
    exit();
}

// Carica dati ordine
$query = "SELECT * FROM ordini WHERE id = $ordine_id";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    $errore = "Ordine non trovato";
} else {
    $ordine = $result->fetch_assoc();
}

// Gestione form modifica
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $ordine) {
    $cliente_nome = pulisciInput($conn, $_POST['cliente_nome'] ?? '');
    $cliente_telefono = pulisciInput($conn, $_POST['cliente_telefono'] ?? '');
    $tipo_pasta = pulisciInput($conn, $_POST['tipo_pasta'] ?? '');
    $peso_kg = floatval($_POST['peso_kg'] ?? 0);
    $data_consegna = pulisciInput($conn, $_POST['data_consegna'] ?? '');
    $stato = pulisciInput($conn, $_POST['stato'] ?? 'In Attesa');
    $priorita = pulisciInput($conn, $_POST['priorita'] ?? 'Media');
    $note = pulisciInput($conn, $_POST['note'] ?? '');
    
    // Validazione
    if (empty($cliente_nome)) {
        $errore = 'Il nome del cliente è obbligatorio';
    } elseif (empty($tipo_pasta)) {
        $errore = 'Seleziona un tipo di pasta';
    } elseif ($peso_kg <= 0) {
        $errore = 'Il peso deve essere maggiore di zero';
    } elseif (empty($data_consegna)) {
        $errore = 'La data di consegna è obbligatoria';
    } else {
        // Aggiorna nel database
        $query = "UPDATE ordini SET 
                  cliente_nome = '$cliente_nome',
                  cliente_telefono = '$cliente_telefono',
                  tipo_pasta = '$tipo_pasta',
                  peso_kg = $peso_kg,
                  data_consegna = '$data_consegna',
                  stato = '$stato',
                  priorita = '$priorita',
                  note = '$note'
                  WHERE id = $ordine_id";
        
        if ($conn->query($query)) {
            $messaggio = 'Ordine modificato con successo!';
            // Ricarica dati aggiornati
            $result = $conn->query("SELECT * FROM ordini WHERE id = $ordine_id");
            $ordine = $result->fetch_assoc();
        } else {
            $errore = 'Errore durante la modifica: ' . $conn->error;
        }
    }
}

$tipiPasta = ['Orecchiette', 'Cavatelli', 'Strascinati', 'Troccoli', 'Maccheroncini'];
$stati = ['In Attesa', 'In Lavorazione', 'Pronto', 'Consegnato'];
$priorita_livelli = ['Bassa', 'Media', 'Alta'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Ordine #<?php echo $ordine_id; ?> - BariPasta Manager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            font-size: 24px;
        }
        
        .breadcrumb {
            margin-top: 10px;
            font-size: 14px;
        }
        
        .breadcrumb a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            color: white;
        }
        
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .form-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 30px;
        }
        
        .form-card h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        label .required {
            color: #e74c3c;
        }
        
        input[type="text"],
        input[type="tel"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 15px;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        
        .btn-danger {
            background: #e74c3c;
            color: white;
            margin-left: auto;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .helper-text {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 5px;
        }
        
        .radio-pills {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .radio-pill {
            position: relative;
        }
        
        .radio-pill input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        
        .radio-pill label {
            display: block;
            padding: 8px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            margin: 0;
            font-weight: normal;
        }
        
        .radio-pill input[type="radio"]:checked + label {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🍝 BariPasta Manager</h1>
        <div class="breadcrumb">
            <a href="dashboard.php">← Torna alla Dashboard</a>
        </div>
    </div>
    
    <div class="container">
        <div class="form-card">
            <?php if ($ordine): ?>
                <h2>✏️ Modifica Ordine #<?php echo $ordine_id; ?></h2>
                
                <?php if ($messaggio): ?>
                    <div class="alert alert-success">
                        ✅ <?php echo htmlspecialchars($messaggio); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($errore): ?>
                    <div class="alert alert-error">
                        ⚠️ <?php echo htmlspecialchars($errore); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cliente_nome">
                                Nome Cliente <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="cliente_nome" 
                                name="cliente_nome" 
                                required
                                value="<?php echo htmlspecialchars($ordine['cliente_nome']); ?>"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="cliente_telefono">Telefono</label>
                            <input 
                                type="tel" 
                                id="cliente_telefono" 
                                name="cliente_telefono"
                                value="<?php echo htmlspecialchars($ordine['cliente_telefono']); ?>"
                            >
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tipo_pasta">
                                Tipo di Pasta <span class="required">*</span>
                            </label>
                            <select id="tipo_pasta" name="tipo_pasta" required>
                                <?php foreach($tipiPasta as $tipo): ?>
                                    <option value="<?php echo $tipo; ?>" 
                                        <?php echo ($ordine['tipo_pasta'] === $tipo) ? 'selected' : ''; ?>>
                                        <?php echo $tipo; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="peso_kg">
                                Peso (kg) <span class="required">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="peso_kg" 
                                name="peso_kg" 
                                step="0.01" 
                                min="0.01"
                                required
                                value="<?php echo $ordine['peso_kg']; ?>"
                            >
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="data_consegna">
                                Data Consegna <span class="required">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="data_consegna" 
                                name="data_consegna" 
                                required
                                value="<?php echo $ordine['data_consegna']; ?>"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="stato">Stato Ordine</label>
                            <select id="stato" name="stato">
                                <?php foreach($stati as $s): ?>
                                    <option value="<?php echo $s; ?>" 
                                        <?php echo ($ordine['stato'] === $s) ? 'selected' : ''; ?>>
                                        <?php echo $s; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label>Priorità</label>
                        <div class="radio-pills">
                            <?php foreach($priorita_livelli as $p): ?>
                                <div class="radio-pill">
                                    <input 
                                        type="radio" 
                                        id="priorita_<?php echo strtolower($p); ?>" 
                                        name="priorita" 
                                        value="<?php echo $p; ?>"
                                        <?php echo ($ordine['priorita'] === $p) ? 'checked' : ''; ?>
                                    >
                                    <label for="priorita_<?php echo strtolower($p); ?>">
                                        <?php echo $p; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="note">Note</label>
                        <textarea 
                            id="note" 
                            name="note"
                        ><?php echo htmlspecialchars($ordine['note']); ?></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            💾 Salva Modifiche
                        </button>
                        <a href="dashboard.php" class="btn btn-secondary">
                            ✖️ Annulla
                        </a>
                        <a href="elimina_ordine.php?id=<?php echo $ordine_id; ?>" 
                           class="btn btn-danger"
                           onclick="return confirm('Sei sicuro di voler eliminare questo ordine?')">
                            🗑️ Elimina
                        </a>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-error">
                    ⚠️ Ordine non trovato
                </div>
                <a href="dashboard.php" class="btn btn-primary">Torna alla Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>