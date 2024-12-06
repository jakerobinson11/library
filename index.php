<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "bibliotheque");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Adjusted query to fetch all books since the 'emprunt' table no longer exists
$query = "
    SELECT l.auteur, l.titre, l.id_livre
    FROM livres l
";

$result = $conn->query($query);

if (!$result) {
    die("Erreur dans la requête SQL : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
    <title>Bibliotheque</title>
</head>

<body>
    <?php include "header.php"; ?>
    <div class="container mt-4">
        <h1 class="text-center">Livres Disponibles</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Auteur</th>
                    <th>Titre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                <td>" . htmlspecialchars($row["auteur"]) . "</td>
                <td>" . htmlspecialchars($row["titre"]) . "</td>
                <td>
                    <a href='modifier_livre.php?id=" . $row["id_livre"] . "' class='btn btn-warning btn-sm'>Modifier</a>
                </td>
                <td>
                    <a href='delete_livre.php?id=" . $row["id_livre"] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');\">Supprimer</a>
                </td>
              </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$result->free();
$conn->close();
?>
<?php if (isset($_GET['success'])): ?>
    <?php if ($_GET['success'] == 'livre'): ?>
        <div class="alert alert-success">Le livre a été mis à jour avec succès !</div>
    <?php elseif ($_GET['success'] == 'compte'): ?>
        <div class="alert alert-success">Votre compte a été mis à jour avec succès !</div>
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($_GET['success'])): ?>
    <?php if ($_GET['success'] == 'livre'): ?>
        <div class="alert alert-success">Le livre a été mis à jour avec succès !</div>
    <?php elseif ($_GET['success'] == 'compte'): ?>
        <div class="alert alert-success">Votre compte a été mis à jour avec succès !</div>
    <?php elseif ($_GET['success'] == 'livre_deleted'): ?>
        <div class="alert alert-success">Le livre a été supprimé avec succès !</div>
    <?php elseif ($_GET['success'] == 'account_deleted'): ?>
        <div class="alert alert-success">Votre compte a été supprimé avec succès !</div>
    <?php endif; ?>
<?php endif; ?>