<?php 

include 'db.php'; // Assurez-vous d'inclure votre connexion MySQL

if (isset($_POST['deleteReserve'])) {
    // Récupérer les données du formulaire
    $id_user = intval($_POST['id_user']);
    $id_menu = intval($_POST['id_menu']);
  

    // Préparer la requête de mise à jour
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