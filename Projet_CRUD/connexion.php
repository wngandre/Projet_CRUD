<?php
session_start();

try {
  $connexion = new PDO('mysql:host=localhost;dbname=boutique', 'root', 'root');
  $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $connexion->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $user]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['is_admin'] = $user['admin'] == 1;

      header("Location: index_connected.php");
      exit;
    } else {
      $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
  }
} catch (PDOException $e) {
  echo "Erreur de connexion : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <title>Connexion</title>
</head>

<body>
  <div class="container mt-5">
    <div class="card mx-auto shadow p-4 col-md-6">
      <div class="card-body p-5">
        <?php if (isset($error)): ?>
          <div class="alert alert-danger text-center" role="alert">
            <?php echo $error; ?>
          </div>
        <?php endif; ?>
        <h2 class="text-center">Connexion</h2>
        <form method="post" action="connexion.php">
          <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Mot de passe :</label>
            <input type="password" id="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Se connecter</button>
          <h6 class="text-center mt-4">Vous n'avez pas de compte ?</h6>
          <a href="inscription.php" class="btn btn-secondary w-100 mt-2">S'inscrire</a>
          <a href="index.php" class="btn btn-link w-100 mt-2">Retour à l'accueil</a>
        </form>
      </div>
    </div>
  </div>
</body>

</html>