<?php
session_start();

// Inclure la connexion à la base de données
require_once 'bdd.php';

$id = "";
$name = "";
$email = "";
$tel = "";
$adresse = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!isset($_GET['id'])) {
    header("Location: /index.php");
    exit;
  }

  $id = $_GET['id'];

  // Préparer la requête pour récupérer les données du client
  $stmt = $connexion->prepare("SELECT * FROM clients WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if (!$row) {
    header("Location: /index.php");
    exit;
  }

  $name = $row['name'];
  $email = $row['email'];
  $tel = $row['phone'];
  $adresse = $row['address'];
} else {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $tel = $_POST['tel'];
  $adresse = $_POST['adresse'];

  do {
    if (empty($id) || empty($name) || empty($email) || empty($tel) || empty($adresse)) {
      $err = "Tous les champs sont obligatoires";
      break;
    }

    // Préparer et exécuter la requête de mise à jour
    $stmt = $connexion->prepare("UPDATE clients SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $tel, $adresse, $id);
    $result = $stmt->execute();

    if (!$result) {
      $err = "Erreur SQL: " . $connexion->error;
      break;
    }

    header("Location: /index_connected.php");
    exit;
  } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier un client</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="container">
    <h2>Modifier le client</h2>

    <?php
    if (!empty($err)) {
      echo '
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>' . htmlspecialchars($err) . '</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      ';
    }
    ?>

    <form method="POST">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Nom</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Telephone</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="tel" value="<?php echo $tel; ?>">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Adresse</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="adresse" value="<?php echo $adresse; ?>">
        </div>
      </div>

      <div class="row mb-3">
        <div class="offset-sm-3 col-sm-3 d-grid">
          <button type="submit" class="btn btn-primary">Modifier</button>
        </div>
        <div class="col-sm-3 d-grid">
          <a href="/index_connected.php" class="btn btn-outline-primary" role="button">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</body>

</html>