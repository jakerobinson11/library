<?php
// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Bibliotheque</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Livre Disponible</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="livre.php">Ajout livre</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="inscription.php">Inscription</a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Show these links only when logged in -->
          <li class="nav-item">
            <a class="nav-link" href="modifier_utilisateur.php">Modifier Compte</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Se Déconnecter</a>
          </li>
        <?php else: ?>
          <!-- Show this link only when logged out -->
          <li class="nav-item">
            <a class="nav-link" href="connexion.php">Se Connecter</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>