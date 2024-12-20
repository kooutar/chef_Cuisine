<?php
// Connexion à la base de données
include 'db.php'; // Assurez-vous d'inclure votre connexion MySQL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $id_user = intval($_POST['id_user']);
    $id_menu = intval($_POST['id_menu']);
    $status = $_POST['status']; // acceptee ou refusee

    // Préparer la requête de mise à jour
    $updateQuery = "UPDATE reservation SET status = ? WHERE id_user = ? AND id_menu = ?";

    $stmt = mysqli_prepare($conn, $updateQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sii', $status, $id_user, $id_menu);
        if (mysqli_stmt_execute($stmt)) {
            echo "Statut mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur dans la préparation de la requête : " . mysqli_error($conn);
    }
}

// Redirection (optionnelle)
header("Location: dashboordAdmin.php"); // Remplacez par le chemin de votre page
exit;
?>
