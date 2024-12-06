<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
    <title>Ajouter un Livre</title>
</head>

<body>
    <?php include "header.php"; ?>
    <div class="container mt-4">
        <h1 class="text-center">Ajouter un Livre</h1>

        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="alert alert-success">Le livre a été ajouté avec succès !</div>
        <?php endif; ?>

        <form action="livre_handler.php" method="post">
            <div class="form-group">
                <label for="titre">Titre du Livre</label>
                <input type="text" class="form-control" id="titre" name="titre" required>
            </div>
            <div class="form-group mt-3">
                <label for="auteur">Auteur</label>
                <input type="text" class="form-control" id="auteur" name="auteur" required>
            </div>
            <div class="form-group mt-3">
                <label for="categorie">Catégorie</label>
                <select class="form-control" id="categorie" name="categorie" required>
                    <option value="roman">Roman</option>
                    <option value="essai">Essai</option>
                    <option value="biographie">Biographie</option>
                    <option value="poesie">Poésie</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Ajouter</button>
        </form>
    </div>
</body>

</html>