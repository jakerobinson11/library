<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "bibliotheque";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
    SELECT l.auteur, l.titre 
    FROM livre l
    LEFT JOIN emprunt e ON l.id_livre = e.id_livre AND e.date_rendu IS NULL
    WHERE e.id_emprunt IS NULL
";

$result = $conn->query($sql);
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
    <?php include "header.php" ?>
    <div class="container mt-4">
        <h1 class="text-center">Livres Disponibles</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Auteur</th>
                    <th>Titre</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["auteur"]) . "</td>
                                <td>" . htmlspecialchars($row["titre"]) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' class='text-center'>Aucun livre disponible</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$conn->close();
?>