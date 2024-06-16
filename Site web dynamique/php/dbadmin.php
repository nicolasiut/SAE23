<?php
$servername = "localhost";
$username = "root";  // Root user
$password = "ferrigno23";      // Root user password 
$dbname = "sae23";   // Database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>

