<?php 
session_start();
 include('db.php');
?>
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
<div id="modaleInscription" class="flex justify-center items-center bg-black/50 fixed z-50 w-full h-full hidden ">
    <form class="p-6 bg-white w-[350px] md:w-1/2 "  action="" method="POST">
   <div class="flex items-start justify-between md:p-5 border-b ">
                <h3 class="text-gray-900 text-sm md:text-xl lg:text-2xl font-semibold ">
                   Reserver 
                   <?php 
                      $nameMenu ="SELECT titre from menu where id_menu=?;";
                      $stmt=mysqli_prepare($conn,$nameMenu);
                     mysqli_stmt_bind_param($stmt,"i",$_COOKIE['id_menu']);
                     mysqli_stmt_execute($stmt);
                     $result=mysqli_stmt_get_result($stmt);
                     while($row=mysqli_fetch_assoc($result))
                     {
                         echo $row['titre'];
                     }
                   ?>
                </h3>
                <button id="closeBteForListPlayers" type="button" class="closeBte text-gray-400  hover:bg-gray-200  rounded-lg p-5  ">
                    &times;
                </button>
            </div>
					<div class="-mx-3 flex flex-wrap">
						<div class="w-full px-3 sm:w-1/2">
							<div class="mb-5">
								<label  class="mb-3 block text-base font-medium text-[#07074D]">
                                date de reservation
								</label>
								<input type="date" name="date" id="date"
									class="w-full rounded-md border border-[#e0e0e0] bg-white md:py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                      
							</div>
						</div>
						<div class="w-full px-3 sm:w-1/2">
							<div class="mb-5">
								<label  class="mb-3 block text-base font-medium text-[#07074D]">
                                time de resrvation
								</label>
								<input type="time" name="time" id="time"
									class="w-full rounded-md border border-[#e0e0e0] bg-white  md:py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                    
							</div>
						</div>
					</div>
					
					<div class="-mx-3 flex flex-wrap">
						<div class="w-full px-3 sm:w-1/2">
							<div class="mb-5">
								<label class="mb-3 block text-base font-medium text-[#07074D]">
                                nombre de place 
								</label>
								<input type="number" name="numberplace" id="number"
									class="w-full rounded-md border border-[#e0e0e0] bg-white  md:py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                    
							</div>
						</div>
						
					</div>
		
		            <input id="idInput" type="text" name="id"  value="" class="invisible">
					<div>
						<button id="bteReserver" 
							class="btn">
							Reserver
						</button>
					</div>
		</form> 
   </div>
<div class="flex w-full justify-center"> 


<?php 
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
     $dateReservation=$_POST['date'];
     $timeReservation=$_POST['time'];
     $numberplace=$_POST['numberplace'];
     $idmenu=$_COOKIE['id_menu'];
     $idmenuInt = intval($idmenu);
     $iduser=$_SESSION["id_user"];
  $requteAjoutToReservation="INSERT INTO reservation(id_menu,id_user,dateReservation,timereservation,nbrPersonne) VALUES(?,?,?,?,?);";
   $stmt=mysqli_prepare($conn,$requteAjoutToReservation);
   mysqli_stmt_bind_param($stmt,"iissi",$idmenuInt,$iduser,$dateReservation,$timeReservation,$numberplace);
   mysqli_stmt_execute($stmt);
  }
?>
    <div id="Menu" class="section grid grid-cols-2 gap-6 md:grid-cols-4 md:gap-8 p-6">
        <?php 
        include('db.php');
        if (isset($_COOKIE['id_menu'])) {
            $menuId = htmlspecialchars($_COOKIE['id_menu']); 

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
    
</div>
<div class=" flex justify-center">
   <button id="bteAfficheModale" class="btn "> reservre</button>

    </div>

    <script>
        document.querySelector('#bteAfficheModale').addEventListener('click',()=>{
           document.querySelector('#modaleInscription').classList.remove('hidden')
            
        })
        document.querySelector('#closeBteForListPlayers').addEventListener('click',()=>{
        document.querySelector('#modaleInscription').classList.add('hidden');
    })
    </script>
</body>
 
</html>
