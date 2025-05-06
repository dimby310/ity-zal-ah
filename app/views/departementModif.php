<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Département</title>
</head>

<body>

    <h1>Modifier Département</h1>

    <form action="departement-modif" id="departementForm" method="POST">
        <input type="hidden" id="departementId" name="id" value="">
        <label for="nom">Nom du Département :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <input type="submit" value="Mettre à jour le Département">
    </form>

    <a href="departement-liste">Retour à la liste des Départements</a>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const departementId = urlParams.get('id');
        console.log(departementId);

        async function loadDepartement() {
            try {
                const url = `rest/departement/${departementId}`;
                console.log(url);
                const departementResponse = await fetch(url);
                const departementData = await departementResponse.json();
                console.log("Résultat :", departementData);

                if (!departementData.success) {
                    alert('Département non trouvé');
                    return;
                }

                const departement = departementData.data;
                document.getElementById('departementId').value = departement.id_departement;
                document.getElementById('nom').placeholder = departement.nom;
            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
                alert('Une erreur est survenue lors du chargement des données.');
            }
        }

        document.addEventListener('DOMContentLoaded', loadDepartement);
    </script>

</body>

</html>
