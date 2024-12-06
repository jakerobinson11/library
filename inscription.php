<?php
$error = "";
$success = "";

function valideDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

$conn = new mysqli("localhost", "root", "", "bibliotheque");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["envoyer"])) {
    if (empty($_POST["nom"])) {
        $error .= "<p>Le Nom est obligatoire</p>";
    } elseif (strlen($_POST["nom"]) < 2 || strlen($_POST["nom"]) > 70) {
        $error .= "<p>Le Nom n'est pas conforme</p>";
    }

    if (empty($_POST["prenom"])) {
        $error .= "<p>Le Prenom est obligatoire</p>";
    } elseif (strlen($_POST["prenom"]) < 2 || strlen($_POST["prenom"]) > 70) {
        $error .= "<p>Le Prenom n'est pas conforme</p>";
    }

    if (empty($_POST["email"])) {
        $error .= "<p>L'email est obligatoire</p>";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $error .= "<p>L'email n'est pas conforme</p>";
    }

    if (empty($_POST["password"])) {
        $error .= "<p>Le mot de passe est obligatoire</p>";
    } elseif (!preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$#", $_POST["password"])) {
        $error .= "<p>Le mot de passe n'est pas conforme</p>";
    }

    if ($_POST["password"] !== $_POST["confirmPwd"]) {
        $error .= "<p>Les mots de passe ne correspondent pas</p>";
    }

    if (empty($_POST["dateNaissance"]) || !valideDate($_POST["dateNaissance"])) {
        $error .= "<p>La date de naissance est obligatoire et doit être valide</p>";
    }

    if (empty($_POST["mobile"]) || !preg_match("#^0[1-9]{1}\d{8}$#", $_POST["mobile"])) {
        $error .= "<p>Le numéro de téléphone n'est pas conforme</p>";
    }

    if (empty($_POST["postal"]) || !preg_match("#^\d{5}$#", $_POST["postal"])) {
        $error .= "<p>Le code postal n'est pas conforme</p>";
    }

    if (empty($error)) {
        $nom = $conn->real_escape_string($_POST["nom"]);
        $prenom = $conn->real_escape_string($_POST["prenom"]);
        $email = $conn->real_escape_string($_POST["email"]);
        $password_hash = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $date_naissance = $_POST["dateNaissance"];
        $mobile = $conn->real_escape_string($_POST["mobile"]);
        $postal = $conn->real_escape_string($_POST["postal"]);

        $sql = "INSERT INTO utilisateurs (nom, prenom, email, password_hash, date_naissance, mobile, code_postal) 
                VALUES ('$nom', '$prenom', '$email', '$password_hash', '$date_naissance', '$mobile', '$postal')";

        if ($conn->query($sql) === TRUE) {
            $success = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
        } else {
            $error .= "<p>Erreur: " . $conn->error . "</p>";
        }
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
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <?php include "header.php"; ?>
    <form id="formulaire" action="" method="post">
        <div>
            <label class="form-label mt-4">Nom</label>
            <input type="text" class="form-control" placeholder="Nom" autocomplete="off" name="nom" value="<?php echo @$_POST["nom"] ?>">
        </div>
        <div>
            <label class="form-label mt-4">Prenom</label>
            <input type="text" class="form-control" placeholder="prenom" autocomplete="off" name="prenom" value="<?php echo @$_POST["prenom"] ?>">
        </div>
        <div>
            <label class="form-label mt-4">Date</label>
            <input type="text" class="form-control" placeholder="date" autocomplete="off" name="date" value="<?php echo @$_POST["date"] ?>">
        </div>
        <div>
            <label class="form-label mt-4">Mail</label>
            <input type="text" class="form-control" placeholder="email" autocomplete="off" name="email" value="<?php echo @$_POST["email"] ?>">
        </div>
        <div>
            <label class="form-label mt-4">Mot de Passe</label>
            <input type="password" class="form-control" placeholder="Mot de Passe" autocomplete="off" name="password">
            <small class="form-text text-muted">
                Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, et un caractère spécial.
            </small>
        </div>
        <div>
            <label class="form-label mt-4">Confirmation Mot de Passe</label>
            <input type="password" class="form-control" placeholder="Confirmation Mot de Passe" autocomplete="off" name="confirmPwd">
        </div>
        <div>
            <label class="form-label mt-4">Date de Naissance</label>
            <input type="text" class="form-control" placeholder="Date Naissance" autocomplete="off" name="dateNaissance" value="<?php echo @$_POST["dateNaissance"] ?>">
            <small class="form-text text-muted">
                Format: AAAA-MM-JJ (ex: 2000-01-01)
            </small>
        </div>
        <div>
            <label class="form-label mt-4">Mobile</label>
            <input type="text" class="form-control" placeholder="mobile" autocomplete="off" name="mobile" value="<?php echo @$_POST["mobile"] ?>">
        </div>
        <div>
            <label class="form-label mt-4">Code Postal</label>
            <input type="text" class="form-control" placeholder="postal" autocomplete="off" name="postal" value="<?php echo @$_POST["postal"] ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="envoyer">Submit</button>
    </form>
    <?php if (!empty($error)) { ?>
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <h4 class="alert-heading">Warning!</h4>
            <?php echo $error; ?>
        </div>
    <?php } ?>
</body>

</html>