<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "boutique";

$connexion = new mysqli($servername, $username, $password, $dbname);

if ($connexion->connect_error) {
  die("Connection failed: " . $connexion->connect_error);
}
?>