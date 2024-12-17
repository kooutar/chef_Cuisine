<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <main class="">
      <div id="partieStatistique" class="flex gap-6 justify-center p-6">
         <div id="statiqueCleint" class="w-40 h-16 bg-red-200"></div>
         <div id="statiqueReservationAccepter"  class="w-40 h-16 bg-green-200"></div>
         <div id="statiqtiqueresevationRefuser"  class="w-40 h-16 bg-blue-200"></div>
         <div id="statiqtiqueresevationEnAttent"  class="w-40 h-16 bg-yellow-200"></div>
      </div>
    </main>

    <section class="flex">
        <div id="partiegestionDash" class="flex flex-col gap-6 w-40 h-full bg-gray-200">
            <button>Ajouter menu</button>
            <button> Ajout plate</button>
            <button> voire Tous les cleints</button>
            <button> demande acceptee</button>
            <button> demande refusee</button>
            <button> demande en attente</button>
        </div>
        <div id="contentDash">
            <div>
                <h6>resevation en attente</h6>
                
            </div>
        </div>
    </section>
</body>
</html>