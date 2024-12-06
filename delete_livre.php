<?php
if (isset($_GET['id'])) {
    $conn = new mysqli("localhost", "root", "", "bibliotheque");
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $id_livre = $_GET['id'];
    $query = "DELETE FROM livres WHERE id_livre = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_livre);

    if ($stmt->execute()) {
        header("Location: index.php?success=livre_deleted");
    } else {
        echo "Erreur lors de la suppression du livre.";
    }

    $stmt->close();
    $conn->close();
}
?>