<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
  <nav class="navbar">
    <div class="container-fluid justify-content-end">
      <a href="/inscription.php" class="btn btn-outline-success me-2">Inscription</a>
      <a href="/connexion.php" class="btn btn-outline-secondary me-2">Connexion</a>
    </div>
  </nav>
  <div class="container">
    <h2 class="mt-5">Listes des clients</h2>
    <br>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom du client</th>
          <th>Email</th>
          <th>Telephone</th>
          <th>Adresse</th>
          <th>Créer le</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once 'bdd.php';

        $requete = 'SELECT * FROM clients';
        $resultat = $connexion->query($requete);

        if (!$resultat) {
          die("Erreur SQL: " . $connexion->error);
        }

        while ($row = $resultat->fetch_assoc()) {
          echo "
          <tr>
            <td>" . htmlspecialchars($row['id']) . "</td>
            <td>" . htmlspecialchars($row['name']) . "</td>
            <td>" . htmlspecialchars($row['email']) . "</td>
            <td>" . htmlspecialchars($row['phone']) . "</td>
            <td>" . htmlspecialchars($row['address']) . "</td>
            <td>" . htmlspecialchars($row['created_at']) . "</td>
          </tr>
          ";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>
