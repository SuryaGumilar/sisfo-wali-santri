<?php 
// Untuk koneksi ke database :
$host = 'localhost';
$dbname = 'sisfo_wali_santri';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>