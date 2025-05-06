<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Nature</title>
</head>

<body>

    <h1>Modifier Nature</h1>

    <form action="nature-modif" id="natureForm" method="POST">
        <input type="hidden" id="natureId" name="id" value="">
        <label for="nom">Nom de la Nature :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="type">Type :</label>
        <select id="type" name="id_type" required>
            <!-- La liste des types sera remplie ici par JavaScript -->
        </select><br><br>

        <input type="submit" value="Mettre à jour la Nature">
    </form>

    <a href="nature-liste">Retour à la liste des Natures</a>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const natureId = urlParams.get('id');
        console.log(natureId);
        async function loadNatureAndTypes() {
            try {
                const url =  `rest/nature/${natureId}`;
                console.log(url);
                const natureResponse = await fetch(`rest/nature/${natureId}`);
                const natureData = await natureResponse.json();
                console.log("resultat :" , natureData); 

                if (!natureData.success) {
                    alert('Nature non trouvée');
                    return;
                }

                const nature = natureData.data;
                console.log(nature.id_type);
                document.getElementById('natureId').value = nature.id_nature;
                document.getElementById('nom').placeholder = nature.nom;
                const typesResponse = await fetch('rest/type');
                const typesData = await typesResponse.json();

                const typeSelect = document.getElementById('type');
                typesData.data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id_type;
                    option.textContent = type.nom;
                    if (type.id_type === nature.id_type) {
                        option.selected = true;
                    }
                    typeSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
                alert('Une erreur est survenue lors du chargement des données.');
            }
        }
        document.addEventListener('DOMContentLoaded', loadNatureAndTypes);
    </script>

</body>

</html>