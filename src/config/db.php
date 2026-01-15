<?php
/**
 * Configurazione connessione database
 * BariPasta Manager
 * Funziona sia in locale (Docker) che su Altervista
 */

// Rileva ambiente: se esiste la variabile DOCKER, siamo in locale
$isDocker = getenv('DOCKER_ENV') !== false || file_exists('/.dockerenv');

if ($isDocker) {
    // Configurazione LOCALE (Docker)
    define('DB_HOST', 'mysql-db');
    define('DB_USER', 'appuser');
    define('DB_PASS', 'apppass');
    define('DB_NAME', 'appdb');
} else {
    // Configurazione ALTERVISTA (Produzione)
    define('DB_HOST', 'localhost');
    define('DB_USER', 'maninpasta');
    define('DB_PASS', '');
    define('DB_NAME', 'my_maninpasta');
}

// Connessione al database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica connessione
if ($conn->connect_error) {
    die("Errore di connessione al database: " . $conn->connect_error);
}

// Imposta charset UTF-8 per supportare caratteri accentati
$conn->set_charset("utf8mb4");

/**
 * Funzione per eseguire query in sicurezza
 * @param mysqli $conn Connessione database
 * @param string $query Query SQL
 * @return mysqli_result|bool Risultato query
 */
function eseguiQuery($conn, $query) {
    $result = $conn->query($query);
    if (!$result) {
        error_log("Errore query: " . $conn->error);
        return false;
    }
    return $result;
}

/**
 * Funzione per sanificare input utente
 * @param mysqli $conn Connessione database
 * @param string $data Dato da sanificare
 * @return string Dato sanificato
 */
function pulisciInput($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}
?>