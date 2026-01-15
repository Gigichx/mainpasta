<?php
$servername = 'mysql-db';
$username = 'appuser';
$password = 'apppass';
$database = 'appdb';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>