<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Responsive pour les cartes */
#partieStatistique {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
}

/* Sidebar responsive */
/* #partiegestionDash {
    display: grid;
    flex-direction: column;
} */

@media (max-width: 768px) {
    /* #partiegestionDash {
        flex-direction: row;
        flex-wrap: wrap;
    } */
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
    background-color: #385c90;
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
<body class="bg-gray-100 font-sans">
    <div class="flex flex-col">
        <!-- Partie Statistique -->
        <main class="p-6">
            <div id="partieStatistique" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 justify-center">
                <div id="statiqueCleint" class="w-full sm:w-40 h-20 bg-red-500 text-white rounded-lg shadow-md flex justify-center items-center">
                    <p class="font-medium text-sm uppercase tracking-wider">0 client</p>
                </div>
                <div id="statiqueReservationAccepter" class="w-full sm:w-40 h-20 p-6 bg-green-500 text-white rounded-lg shadow-md flex justify-center items-center">
                    <p class="font-medium text-sm uppercase tracking-wider">0 Reservation acceptée</p>
                </div>
                <div id="statiqtiqueresevationRefuser" class="w-full sm:w-40 h-20 p-6 bg-blue-500 text-white rounded-lg shadow-md flex justify-center items-center">
                    <p class="font-medium text-sm uppercase tracking-wider">0 Reservation refusée</p>
                </div>
                <div id="statiqtiqueresevationEnAttent" class="w-full sm:w-40 h-20  bg-yellow-500 text-white rounded-lg shadow-md flex justify-center items-center">
                    <p class="font-medium text-sm uppercase tracking-wider">0 En attente</p>
                </div>
            </div>
        </main>

        <!-- Partie Gestion -->
        <section class="flex flex-col md:flex-row gap-6 p-6">
            <!-- Sidebar -->
            <div id="partiegestionDash" class="grid grid-cols-2 md:flex md:flex-col gap-4 p-6 bg-white shadow-lg rounded-lg md:w-1/4 w-full">
                <button class="btn w-full">Ajouter menu</button>
                <button class="btn w-full">Ajout plat</button>
                <button class="btn w-full">Voir tous les clients</button>
                <button class="btn w-full">Demande acceptée</button>
                <button class="btn w-full">Demande refusée</button>
                <button class="btn w-full">Demande en attente</button>
                <button class="btn w-full">Modifier menu</button>
            </div>

            <!-- Content -->
            <div id="contentDash" class="flex-1 bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
               <div id="tableUserAttente" class="hidden">
                <h6 class="font-medium text-lg uppercase tracking-wider mb-4 text-gray-700">Réservation en attente</h6>
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
            <!-- ************************************ -->
             <div id="formPlat">
             <div class="flex flex-col items-center justify-center min-h-screen p-6">
        <!-- Conteneur principal -->
        <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-8">
            <!-- Titre -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center uppercase tracking-wider">
                Ajouter un Plat
            </h2>

            <!-- Formulaire -->
            <form action="/ajouter-plat" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Nom du Plat -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-600 mb-2">Nom du Plat</label>
                    <input 
                        type="text" 
                        id="nom" 
                        name="nom" 
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
                        name="nom" 
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
                        name="description" 
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
                        name="categorie"
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
                        name="prix" 
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
                        class="w-full md:w-1/2 bg-[#e38e10] text-white font-semibold py-2 rounded-lg hover:bg-[#d1902f] transition duration-300"
                    >
                        Ajouter le Plat
                    </button>
                </div>
            </form>
        </div>
    </div>

             </div>
            </div>
        </section>
    </div>
</body>


</html>