<?php 
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['id_role'] != 1) {
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
    <section class="md:m-6 p-2" style="background-color:whitesmoke;">
     <nav class="flex justify-around">
      <img src="img/logo.png" alt="" srcset="" class="w-16">
      <p class="mb-2 text-xl font-medium leading-tight">
      <?php 
      session_start();
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
      include('db.php');
       $allMenu ="SELECT * FROM menu ";
      //  $stmt=mysqli_prepare($conn, $allMenu);
      //  $result=mysqli_stmt_execute($stmt);
      $result=mysqli_query($conn,$allMenu );
       while($row=mysqli_fetch_assoc($result))
       {
          echo " 
              <div
    class='flex flex-col rounded-lg bg-white text-surface shadow-secondary-1 dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0 sm:rounded-e-none'>
    <a href='#!'>
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
      <button id='bteEditMenu'class='btn w-full'>savoir plus</button>
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
                            <th class="py-3 px-4 font-medium uppercase">Mail User</th>
                            <th class="py-3 px-4 font-medium uppercase">Date de réservation</th>
                            <th class="py-3 px-4 font-medium uppercase">Heure</th>
                            <th class="py-3 px-4 font-medium uppercase">Nombre de personnes</th>
                            <th class="py-3 px-4 font-medium uppercase">Statut</th>
                            <th class="py-3 px-4 font-medium uppercase">Edit/Suppression</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-4 text-gray-700">{$client['id_client']}</td>
                            <td class="py-3 px-4 text-gray-700">{$client['nom']}</td>
                            <td class="py-3 px-4 text-gray-700">{$client['pernom']}</td>
                            <td class="py-3 px-4 text-gray-700">{$client['email']}</td>
                            <td class="py-3 px-4 text-gray-700">{$client['telephone']}</td>
                            <td class="py-3 px-4 text-gray-700">{$client['adresse']}</td>
                            <td class="py-3 px-4 text-gray-700">{$client['date_naissance']}</td>
                        </tr>
                    </tbody>
                </table>

        </div>

        
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
    </script>
</body>
</html>