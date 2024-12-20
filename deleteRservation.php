<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    <?php
include 'db.php'; 

if (isset($_POST['deleteReserve'])) {

    $id_user = intval($_POST['id_user']);
    $id_menu = intval($_POST['id_menu']);
  
    $updateQuery = " delete from reservation where id_menu=? and id_user=?;";

    $stmt = mysqli_prepare($conn, $updateQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ii', $id_menu, $id_user);
        if (mysqli_stmt_execute($stmt)) {
            echo "delte mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur dans la préparation de la requête : " . mysqli_error($conn);
    }
} 
 



// Redirection (optionnelle)
header("Location: pageClient.php"); // Remplacez par le chemin de votre page
exit;

?>
</body>
</html>
<?php 

