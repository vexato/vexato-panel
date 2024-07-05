<div class="container mx-auto mt-10 p-6 bg-gray-900 text-white border border-gray-700 rounded-lg shadow-lg">
    <div class="grid grid-cols-1 gap-6">
        <div id="autre-settings">
            <h2 class="text-3xl font-bold mb-6 text-gray-100 border-b border-gray-600 pb-2">Autres OUTILS</h2>
            <a class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4" href="./logs/view">LOGS</a>
            <a class="bg-green-800 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4" href="file">Fichiers (dossier "data")</a>
            <a id="newUser" href='account/new/register' class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mb-4">Ajouter un nouvel utilisateur</a>
            <button id="updateButton" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mb-4">Update</button>
        </div>
    </div>
</div>



<div id="updateOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>
    <div id="updatePopup" class="fixed inset-0 bg-gray-700 p-4 rounded shadow-lg w-1/3 mx-auto mt-20 hidden">
    <div class="flex flex-col items-center justify-center h-full">
        <div class="text-center">
            <h2 class="text-xl font-bold mb-4">Mise à jour du système</h2>
            <p id="updateMessage" class="mb-4">Voulez-vous vraiment mettre à jour le système ?</p>
            <div class="flex justify-center">
                <button id="confirmUpdateButton" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Oui</button>
                <button id="cancelUpdateButton" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Non</button>
            </div>
        </div>
    </div>
</div>
    <script>
        document.getElementById('jsonFileInput').addEventListener('change', function() {
            document.getElementById('importForm').submit();
        });

        document.getElementById('nav-toggle').addEventListener('click', function() {
            var navContent = document.getElementById('nav-content');
            navContent.classList.toggle('hidden');
        });

        document.getElementById('updateButton').addEventListener('click', function() {
        document.getElementById('updateOverlay').classList.remove('hidden');
        document.getElementById('updatePopup').classList.remove('hidden');
        });

        document.getElementById('cancelUpdateButton').addEventListener('click', function() {
        document.getElementById('updateOverlay').classList.add('hidden');
        document.getElementById('updatePopup').classList.add('hidden');
        });

        document.getElementById('confirmUpdateButton').addEventListener('click', function() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update/update.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById('updateMessage').innerText = response.message;
            if (response.success) {
                document.getElementById('confirmUpdateButton').style.display = 'none';
            }
            }
        };
        xhr.send('update_button=1');
        });

    </script>