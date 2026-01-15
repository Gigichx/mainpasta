<?php
/**
 * Sistema di Autenticazione
 * BariPasta Manager
 */

// Avvia la sessione se non è già attiva
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica se l'utente è autenticato
 * @return bool True se autenticato, False altrimenti
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

/**
 * Protegge una pagina richiedendo il login
 * Se l'utente non è loggato, lo reindirizza al login
 */
function richiedeLogin() {
    if (!isLoggedIn()) {
        header("Location: /admin/login.php");
        exit();
    }
}

/**
 * Esegue il login dell'utente
 * @param mysqli $conn Connessione database
 * @param string $username Username
 * @param string $password Password in chiaro
 * @return array Array con 'success' (bool) e 'message' (string)
 */
function login($conn, $username, $password) {
    // Sanifica l'username
    $username = $conn->real_escape_string(trim($username));
    
    // Cerca l'utente nel database
    $query = "SELECT id, username, password_hash, nome FROM gestori WHERE username = '$username'";
    $result = $conn->query($query);
    
    if (!$result || $result->num_rows === 0) {
        return [
            'success' => false,
            'message' => 'Username o password errati (utente non trovato)'
        ];
    }
    
    $user = $result->fetch_assoc();
    
    // DEBUG: Verifica la password (RIMUOVERE IN PRODUZIONE)
    error_log("Password inserita: " . $password);
    error_log("Hash nel DB: " . $user['password_hash']);
    error_log("Verifica: " . (password_verify($password, $user['password_hash']) ? 'OK' : 'FAIL'));
    
    // Verifica la password
    if (!password_verify($password, $user['password_hash'])) {
        return [
            'success' => false,
            'message' => 'Username o password errati (password non corrisponde)'
        ];
    }
    
    // Login riuscito: salva i dati in sessione
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nome'] = $user['nome'];
    $_SESSION['login_time'] = time();
    
    return [
        'success' => true,
        'message' => 'Login effettuato con successo'
    ];
}

/**
 * Esegue il logout dell'utente
 */
function logout() {
    // Distrugge tutte le variabili di sessione
    $_SESSION = array();
    
    // Distrugge il cookie di sessione
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    // Distrugge la sessione
    session_destroy();
}

/**
 * Ottiene il nome dell'utente loggato
 * @return string Nome utente o stringa vuota
 */
function getNomeUtente() {
    return $_SESSION['nome'] ?? '';
}

/**
 * Ottiene lo username dell'utente loggato
 * @return string Username o stringa vuota
 */
function getUsername() {
    return $_SESSION['username'] ?? '';
}

/**
 * Cambia la password dell'utente loggato
 * @param mysqli $conn Connessione database
 * @param string $vecchiaPassword Password attuale
 * @param string $nuovaPassword Nuova password
 * @return array Array con 'success' (bool) e 'message' (string)
 */
function cambiaPassword($conn, $vecchiaPassword, $nuovaPassword) {
    if (!isLoggedIn()) {
        return [
            'success' => false,
            'message' => 'Devi essere autenticato'
        ];
    }
    
    $userId = $_SESSION['user_id'];
    
    // Verifica la vecchia password
    $query = "SELECT password_hash FROM gestori WHERE id = $userId";
    $result = $conn->query($query);
    
    if (!$result || $result->num_rows === 0) {
        return [
            'success' => false,
            'message' => 'Utente non trovato'
        ];
    }
    
    $user = $result->fetch_assoc();
    
    if (!password_verify($vecchiaPassword, $user['password_hash'])) {
        return [
            'success' => false,
            'message' => 'Password attuale errata'
        ];
    }
    
    // Cripta la nuova password
    $nuovaPasswordHash = password_hash($nuovaPassword, PASSWORD_DEFAULT);
    
    // Aggiorna nel database
    $query = "UPDATE gestori SET password_hash = '$nuovaPasswordHash' WHERE id = $userId";
    
    if ($conn->query($query)) {
        return [
            'success' => true,
            'message' => 'Password modificata con successo'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Errore durante la modifica della password'
        ];
    }
}
?>