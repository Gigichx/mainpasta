<?php
/**
 * Elimina Ordine
 * BariPasta Manager
 */

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

richiedeLogin();

// Verifica ID ordine
$ordine_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($ordine_id <= 0) {
    header("Location: dashboard.php");
    exit();
}

// Elimina ordine
$query = "DELETE FROM ordini WHERE id = $ordine_id";

if ($conn->query($query)) {
    // Reindirizza alla dashboard con messaggio di successo
    header("Location: dashboard.php?deleted=1");
} else {
    // Reindirizza con messaggio di errore
    header("Location: dashboard.php?error=delete");
}

exit();
?>