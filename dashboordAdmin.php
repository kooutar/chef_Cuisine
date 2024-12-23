<?php 
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['id_role'] != 2) {
//     header("Location: login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <style>
        /* Responsive pour les cartes */
#partieStatistique {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
}

/* Table responsive */
#tableClients {
    overflow-x: auto;
    display: block;
}

/* Style des boutons */
.btn {
    padding: 10px;
    margin-bottom: 8px;
    background-color:  #f34949;
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
<?php 
include('db.php');

if (isset($_POST['ajoutPlat'])) {

    $namePlat = trim(htmlspecialchars($_POST['nomPlat']));
    $descriptionPlat = trim(htmlspecialchars($_POST['descriptionPlat']));
    $categoriePlat = htmlspecialchars($_POST['categoriePlat']);
    $prixPlat = trim(htmlspecialchars($_POST['prixPlat'])); 
    $uploadDir = 'uploads/';//dossier destinatire
    if (isset($_FILES["pathImage"]) && !empty($_FILES["pathImage"]["name"])) {
        echo $_FILES["pathImage"]["name"]."  ".basename($_FILES["pathImage"]["name"])."<br>";
        $newPathImage = $uploadDir . basename($_FILES["pathImage"]["name"]);
        $arrayExtentionImag=array('png','jpg','jpge','jpeg','gif','svg');
        $extention=pathinfo( $newPathImage,PATHINFO_EXTENSION);//retourn extention de image 
        if(in_array(strtolower($extention),$arrayExtentionImag)){
            move_uploaded_file($_FILES["pathImage"]["tmp_name"],$newPathImage);
             $requteAjoutPlat="INSERT INTO plate(nomPlat,pathImage,description,categorie,prix) VALUES(?,?,?,?,?);";
             $stmt=mysqli_prepare($conn,$requteAjoutPlat);
             mysqli_stmt_bind_param($stmt,"ssssd",$namePlat,$newPathImage,$descriptionPlat,$categoriePlat,$prixPlat);
             mysqli_stmt_execute($stmt);
        }else{
            echo "c'est pas une image";
        }
    } else {
        echo "Aucun fichier téléchargé.";
    }
}
if (isset($_POST['ajoutMenu'])){
    $titreMenu=trim(htmlspecialchars($_POST['titreMenu']));
    $descriptionMenu=trim(htmlspecialchars($_POST['descriptionMenu']));
    $allPlat=$_POST['plat'];
    $allplatId=$_POST['idPlat'];
    $tailleId=count($allplatId);
    echo $tailleId."<br>"; 
    // $imageMenu=$_FILES['imageMenu'];
    $uploadDir = 'uploads/';
    if (isset($_FILES['imageMenu']) && !empty($_FILES['imageMenu']["name"])) {
        echo $_FILES['imageMenu']["name"]."  ".basename($_FILES['imageMenu']["name"])."<br>";
        $newPathImage = $uploadDir . basename($_FILES['imageMenu']["name"]);
        $arrayExtentionImag=array('png','jpg','jpge','jpeg','gif','svg');
        $extention=pathinfo( $newPathImage,PATHINFO_EXTENSION);//retourn extention de image 
        if(in_array(strtolower($extention),$arrayExtentionImag)){
            move_uploaded_file($_FILES['imageMenu']["tmp_name"],$newPathImage);
             $requteAjoutMenu="INSERT INTO menu(titre,description,image) VALUES(?,?,?);";
             $stmt=mysqli_prepare($conn,$requteAjoutMenu);
             mysqli_stmt_bind_param($stmt,"sss",$titreMenu,$descriptionMenu,$newPathImage);
             mysqli_stmt_execute($stmt);
             $idMenu=mysqli_insert_id($conn);
             for($i=0;$i<$tailleId;$i++)
             {
                    // echo $_POST['idPlat'][$i]." ";
                $reqeuteInsertIntoPlat_Menu="INSERT INTO menu_palt VALUES(?,?);";
                $stmt=mysqli_prepare($conn,$reqeuteInsertIntoPlat_Menu);
                mysqli_stmt_bind_param($stmt,"ii",$idMenu,$_POST['idPlat'][$i]);
                mysqli_stmt_execute($stmt);
             }
        }else{
            echo "c'est pas une image";
        }
    } else {
        echo "Aucun fichier téléchargé.";
    }



}
?>

<body class="bg-gray-100 font-sans">


    <div class="flex flex-col">
        <!-- Partie Statistique -->
        <main class="p-6">
            <div id="partieStatistique" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 md:pl-12">
                <div id="statiqueCleint" class="w-full sm:w-40 h-20 bg-green-500 text-white rounded-lg shadow-md flex justify-center items-center">
                <p class="font-medium text-sm uppercase tracking-wider">
    <?php
    include('db.php');
    // Requête corrigée
    $requetreservationAttente = "SELECT COUNT(*) as total FROM reservation WHERE status = 'en attente';";
    $nbrreservationAttente = mysqli_query($conn, $requetreservationAttente);

    if ($nbrreservationAttente) {
        $result = mysqli_fetch_assoc($nbrreservationAttente);
        // Vérifiez si le résultat n'est pas nul et affichez-le
        if ($result && $result['total'] > 0) {
            echo $result['total'] . " réservations en attente";
        } else {
            echo "0 réservation en attente.";
        }
    } else {
        // Affiche l'erreur SQL si la requête échoue
        echo "Erreur dans la requête SQL : " . mysqli_error($conn);
    }
    ?>
</p>

                </div>
                <div id="statiqueReservationAccepter" class="w-full sm:w-40 h-20 p-6 bg-yellow-500 text-white rounded-lg shadow-md flex justify-center items-center">
                    <p class="font-medium text-sm uppercase tracking-wider">
                    <?php
                          $requetAllClient="SELECT count(*) FROM user;";
                          $nbrClient=mysqli_query($conn,$requetAllClient);
                          $result=mysqli_fetch_assoc($nbrClient);
                          echo $result['count(*)'];
                        ?>     
                   clients </p>
                </div>
                <div id="statiqtiqueresevationRefuser" class="w-full sm:w-40 h-20 p-6 bg-blue-500 text-white rounded-lg shadow-md flex justify-center items-center">
                    <p class="font-medium text-sm uppercase tracking-wider"> 
                        <?php
    include('db.php');
  
    $requetreservationAttente = "SELECT COUNT(*) as total FROM reservation WHERE status = 'accepter';";
    $nbrreservationAttente = mysqli_query($conn, $requetreservationAttente);

    if ($nbrreservationAttente) {
        $result = mysqli_fetch_assoc($nbrreservationAttente);
      
        if ($result && $result['total'] > 0) {
            echo $result['total'] . " réservations acceptee";
        } else {
            echo "0 réservation en acceptee.";
        }
    } else {
        echo "Erreur dans la requête SQL : " . mysqli_error($conn);
    }
    ?>
    </p>
                </div>
                <div id="statiqtiqueresevationEnAttent" class="w-full sm:w-40 h-20  bg-red-500 text-white rounded-lg shadow-md flex justify-center items-center">
                    <p class="font-medium text-sm uppercase tracking-wider">
                    <?php
    include('db.php');
    // Requête corrigée
    $requetreservationAttente = "SELECT COUNT(*) as total FROM reservation WHERE status = 'refuser';";
    $nbrreservationAttente = mysqli_query($conn, $requetreservationAttente);

    if ($nbrreservationAttente) {
        $result = mysqli_fetch_assoc($nbrreservationAttente);
        // Vérifiez si le résultat n'est pas nul et affichez-le
        if ($result && $result['total'] > 0) {
            echo $result['total'] . " réservations refusee";
        } else {
            echo "0 réservation en refusee.";
        }
    } else {
        // Affiche l'erreur SQL si la requête échoue
        echo "Erreur dans la requête SQL : " . mysqli_error($conn);
    }
    ?>
                    </p>
                </div>
            </div>
        </main>

        <!-- Partie Gestion -->
        <section class="flex flex-col md:flex-row gap-6 p-6">
            <!-- Sidebar -->
            <div id="partiegestionDash" class="grid grid-cols-2 md:flex md:flex-col gap-4 p-6 bg-white shadow-lg rounded-lg md:w-1/4 w-full">
                <button id="bteAjoutMenu" class="btn w-full">Ajouter menu</button>
                <button id="bteAjoutPlate" class="btn w-full">Ajout plate</button>
                <button id="bteAllCleints" class="btn w-full">Voir tous les clients</button>
                <button id="bteAcceptedDemande"class="btn w-full">Demande acceptée</button>
                <button id="bteDemandeRefuse"class="btn w-full">Demande refusée</button>
                <button id="bteDemandeAttente"class="btn w-full">Demande en attente</button>
                <button id="bteEditMenu"class="btn w-full">Modifier menu</button>
            </div>

            <!-- Content -->
            <div id="contentDash" class="flex-1 bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
                <!-- table user en attente -->
               <div id="tableUserAttente" class="section ">
                <h6 class="font-medium text-lg uppercase tracking-wider mb-4 text-gray-700">Réservation en attente</h6>
                <table id="tableClients" class="table-auto min-w-max w-full bg-gray-50 border border-gray-300 rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                        
                            <th class="py-3 px-4 font-medium uppercase">Nom client</th>
                            <th class="py-3 px-4 font-medium uppercase">date Reservation</th>
                            <th class="py-3 px-4 font-medium uppercase">Time de reservation</th>
                            <th class="py-3 px-4 font-medium uppercase">nombre Presonne</th>
                            <th class="py-3 px-4 font-medium uppercase">adresse client</th>
                            <th class="py-3 px-4 font-medium uppercase">id menu reserve</th>
                            <th class="py-3 px-4 font-medium uppercase">reponnse</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                         $requetreservationAttente="SELECT  u.* , r.* FROM user u INNER JOIN reservation r ON u.id_user = r.id_user WHERE r.status = 'en attente';";
                         $nbrreservationAttente=mysqli_query($conn,$requetreservationAttente);
                         while($row=mysqli_fetch_assoc($nbrreservationAttente)){
                            echo "<tr class='hover:bg-gray-100'>
                          <td class='py-3 px-4 text-gray-700'>{$row['nom']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['dateReservation']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['timereservation']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['nbrPersonne']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['adresse']}</td>
                             <td class='py-3 px-4 text-gray-700'>{$row['id_menu']}</td>
                             <td class='py-3 px-4 text-gray-700'>
                               <form method='POST' style='display:inline;' action='update_reservation.php'>
                <input type='hidden' name='id_user' value='{$row['id_user']}'>
                <input type='hidden' name='id_menu' value='{$row['id_menu']}'>
                <input type='hidden' name='status' value='accepter'>
                <button type='submit' class='bg-green-500 text-white px-3 py-1 rounded'>Acceptee</button>
            </form>
            <!-- Formulaire pour refuser -->
            <form method='POST' style='display:inline;' action='update_reservation.php'>
                <input type='hidden' name='id_user' value='{$row['id_user']}'>
                <input type='hidden' name='id_menu' value='{$row['id_menu']}'>
                <input type='hidden' name='status' value='refuser'>
                <button type='submit' class='bg-red-500 text-white px-3 py-1 rounded'>Refusee</button>
            </form>
                             </td>
                           
                        </tr>";

                         }
                         
                        

                        ?>
                    </tbody>
                </table>
            </div>
            <!-- *****************formulaire ajout plate******************* -->

    <div id="formPlat" class="section hidden">
             <div class="flex flex-col items-center justify-center min-h-screen p-6">
        <!-- Conteneur principal -->
        <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-8">
            <!-- Titre -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center uppercase tracking-wider">
                Ajouter un Plat
            </h2>

            <!-- Formulaire -->
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Nom du Plat -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-600 mb-2">Nom du Plat</label>
                    <input 
                        type="text" 
                        id="nom" 
                        name="nomPlat" 
                        placeholder="Entrez le nom du plat"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <!-- upode image -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-600 mb-2">image du Plat</label>
                    <input 
                        type="file" 
                        id="nom" 
                        name="pathImage" 
                        placeholder="Entrez le nom du plat"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-600 mb-2">Description</label>
                    <textarea 
                        id="description" 
                        name="descriptionPlat" 
                        rows="4" 
                        placeholder="Ajoutez une description du plat"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                        required
                    ></textarea>
                </div>

                <!-- Catégorie -->
                <div>
                    <label for="categorie" class="block text-sm font-medium text-gray-600 mb-2">Catégorie</label>
                    <select 
                        id="categorie" 
                        name="categoriePlat"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="" disabled selected>Choisissez une catégorie</option>
                        <option value="plat_principal">Plat Principal</option>
                        <option value="dessert">Dessert</option>
                        <option value="entree">Entrée</option>
                    </select>
                </div>

                <!-- Prix -->
                <div>
                    <label for="prix" class="block text-sm font-medium text-gray-600 mb-2">Prix (€)</label>
                    <input 
                        type="number" 
                        id="prix" 
                        name="prixPlat" 
                        placeholder="Entrez le prix en euros"
                        min="0" 
                        step="0.01"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <!-- Bouton Ajouter -->
                <div class="text-center">
                    <button 
                        type="submit" 
                        name="ajoutPlat"
                        class="w-full md:w-1/2 bg-[#e38e10] text-white font-semibold py-2 rounded-lg hover:bg-[#d1902f] transition duration-300"
                    >
                        Ajouter le Plat
                    </button>
                </div>
            </form>
        </div>
       </div>

    </div>
    <!-- **********************table user accepter************************* -->
    <div id="tableUserAccepter" class="section hidden">
                <h6 class="font-medium text-lg uppercase tracking-wider mb-4 text-gray-700">Réservation Acceptées</h6>
                <table id="tableClients" class="table-auto min-w-max w-full bg-gray-50 border border-gray-300 rounded-lg shadow-md">
                    <thead>
                    <tr class="bg-gray-200 text-gray-600">
                            <th class="py-3 px-4 font-medium uppercase">Nom client</th>
                            <th class="py-3 px-4 font-medium uppercase">date Reservation</th>
                            <th class="py-3 px-4 font-medium uppercase">Time de reservation</th>
                            <th class="py-3 px-4 font-medium uppercase">nombre Presonne</th>
                            <th class="py-3 px-4 font-medium uppercase">adresse client</th>
                            <th class="py-3 px-4 font-medium uppercase">id menu reserve</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                         $requetreservationAttente="SELECT  u.* , r.* FROM user u INNER JOIN reservation r ON u.id_user = r.id_user WHERE r.status = 'accepter' AND r. dateReservation >= CURDATE() ORDER BY dateReservation ASC;";
                         $nbrreservationAttente=mysqli_query($conn,$requetreservationAttente);
                         while($row=mysqli_fetch_assoc($nbrreservationAttente)){
                            echo "<tr class='hover:bg-gray-100'>
                            <td class='py-3 px-4 text-gray-700'>{$row['nom']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['dateReservation']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['timereservation']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['nbrPersonne']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['adresse']}</td>
                             <td class='py-3 px-4 text-gray-700'>{$row['id_menu']}</td>
                            
                           
                        </tr>";

                         }
                         
                        

                        ?>
                    </tbody>
                </table>
            </div>

            <!-- *********************demande refusee -->
              <!-- **********************table user accepter************************* -->
    <div id="tableUserRefusee" class="section hidden">
                <h6 class="font-medium text-lg uppercase tracking-wider mb-4 text-gray-700">Réservation refusée</h6>
                <table id="tableClients" class="table-auto min-w-max w-full bg-gray-50 border border-gray-300 rounded-lg shadow-md">
                    <thead>
                    <tr class="bg-gray-200 text-gray-600">
                            <th class="py-3 px-4 font-medium uppercase">Nom client</th>
                            <th class="py-3 px-4 font-medium uppercase">date Reservation</th>
                            <th class="py-3 px-4 font-medium uppercase">Time de reservation</th>
                            <th class="py-3 px-4 font-medium uppercase">nombre Presonne</th>
                            <th class="py-3 px-4 font-medium uppercase">adresse client</th>
                            <th class="py-3 px-4 font-medium uppercase">id menu reserve</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                         $requetreservationAttente="SELECT  u.* , r.* FROM user u INNER JOIN reservation r ON u.id_user = r.id_user WHERE r.status = 'refusee';";
                         $nbrreservationAttente=mysqli_query($conn,$requetreservationAttente);
                         while($row=mysqli_fetch_assoc($nbrreservationAttente)){
                            echo "<tr class='hover:bg-gray-100'>
                            <td class='py-3 px-4 text-gray-700'>{$row['nom']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['dateReseravtion']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['timereservation']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['nbrPersonne']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['adresse']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['id_menu']}</td>  
                        </tr>";

                         }
                         
                        

                        ?>
                    </tbody>
                </table>
            </div>

              <!-- ***************Voir All clients********************* -->
              <div id="tableAllUser" class="section hidden">
                <h6 class="font-medium text-lg uppercase tracking-wider mb-4 text-gray-700">Tous les cleints</h6>
                <table id="tableClients" class="table-auto min-w-max w-full bg-gray-50 border border-gray-300 rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                            <th class="py-3 px-4 font-medium uppercase">Nom Menu</th>
                            <th class="py-3 px-4 font-medium uppercase">Mail User</th>
                            <th class="py-3 px-4 font-medium uppercase">Date de réservation</th>
                            <th class="py-3 px-4 font-medium uppercase">Heure</th>
                            <th class="py-3 px-4 font-medium uppercase">Nombre de personnes</th>
                            <th class="py-3 px-4 font-medium uppercase">Statut</th>
                            <th class="py-3 px-4 font-medium uppercase">Edit/Suppression</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                         $requetreservationAttente="SELECT  * FROM user ";
                         $nbrreservationAttente=mysqli_query($conn,$requetreservationAttente);
                         while($row=mysqli_fetch_assoc($nbrreservationAttente)){
                            echo "<tr class='hover:bg-gray-100'>
                            <td class='py-3 px-4 text-gray-700'>{$row['nom']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['pernom']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['email']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['telephone']}</td>
                            <td class='py-3 px-4 text-gray-700'>{$row['adresse']}</td>
                             
                            
                           
                        </tr>";

                         }
                         
                        

                        ?>
                    </tbody>
                </table>
            </div>
           
            <div id="formMenu" class="section hidden">
            <div class="flex flex-col items-center justify-center min-h-screen p-6">
        <!-- Conteneur principal -->
        <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-8">
            <!-- Titre -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center uppercase tracking-wider">
                Ajouter un Menu
            </h2>

            <!-- Formulaire -->
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Nom du Plat -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-600 mb-2">Titre Menu</label>
                    <input 
                        type="text" 
                        id="titre" 
                        name="titreMenu" 
                        placeholder="Entrez le nom du plat"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <!-- upode image -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-600 mb-2">image du menu</label>
                    <input 
                        type="file" 
                        id="nom" 
                        name="imageMenu" 
                        placeholder="Entrez le nom du plat"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-600 mb-2">Description</label>
                    <textarea 
                        id="description" 
                        name="descriptionMenu" 
                        rows="4" 
                        placeholder="Ajoutez une description du plat"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                        required
                    ></textarea>
                </div>

                <!-- Catégorie -->
                 
                
                <div id="divPourLesNouveauxChamps" class="flex flex-col gap-2">
                <div>
                    <label for="categorie" class="block text-sm font-medium text-gray-600 mb-2">plat</label>
                    <select 
                        id="categorie" 
                        name="plat[]"
                        class="select w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                        <option value="" disabled selected>Choisissez un Plat</option>
                        <?php 
                          $requetAllPlat="SELECT * FROM plate;";
                          $result=mysqli_query($conn,$requetAllPlat);
                          while($row=mysqli_fetch_assoc($result)){
                            echo "<option id='{$row['id_plat']}' value='{$row['nomPlat']}'>{$row['nomPlat']}</option>";
                          }

                        ?>
                        
                    </select>
                </div> 

                </div>
               <div  id="divPourInputId">
                
               </div>
                
                
           <div class="flex justify-end">
            <a id="bteFormDynamique" class="cursor-pointer"><i class="ri-file-add-fill"></i></a>

           </div>

                <!-- Bouton Ajouter -->
                <div class="text-center">
                    <button 
                        type="submit" 
                        name ="ajoutMenu"
                        class="w-full md:w-1/2 bg-[#e38e10] text-white font-semibold py-2 rounded-lg hover:bg-[#d1902f] transition duration-300"
                    >
                        Ajouter le Menu
                    </button>
                </div>
            </form>
        </div>
       </div>
            </div>
        </div>
        </section>
    
   
    </div>
    <script>
        const AllSection=document.querySelectorAll('.section');
        document.querySelector('#bteAjoutPlate').addEventListener('click',()=>{
            AllSection.forEach(section=>{
            if(section.id!="formPlat")
            {
                section.classList.add('hidden')
            }else{
                section.classList.remove('hidden')
            }
            })

        })
        document.querySelector('#bteDemandeAttente').addEventListener('click',()=>{
            AllSection.forEach(section=>{
            if(section.id!="tableUserAttente")
            {
                section.classList.add('hidden')
            }else{
                section.classList.remove('hidden')
            }
            })

        })
        document.querySelector('#bteAcceptedDemande').addEventListener('click',()=>{
            AllSection.forEach(section=>{
            if(section.id!="tableUserAccepter")
            {
                section.classList.add('hidden')
            }else{
                section.classList.remove('hidden')
            }
            })

        })
        document.querySelector('#bteDemandeRefuse').addEventListener('click',()=>{
            AllSection.forEach(section=>{
            if(section.id!="tableUserRefusee")
            {
                section.classList.add('hidden')
            }else{
                section.classList.remove('hidden')
            }
            })

        })
       
        document.querySelector('#bteAllCleints').addEventListener('click',()=>{
            AllSection.forEach(section=>{
            if(section.id!="tableAllUser")
            {
                section.classList.add('hidden')
            }else{
                section.classList.remove('hidden')
            }
            })

        })

        document.querySelector('#bteAjoutMenu').addEventListener('click',()=>{
            AllSection.forEach(section=>{
            if(section.id!="formMenu")
            {
                section.classList.add('hidden')
            }else{
                section.classList.remove('hidden')
            }
            })

        })
        document.querySelector('#bteFormDynamique').addEventListener('click',()=>{
            let newSelect=document.createElement('select');
            newSelect.name="plat[]";
            newSelect.classList.add("select","w-full","px-4","py-2","border","rounded-lg","focus:outline-none","focus:ring-2","focus:ring-blue-500")
            newSelect.innerHTML=`
               <option value="" disabled selected>Choisissez un Plat</option>
                         <?php 
                          $requetAllPlat="SELECT * FROM plate;";
                          $result=mysqli_query($conn,$requetAllPlat);
                          while($row=mysqli_fetch_assoc($result)){
                            echo "<option id='{$row['id_plat']}' value='{$row['nomPlat']}'>{$row['nomPlat']}</option>";
                          }

                        ?>
            `
            document.querySelector('#divPourLesNouveauxChamps').appendChild(newSelect);
             
           
        })
      
        document.querySelector('#divPourLesNouveauxChamps').addEventListener('change', (event) => {
    if (event.target && event.target.classList.contains('select')) {
        const selectedOption = event.target.options[event.target.selectedIndex];
        let inputId =document.createElement('input');
          inputId.name="idPlat[]";
         inputId.value=selectedOption.id;
         inputId.classList.add("invisible");
         document.querySelector('#divPourInputId').appendChild(inputId);
   
    }
});
      
            
      
        
        
    </script>
</body>


</html>