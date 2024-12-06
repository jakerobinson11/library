<?php
$conn = new mysqli("localhost", "root", "", "bibliotheque");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id_livre = $_GET['id'];
    $query = "SELECT * FROM livres WHERE id_livre = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_livre);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        die("Livre introuvable.");
    }
} else {
    die("ID du livre manquant.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $categorie = $_POST['categorie'];

    $update_query = "UPDATE livres SET titre = ?, auteur = ?, categorie = ? WHERE id_livre = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $titre, $auteur, $categorie, $id_livre);

    if ($stmt->execute()) {
        header("Location: index.php?success=livre");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du livre.";
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
    <title>Modifier un Livre</title>
</head>

<body>
    <?php include "header.php"; ?>
    <div class="container mt-4">
        <h1 class="text-center">Modifier un Livre</h1>

        <form action="modifier_livre.php?id=<?= $book['id_livre'] ?>" method="post">
            <div class="form-group">
                <label for="titre">Titre du Livre</label>
                <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($book['titre']) ?>" required>
            </div>
            <div class="form-group mt-3">
                <label for="auteur">Auteur</label>
                <input type="text" class="form-control" id="auteur" name="auteur" value="<?= htmlspecialchars($book['auteur']) ?>" required>
            </div>
            <div class="form-group mt-3">
                <label for="categorie">Catégorie</label>
                <select class="form-control" id="categorie" name="categorie" required>
                    <option value="roman" <?= $book['categorie'] == 'roman' ? 'selected' : '' ?>>Roman</option>
                    <option value="essai" <?= $book['categorie'] == 'essai' ? 'selected' : '' ?>>Essai</option>
                    <option value="biographie" <?= $book['categorie'] == 'biographie' ? 'selected' : '' ?>>Biographie</option>
                    <option value="poesie" <?= $book['categorie'] == 'poesie' ? 'selected' : '' ?>>Poésie</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Mettre à jour</button>
        </form>
    </div>
</body>

</html>

