<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $conn = new mysqli("localhost", "root", "", "bibliotheque");
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $query = "DELETE FROM utilisateurs WHERE id_utilisateur = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        session_destroy(); // Log out the user
        header("Location: index.php?success=account_deleted");
    } else {
        echo "Erreur lors de la suppression du compte.";
    }

    $stmt->close();
    $conn->close();
}
?>