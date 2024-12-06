<?php
$error = "";

if (isset($_POST["login"])) {
    $conn = new mysqli("localhost", "root", "", "bibliotheque");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT id_utilisateur, password_hash FROM utilisateurs WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password_hash"])) {
            session_start();
            $_SESSION["user_id"] = $row["id_utilisateur"];
            header("Location: index.php");
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Adresse e-mail non trouvée.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">
    <title>Connexion</title>
</head>

<body>
    <?php include "header.php"; ?>
    <div class="container mt-4">
        <h1 class="text-center">Connexion</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group mt-3">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary mt-4" name="login">Se connecter</button>
        </form>
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger mt-3">
                <?php echo $error; ?>
            </div>
        <?php } ?>
    </div>
</body>

</html>