<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "bibliotheque");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM utilisateurs WHERE id_utilisateur = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("Utilisateur introuvable.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $date_naissance = $_POST['date_naissance'];
    $mobile = $_POST['mobile'];
    $code_postal = $_POST['code_postal'];
    $password_hash = isset($_POST['password']) && !empty($_POST['password'])
        ? password_hash($_POST['password'], PASSWORD_DEFAULT)
        : $user['password_hash']; 

    $update_query = "UPDATE utilisateurs 
                     SET nom = ?, prenom = ?, email = ?, password_hash = ?, date_naissance = ?, mobile = ?, code_postal = ? 
                     WHERE id_utilisateur = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssi", $nom, $prenom, $email, $password_hash, $date_naissance, $mobile, $code_postal, $user_id);

    if ($stmt->execute()) {
        header("Location: index.php?success=1"); 
        exit();
    } else {
        echo "Erreur lors de la mise à jour de votre compte.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
    <title>Modifier Compte</title>
</head>

<body>
    <?php include "header.php"; ?>
    <div class="container mt-4">
        <h1 class="text-center">Modifier Mon Compte</h1>

        <form action="modifier_utilisateur.php" method="post">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
            </div>
            <div class="form-group mt-3">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
            </div>
            <div class="form-group mt-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="form-group mt-3">
                <label for="date_naissance">Date de Naissance</label>
                <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($user['date_naissance']) ?>" required>
                <small class="form-text text-muted">
                    Format: AAAA-MM-JJ (ex: 2000-01-01)
                </small>
            </div>
            <div class="form-group mt-3">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?= htmlspecialchars($user['mobile']) ?>" required>
            </div>
            <div class="form-group mt-3">
                <label for="code_postal">Code Postal</label>
                <input type="text" class="form-control" id="code_postal" name="code_postal" value="<?= htmlspecialchars($user['code_postal']) ?>" required>
            </div>
            <div class="form-group mt-3">
                <label for="password">Nouveau Mot de Passe (laisser vide pour ne pas changer)</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="form-text text-muted">
                    Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, et un caractère spécial.
                </small>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary me-2">Mettre à jour</button>
                <a href="delete_utilisateur.php" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">Supprimer mon compte</a>
            </div>
        </form>
    </div>
</body>

</html>