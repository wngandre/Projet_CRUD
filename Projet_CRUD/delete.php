<?php

if (isset($_GET['id'])) {
  require_once 'bdd.php';

  $id = $_GET['id'];

  $stmt = $connexion->prepare("DELETE FROM clients WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  header("Location: /index_connected.php");
  exit;
}

?>