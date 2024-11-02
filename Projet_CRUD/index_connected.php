<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
  <nav class="navbar bg-body-tertiary">
    <form class="container-fluid justify-content-between">
      <?php if (isset($_SESSION['username'])) : ?>
        <div>
          <span class="navbar-text me-2 fs-4">Bonjour, <?php echo htmlspecialchars($_SESSION['username']); ?> !</span>
          <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true) : ?>
            <br>
            <span class="navbar-text me-2 pt-3 text-danger fw-bold">Connecté en tant qu'administrateur</span>
          <?php else : ?>
            <br>
            <span class="navbar-text me-2 pt-3 text-primary fw-bold">Connecté en tant qu'utilisateur</span>
          <?php endif; ?>
        </div>
        <div>
          <a href="/index.php" class="btn btn-outline-danger me-2">Déconnexion</a>
        </div>
      <?php endif; ?>
    </form>
  </nav>
  <div class="container">
    <h2 class="mt-5">Listes des clients</h2>
    <br>
    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true) : ?>
      <a href='/create.php' class='btn btn-primary mb-4'>Ajouter un client</a>
    <?php endif; ?>
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
          <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true) : ?>
            <th>Actions</th>
          <?php endif; ?>
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

        while ($row = $resultat->fetch_assoc()) : ?>
          <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['address']); ?></td>
            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true) : ?>
              <td>
                <a href='/edit.php?id=<?php echo $row['id']; ?>' class='btn btn-primary btn-sm'>Modifier</a>
                <a href='/delete.php?id=<?php echo $row['id']; ?>' class='btn btn-danger btn-sm'>Supprimer</a>
              </td>
            <?php endif; ?>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>

</html>
