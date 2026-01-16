<?php
/**
 * Dashboard Analytics e Vendite
 * Maninpasta Manager
 */

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

richiedeLogin();

// Statistiche generali vendite
$queryVendite = "
    SELECT 
        COUNT(*) as totale_ordini,
        SUM(peso_kg) as peso_totale,
        SUM(totale_vendita) as vendite_totali,
        SUM(totale_costo) as costi_totali,
        SUM(profitto) as profitto_totale,
        AVG(profitto) as profitto_medio
    FROM ordini
";
$resultVendite = $conn->query($queryVendite);
$vendite = $resultVendite->fetch_assoc();

// Vendite per tipo di pasta
$queryPerTipo = "
    SELECT 
        tipo_pasta,
        COUNT(*) as num_ordini,
        SUM(peso_kg) as peso_totale,
        SUM(totale_vendita) as vendite,
        SUM(profitto) as profitto
    FROM ordini
    GROUP BY tipo_pasta
    ORDER BY vendite DESC
";
$venditePerTipo = $conn->query($queryPerTipo);

// Vendite per mese (ultimi 6 mesi)
$queryPerMese = "
    SELECT 
        DATE_FORMAT(data_consegna, '%Y-%m') as mese,
        COUNT(*) as num_ordini,
        SUM(totale_vendita) as vendite,
        SUM(profitto) as profitto
    FROM ordini
    WHERE data_consegna >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY DATE_FORMAT(data_consegna, '%Y-%m')
    ORDER BY mese ASC
";
$venditePerMese = $conn->query($queryPerMese);

// Ordini più redditizi
$queryTopOrdini = "
    SELECT 
        id,
        cliente_nome,
        tipo_pasta,
        peso_kg,
        totale_vendita,
        profitto,
        data_consegna
    FROM ordini
    ORDER BY profitto DESC
    LIMIT 5
";
$topOrdini = $conn->query($queryTopOrdini);

// Prepara dati per grafici
$venditePerTipoData = [];
while($row = $venditePerTipo->fetch_assoc()) {
    $venditePerTipoData[] = $row;
}
$venditePerTipo->data_seek(0); // Reset pointer

$venditePerMeseData = [];
while($row = $venditePerMese->fetch_assoc()) {
    $venditePerMeseData[] = $row;
}
$venditePerMese->data_seek(0);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Maninpasta Manager</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        
        .nav-links {
            display: flex;
            gap: 15px;
        }
        
        .nav-links a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .nav-links a:hover,
        .nav-links a.active {
            background: rgba(255,255,255,0.2);
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
        
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .stat-card.revenue {
            border-left: 4px solid #27ae60;
        }
        
        .stat-card.costs {
            border-left: 4px solid #e74c3c;
        }
        
        .stat-card.profit {
            border-left: 4px solid #3498db;
        }
        
        .stat-card.orders {
            border-left: 4px solid #f39c12;
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
        
        .chart-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .chart-container h3 {
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .chart-wrapper {
            position: relative;
            height: 300px;
        }
        
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #f8f9fa;
        }
        
        th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
            border-bottom: 2px solid #e0e0e0;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
        
        .profit-positive {
            color: #27ae60;
            font-weight: bold;
        }
        
        .profit-negative {
            color: #e74c3c;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🍝 Maninpasta Manager</h1>
        <div class="header-right">
            <div class="nav-links">
                <a href="dashboard.php">Ordini</a>
                <a href="analytics.php" class="active">Analytics</a>
            </div>
            <div class="user-info">
                Benvenuto, <strong><?php echo htmlspecialchars(getNomeUtente()); ?></strong>
            </div>
            <a href="logout.php" class="btn-logout">Esci</a>
        </div>
    </div>
    
    <div class="container">
        
        <!-- Statistiche Principali -->
        <div class="stats-grid">
            <div class="stat-card revenue">
                <div class="stat-value">€<?php echo number_format($vendite['vendite_totali'] ?? 0, 2); ?></div>
                <div class="stat-label">Vendite Totali</div>
            </div>
            
            <div class="stat-card costs">
                <div class="stat-value">€<?php echo number_format($vendite['costi_totali'] ?? 0, 2); ?></div>
                <div class="stat-label">Costi Totali</div>
            </div>
            
            <div class="stat-card profit">
                <div class="stat-value">€<?php echo number_format($vendite['profitto_totale'] ?? 0, 2); ?></div>
                <div class="stat-label">Profitto Totale</div>
            </div>
            
            <div class="stat-card orders">
                <div class="stat-value"><?php echo $vendite['totale_ordini'] ?? 0; ?></div>
                <div class="stat-label">Ordini Totali</div>
            </div>
        </div>
        
        <!-- Grafici -->
        <div class="grid-2">
            <!-- Vendite per Tipo -->
            <div class="chart-container">
                <h3>Vendite per Tipo di Pasta</h3>
                <div class="chart-wrapper">
                    <canvas id="chartPerTipo"></canvas>
                </div>
            </div>
            
            <!-- Andamento Mensile -->
            <div class="chart-container">
                <h3>Profitto Mensile (ultimi 6 mesi)</h3>
                <div class="chart-wrapper">
                    <canvas id="chartPerMese"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Tabella Dettagli per Tipo -->
        <div class="chart-container">
            <h3>Dettaglio Vendite per Tipo</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tipo Pasta</th>
                        <th>N° Ordini</th>
                        <th>Peso Totale (kg)</th>
                        <th>Vendite</th>
                        <th>Profitto</th>
                        <th>Margine %</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($tipo = $venditePerTipo->fetch_assoc()): 
                        $margine = $tipo['vendite'] > 0 ? ($tipo['profitto'] / $tipo['vendite']) * 100 : 0;
                    ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($tipo['tipo_pasta']); ?></strong></td>
                        <td><?php echo $tipo['num_ordini']; ?></td>
                        <td><?php echo number_format($tipo['peso_totale'], 2); ?> kg</td>
                        <td>€<?php echo number_format($tipo['vendite'], 2); ?></td>
                        <td class="profit-positive">€<?php echo number_format($tipo['profitto'], 2); ?></td>
                        <td><?php echo number_format($margine, 1); ?>%</td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Top Ordini -->
        <div class="chart-container">
            <h3>Top 5 Ordini più Redditizi</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Tipo Pasta</th>
                        <th>Peso (kg)</th>
                        <th>Vendita</th>
                        <th>Profitto</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($ordine = $topOrdini->fetch_assoc()): ?>
                    <tr>
                        <td><strong>#<?php echo $ordine['id']; ?></strong></td>
                        <td><?php echo htmlspecialchars($ordine['cliente_nome']); ?></td>
                        <td><?php echo htmlspecialchars($ordine['tipo_pasta']); ?></td>
                        <td><?php echo number_format($ordine['peso_kg'], 2); ?></td>
                        <td>€<?php echo number_format($ordine['totale_vendita'], 2); ?></td>
                        <td class="profit-positive">€<?php echo number_format($ordine['profitto'], 2); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($ordine['data_consegna'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
    </div>
    
    <script>
        // Dati per grafico vendite per tipo
        const venditePerTipoData = <?php echo json_encode($venditePerTipoData); ?>;
        
        // Grafico Vendite per Tipo (Torta)
        const ctxTipo = document.getElementById('chartPerTipo').getContext('2d');
        new Chart(ctxTipo, {
            type: 'doughnut',
            data: {
                labels: venditePerTipoData.map(d => d.tipo_pasta),
                datasets: [{
                    label: 'Vendite (€)',
                    data: venditePerTipoData.map(d => parseFloat(d.vendite)),
                    backgroundColor: [
                        '#3498db',
                        '#e74c3c',
                        '#f39c12',
                        '#27ae60',
                        '#9b59b6'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Dati per grafico mensile
        const venditePerMeseData = <?php echo json_encode($venditePerMeseData); ?>;
        
        // Grafico Profitto Mensile (Linea)
        const ctxMese = document.getElementById('chartPerMese').getContext('2d');
        new Chart(ctxMese, {
            type: 'line',
            data: {
                labels: venditePerMeseData.map(d => {
                    const [year, month] = d.mese.split('-');
                    const date = new Date(year, month - 1);
                    return date.toLocaleDateString('it-IT', { month: 'short', year: 'numeric' });
                }),
                datasets: [{
                    label: 'Profitto (€)',
                    data: venditePerMeseData.map(d => parseFloat(d.profitto)),
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39, 174, 96, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '€' + value.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>