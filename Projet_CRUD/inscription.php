<?php

require_once 'bdd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $isAdmin = isset($_POST['admin']) && $_POST['admin'] == '1' ? 1 : 0;

  $checkSql = "SELECT * FROM users WHERE username = ? OR email = ?";
  $checkStmt = $connexion->prepare($checkSql);
  $checkStmt->bind_param("ss", $username, $email);
  $checkStmt->execute();
  $result = $checkStmt->get_result();

  if ($result->num_rows > 0) {
    echo '
    <div class="container mt-3">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="alert alert-danger text-center" role="alert">Le nom d\'utilisateur ou l\'email existe déjà.</div>
        </div>
      </div>
    </div>
    ';
  } else {
    $sql = "INSERT INTO users (username, email, password, admin) VALUES (?, ?, ?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $password, $isAdmin);

    if ($stmt->execute()) {
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $_SESSION['admin'] = $isAdmin;
      header("Location: connexion.php");
      exit();
    } else {
      echo "Erreur lors de l'inscription : " . $stmt->error;
    }

    $stmt->close();
  }

  $checkStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <title>Inscription</title>
</meta>
<body>
  <form method="post" action="inscription.php">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-5 mb-5 bg-white rounded mt-3">
            <div class="text-center text-black">
              <h2>Inscription</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" id="email" name="email" class="form-control" required>
                </div>
              <div class="mb-3">
                <label for="password" class="form-label">Mot de passe :</label>
                <input type="password" id="password" name="password" class="form-control" required>
              </div>
              <div class="mb-3">
              </div>
              <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
              <h6 class="text-center mt-4">Vous avez déjà un compte ?</h6>
              <a href="connexion.php" class="btn btn-secondary w-100 mt-2">Se connecter</a>
              <a href="index.php" class="btn btn-link w-100 mt-2">Retour à l'accueil</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</body>
</html>
