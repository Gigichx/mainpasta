<?php
/**
 * API Cambio Stato Rapido
 * BariPasta Manager
 */

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/auth.php';

// Controlla autenticazione
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non autenticato']);
    exit();
}

// Verifica metodo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metodo non consentito']);
    exit();
}

// Leggi dati JSON
$input = json_decode(file_get_contents('php://input'), true);
$ordine_id = isset($input['ordine_id']) ? intval($input['ordine_id']) : 0;
$nuovo_stato = isset($input['stato']) ? $input['stato'] : '';

// Validazione
$stati_validi = ['In Attesa', 'In Lavorazione', 'Pronto', 'Consegnato'];

if ($ordine_id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID ordine non valido']);
    exit();
}

if (!in_array($nuovo_stato, $stati_validi)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Stato non valido']);
    exit();
}

// Sanifica
$nuovo_stato = $conn->real_escape_string($nuovo_stato);

// Aggiorna stato
$query = "UPDATE ordini SET stato = '$nuovo_stato' WHERE id = $ordine_id";

if ($conn->query($query)) {
    echo json_encode([
        'success' => true,
        'message' => 'Stato aggiornato con successo',
        'nuovo_stato' => $nuovo_stato
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Errore durante l\'aggiornamento: ' . $conn->error
    ]);
}

$conn->close();
?>