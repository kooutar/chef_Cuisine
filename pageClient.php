<?php 
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['id_role'] != 1) {
//     header("Location: login.php");
//     exit();
// }
?>
<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
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
<body style="background-color:bisque;">
     <!--  modale affiche les plat de  -->

    
    <section class="md:m-6 p-2" style="background-color:whitesmoke;">
     <nav class="flex justify-around">
      <img src="img/logo.png" alt="" srcset="" class="w-16">
      <p class="mb-2 text-xl font-medium leading-tight">
      <?php 
   
       include('db.php');
        $requetRecupereName="SELECT * FROM USER where id_user=?";
        $stmt=mysqli_prepare($conn,$requetRecupereName);
        mysqli_stmt_bind_param($stmt,"i",$_SESSION["id_user"]);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result)>0)
        {
             $row=mysqli_fetch_assoc($result);
             echo $row['nom']; 
        }

      ?>
      </p>
     </nav>
     <main class="flex flex-col p-6">
        <div class="flex justify-center">
            <h1 class="mb-2 text-xl font-medium leading-tight">Our Menu</h1>
        </div>
        <div class=" flex ">
             <div class="flex w-full justify-between gap-2">
             <button id="bteRetourMenu"class="btn ">retour menu</button>
             <button id="bteHidtorique"class="btn">Voir historique</button>
             </div>
        </div>
        <div id="Menu" class="section grid grid-cols-2 gap-6 md:grid-cols-4 md:gap-8">


    
      <?php
       $allMenu ="SELECT * FROM menu ";
      $result=mysqli_query($conn,$allMenu );
       while($row=mysqli_fetch_assoc($result))
       {
          echo " 
              <div
    class='flex flex-col rounded-lg bg-white text-surface shadow-secondary-1 dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0 sm:rounded-e-none'>
    
          <img
        class='rounded-t-lg sm:rounded-tr-none'
        src={$row['image']}
        alt='Hollywood Sign on The Hill' />
    </a>
    <div class='p-6'>
      <h5 class='mb-2 text-xl font-medium leading-tight'>{$row['titre']}</h5>
      <p class='mb-4 text-base'>
       {$row['description']}
      </p>
    <button   id='{$row['id_menu']}'  class='savoir btn w-full'>savoir plus</button>
    </div>
     </div>
    ";

       }
      ?>
        </div>


        <div id="tableHistorique" class="section hidden">
        <h6 class="font-medium text-lg uppercase tracking-wider mb-4 text-gray-700">Réservation Acceptées</h6>
                <table id="tableClients" class="table-auto min-w-max w-full bg-gray-50 border border-gray-300 rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                            <th class="py-3 px-4 font-medium uppercase">Nom Menu</th>
                            <th class="py-3 px-4 font-medium uppercase">date de resrevationr</th>
                            <th class="py-3 px-4 font-medium uppercase">time de réservation</th>
                            
                            <th class="py-3 px-4 font-medium uppercase">Statut</th>
                            <th class="py-3 px-4 font-medium uppercase">Edit/Suppression</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                            <?php 
                               $requte="SELECT r.* ,m.titre from reservation r INNER JOIN menu m ON r.id_menu=m.id_menu WHERE id_user=?";
                               $stmt=mysqli_prepare($conn,$requte);
                               mysqli_stmt_bind_param($stmt,"i",$_SESSION['id_user']);
                               mysqli_stmt_execute($stmt);
                               $result=mysqli_stmt_get_result($stmt);
                               while($row=mysqli_fetch_assoc($result))
                               {
                                 echo"
                                 <tr class='hover:bg-gray-100'>
                                    <td class='py-3 px-4 text-gray-700'>{$row['titre']}</td>
                                    <td class='py-3 px-4 text-gray-700'>{$row['dateReservation']}</td>
                                    <td class='py-3 px-4 text-gray-700'>{$row['timereservation']}</td>
                                    <td class='py-3 px-4 text-gray-700'>{$row['status']}</td>
                                    <td class='py-3 px-4 text-gray-700'>
                                       <form method='POST' style='display:inline;' action='deleteRservation.php'>
                                            <input type='hidden' name='id_user' value='{$row['id_user']}'>
                                            <input type='hidden' name='id_menu' value='{$row['id_menu']}'>
                                            <button type='submit' name='deleteReserve' class='bg-green-500 text-white px-3 py-1 rounded'>annuller</button>
                                        </form>
                                         <form method='POST' style='display:inline;' action=''>
                                            <input type='hidden' name='id_user' value='{$row['id_user']}'>
                                            <input type='hidden' name='id_menu' value='{$row['id_menu']}'>
                                            <button type='submit' name='modifierReserve' class='bg-green-500 text-white px-3 py-1 rounded'>modifier</button>
                                        </form>
                                    </td>
                                    </tr>
                                 ";
                               }
                            ?>
                          
                       
                    </tbody>
                </table>
        </div>

        
<?php 

if (isset($_POST['modifierReserve'])) {
    $id_user = intval($_POST['id_user']);
    $id_menu = intval($_POST['id_menu']);

    $requte = "SELECT * FROM reservation WHERE id_user=? AND id_menu=?";
    $stmt = mysqli_prepare($conn, $requte);

    if (!$stmt) {
        die("Échec de la préparation de la requête : " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'ii', $id_user, $id_menu);
    $bool = mysqli_stmt_execute($stmt);

    if (!$bool) {
        die("Échec de l'exécution de la requête : " . mysqli_error($conn));
    }

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("Aucune donnée trouvée pour cet utilisateur et ce menu.");
    }

    echo "
    <div id='modaleInscription' class='flex justify-center items-center bg-black/50 fixed z-50 w-full h-full'>
        <form class='p-6 bg-white w-[350px] md:w-1/2' action='' method='POST'>
            <div class='flex items-start justify-between md:p-5 border-b'>
                <h3 class='text-gray-900 text-sm md:text-xl lg:text-2xl font-semibold'>Reserver</h3>
                <button id='closeBteForListPlayers' type='button' class='closeBte text-gray-400 hover:bg-gray-200 rounded-lg p-5'>&times;</button>
            </div>
            <div class='-mx-3 flex flex-wrap'>
                <div class='w-full px-3 sm:w-1/2'>
                    <div class='mb-5'>
                        <label class='mb-3 block text-base font-medium text-[#07074D]'>Date de réservation</label>
                        <input type='date' name='date' id='date'
                            class='w-full rounded-md border border-[#e0e0e0] bg-white md:py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md'
                            value=\"{$row['dateReservation']}\" />
                    </div>
                </div>
                <div class='w-full px-3 sm:w-1/2'>
                    <div class='mb-5'>
                        <label class='mb-3 block text-base font-medium text-[#07074D]'>Heure de réservation</label>
                        <input type='time' name='time' id='time'
                            class='w-full rounded-md border border-[#e0e0e0] bg-white md:py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md'
                            value=\"{$row['timereservation']}\" />
                    </div>
                </div>
            </div>
            <div class='-mx-3 flex flex-wrap'>
                <div class='w-full px-3 sm:w-1/2'>
                    <div class='mb-5'>
                        <label class='mb-3 block text-base font-medium text-[#07074D]'>Nombre de places</label>
                        <input type='number' name='numberplace' id='number'
                            class='w-full rounded-md border border-[#e0e0e0] bg-white md:py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md'
                            value=\"{$row['nbrPersonne']}\" />
                    </div>
                </div>
            </div>
            <div>
                <button id='bteReserver' class='btn'>Reserver</button>
            </div>
        </form> 
    </div>";
}

?>
       
     </main>
    </section>

    
    <script>
const allsection=document.querySelectorAll('.section')
document.querySelector('#bteHidtorique').addEventListener('click',()=>{
 allsection.forEach(section=>{
  if(section.id!="tableHistorique")
 {
     section.classList.add('hidden');
 }else{
  section.classList.remove('hidden');
 }
 })
  
})

document.querySelector('#bteRetourMenu').addEventListener('click',()=>{
 allsection.forEach(section=>{
  if(section.id!="Menu")
 {
     section.classList.add('hidden');
 }else{
  section.classList.remove('hidden');
 }
 }) 
})


document.querySelectorAll('.savoir').forEach(button=>{
  button.addEventListener('click',()=>{
    console.log(button.id);
    document.cookie="id_menu="+button.id;
     window.location.href = `platMenu.php`;

  })
})


        document.querySelector('#bteAfficheModale').addEventListener('click',()=>{
           document.querySelector('#modaleInscription').classList.remove('hidden')
            
        })
        document.querySelector('#closeBteForListPlayers').addEventListener('click',()=>{
        document.querySelector('#modaleInscription').classList.add('hidden');
    })
    </script>

</body>
</html>