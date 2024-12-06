<?php
$feedback = "";

$conn = new mysqli("localhost", "root", "", "bibliotheque");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $conn->real_escape_string($_POST["titre"]);
    $auteur = strtoupper($conn->real_escape_string($_POST["auteur"])); 
    $categorie = $conn->real_escape_string($_POST["categorie"]);

    if (!empty($titre) && !empty($auteur) && !empty($categorie)) {
        $sql = "INSERT INTO livres (titre, auteur, categorie) VALUES ('$titre', '$auteur', '$categorie')";

        if ($conn->query($sql) === TRUE) {
            header("Location: livre.php?success=1");
            exit();
        } else {
            $feedback = "<div class='alert alert-danger'>Erreur : " . $conn->error . "</div>";
        }
    } else {
        $feedback = "<div class='alert alert-warning'>Veuillez remplir tous les champs.</div>";
    }
}

$conn->close();
