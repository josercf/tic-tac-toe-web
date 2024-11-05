<?php
// db.php
$servername = "mysql.jrcf.dev";
$username = "usr_mm";
$password = "010203";
$database = "uni9_mm_tic_tac_toe";

$conn = new mysqli($servername, $username, $password, $database);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
