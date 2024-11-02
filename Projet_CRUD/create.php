<?php

require_once 'bdd.php';

$name = "";
$email = "";
$tel = "";
$adresse = "";

$err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $tel = $_POST['tel'];
  $adresse = $_POST['adresse'];

  do {
    if (empty($name) || empty($email) || empty($tel) || empty($adresse)) {
      $err = "Tous les champs sont obligatoires";
      break;
    }

    $sql = "SELECT * FROM clients WHERE email = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $err = "Cet email existe déjà";
      break;
    }

    $sql = "INSERT INTO clients (name, email, phone, address) VALUES (?, ?, ?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $tel, $adresse);
    $result = $stmt->execute();

    if (!$result) {
      $err = "Erreur SQL: " . $connexion->error;
      break;
    }

    $name = "";
    $email = "";
    $tel = "";
    $adresse = "";

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
  <title>Nouveau client</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="container mt-5">
    <h2 class="mb-4">Nouveau client</h2>

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
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Nom</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="name" placeholder="Paul" value="<?php echo htmlspecialchars($name); ?>">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-6">
            <input type="email" class="form-control" name="email" placeholder="paul@exemple.com" value="<?php echo htmlspecialchars($email); ?>">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Telephone</label>
        <div class="col-sm-6">
          <input type="tel" class="form-control" name="tel" placeholder="06 12 34 56 78" value="<?php echo htmlspecialchars($tel); ?>">
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Adresse</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="adresse" placeholder="123 Rue de l'Exemple 75001 Paris" value="<?php echo htmlspecialchars($adresse); ?>">
        </div>
      </div>

      <div class="row mb-3">
        <div class="offset-sm-3 col-sm-3 d-grid">
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
        <div class="col-sm-3 d-grid">
          <a href="/index_connected.php" class="btn btn-outline-secondary" role="button">Annuler</a>
        </div>
      </div>
    </form>
  </div>
</body>

</html>