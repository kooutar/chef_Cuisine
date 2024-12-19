<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn {
            padding: 10px;
            margin-bottom: 8px;
            background-color: #f34949;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s;
            cursor: pointer;
            text-align: center;
        }

        .btn:hover {
            background-color: #2c4c76;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div id="Menu" class="section grid grid-cols-2 gap-6 md:grid-cols-4 md:gap-8 p-6">
        <?php 
        include('db.php');
        if (isset($_GET['idmenu'])) {
            $menuId = htmlspecialchars($_GET['idmenu']); // Éviter les attaques XSS

            $requteplatDeMenu = "
                SELECT * 
                FROM plate
                INNER JOIN menu_palt ON plate.id_plat = menu_palt.id_plat
                WHERE id_menu = ?;
            ";

            // Préparer et exécuter la requête
            $stmt = mysqli_prepare($conn, $requteplatDeMenu);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "d", $menuId);
                
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                                <div class='flex flex-col rounded-lg bg-white text-gray-800 shadow-lg sm:shrink-0 sm:grow sm:basis-0'>
                                    <img 
                                        class='rounded-t-lg h-48 w-full object-cover'
                                        src='{$row['pathImage']}' 
                                        alt='{$row['nomPlat']}'>
                                    <div class='p-6'>
                                        <h5 class='mb-2 text-xl font-semibold leading-tight'>{$row['nomPlat']}</h5>
                                        <p class='mb-2 text-gray-600'>{$row['description']}</p>
                                        <p class='mb-2 text-sm text-gray-500'>Catégorie : {$row['categorie']}</p>
                                        <p class='mb-4 text-lg font-bold text-gray-900'>Prix : {$row['prix']} €</p>
                                       
                                    </div>
                                </div>
                            ";
                        }
                    } else {
                        echo "<p class='col-span-4 text-center text-gray-600'>Aucun plat trouvé pour ce menu.</p>";
                    }
                } else {
                    echo "<p class='col-span-4 text-center text-red-600'>Erreur lors de l'exécution de la requête.</p>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "<p class='col-span-4 text-center text-red-600'>Erreur lors de la préparation de la requête.</p>";
            }
        } else {
            echo "<p class='col-span-4 text-center text-gray-600'>Aucun ID de menu fourni.</p>";
        }
        ?>
    </div>
</body>

</html>
