<?php
/**
 * Dashboard Gestione Ordini
 * BariPasta Manager
 */

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

// Protegge la pagina: solo utenti loggati
richiedeLogin();

// Recupera tutti gli ordini ordinati per data consegna
$query = "SELECT * FROM ordini ORDER BY data_consegna ASC, priorita DESC";
$ordini = $conn->query($query);

// Calcola statistiche
$queryStats = "
    SELECT 
        COUNT(*) as totale_ordini,
        SUM(peso_kg) as peso_totale,
        SUM(CASE WHEN stato = 'In Attesa' THEN 1 ELSE 0 END) as in_attesa,
        SUM(CASE WHEN stato = 'In Lavorazione' THEN 1 ELSE 0 END) as in_lavorazione,
        SUM(CASE WHEN stato = 'Pronto' THEN 1 ELSE 0 END) as pronti,
        SUM(CASE WHEN stato = 'Consegnato' THEN 1 ELSE 0 END) as consegnati
    FROM ordini
";
$resultStats = $conn->query($queryStats);
$stats = $resultStats->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BariPasta Manager</title>
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
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 24px;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-info {
            font-size: 14px;
        }
        
        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 16px;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .btn-logout:hover {
            background: rgba(255,255,255,0.3);
        }
        
        /* Container */
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        /* Statistiche */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid #667eea;
        }
        
        .stat-card.warning {
            border-left-color: #f39c12;
        }
        
        .stat-card.success {
            border-left-color: #27ae60;
        }
        
        .stat-card.danger {
            border-left-color: #e74c3c;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        /* Azioni */
        .actions {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
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
        
        /* Tabella ordini */
        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #f8f9fa;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
            border-bottom: 2px solid #e0e0e0;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
        
        /* Colorazione righe per priorità */
        tr.priorita-alta {
            background: #fee;
        }
        
        tr.priorita-media {
            background: #ffe;
        }
        
        tr.priorita-bassa {
            background: #efe;
        }
        
        /* Badge stato */
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-attesa {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-lavorazione {
            background: #cce5ff;
            color: #004085;
        }
        
        .badge-pronto {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-consegnato {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        /* Badge priorità */
        .badge-priorita {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .priorita-alta .badge-priorita {
            background: #dc3545;
            color: white;
        }
        
        .priorita-media .badge-priorita {
            background: #ffc107;
            color: #333;
        }
        
        .priorita-bassa .badge-priorita {
            background: #28a745;
            color: white;
        }
        
        /* Messaggi */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }
        
        .empty-state .emoji {
            font-size: 64px;
            margin-bottom: 20px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            table {
                min-width: 800px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🍝 BariPasta Manager</h1>
        <div class="header-right">
            <div class="user-info">
                Benvenuto, <strong><?php echo htmlspecialchars(getNomeUtente()); ?></strong>
            </div>
            <a href="logout.php" class="btn-logout">Esci</a>
        </div>
    </div>
    
    <!-- Container principale -->
    <div class="container">
        
        <!-- Statistiche -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?php echo $stats['totale_ordini'] ?? 0; ?></div>
                <div class="stat-label">Ordini Totali</div>
            </div>
            
            <div class="stat-card warning">
                <div class="stat-value"><?php echo number_format($stats['peso_totale'] ?? 0, 2); ?> kg</div>
                <div class="stat-label">Peso Totale</div>
            </div>
            
            <div class="stat-card danger">
                <div class="stat-value"><?php echo $stats['in_attesa'] ?? 0; ?></div>
                <div class="stat-label">In Attesa</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value"><?php echo $stats['in_lavorazione'] ?? 0; ?></div>
                <div class="stat-label">In Lavorazione</div>
            </div>
            
            <div class="stat-card success">
                <div class="stat-value"><?php echo $stats['pronti'] ?? 0; ?></div>
                <div class="stat-label">Pronti</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value"><?php echo $stats['consegnati'] ?? 0; ?></div>
                <div class="stat-label">Consegnati</div>
            </div>
        </div>
        
        <!-- Azioni -->
        <div class="actions">
            <a href="nuovo_ordine.php" class="btn btn-primary">➕ Nuovo Ordine</a>
        </div>
        
        <!-- Tabella ordini -->
        <div class="table-container">
            <?php if ($ordini && $ordini->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Telefono</th>
                            <th>Tipo Pasta</th>
                            <th>Peso (kg)</th>
                            <th>Consegna</th>
                            <th>Stato</th>
                            <th>Priorità</th>
                            <th>Note</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($ordine = $ordini->fetch_assoc()): 
                            $classePriorita = 'priorita-' . strtolower($ordine['priorita']);
                        ?>
                        <tr class="<?php echo $classePriorita; ?>">
                            <td><strong>#<?php echo $ordine['id']; ?></strong></td>
                            <td><?php echo htmlspecialchars($ordine['cliente_nome']); ?></td>
                            <td><?php echo htmlspecialchars($ordine['cliente_telefono']); ?></td>
                            <td><?php echo htmlspecialchars($ordine['tipo_pasta']); ?></td>
                            <td><strong><?php echo number_format($ordine['peso_kg'], 2); ?></strong></td>
                            <td><?php echo date('d/m/Y', strtotime($ordine['data_consegna'])); ?></td>
                            <td>
                                <?php
                                $badgeClass = 'badge-' . strtolower(str_replace(' ', '', $ordine['stato']));
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>">
                                    <?php echo $ordine['stato']; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge-priorita">
                                    <?php echo $ordine['priorita']; ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                $note = htmlspecialchars($ordine['note']);
                                echo $note ? substr($note, 0, 30) . (strlen($note) > 30 ? '...' : '') : '-';
                                ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <a href="modifica_ordine.php?id=<?php echo $ordine['id']; ?>" 
                                       style="padding: 6px 12px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;"
                                       title="Modifica">
                                        ✏️
                                    </a>
                                    <a href="elimina_ordine.php?id=<?php echo $ordine['id']; ?>" 
                                       style="padding: 6px 12px; background: #e74c3c; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;"
                                       onclick="return confirm('Eliminare questo ordine?')"
                                       title="Elimina">
                                        🗑️
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <div class="emoji">📋</div>
                    <h3>Nessun ordine presente</h3>
                    <p>Inizia aggiungendo il primo ordine!</p>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
</body>
</html>
<?php
$conn->close();
?>