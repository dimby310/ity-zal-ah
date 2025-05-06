<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Période</title>
</head>

<body>

    <h1>Modifier Période</h1>

    <form action="periode-modif" id="periodeForm" method="POST">
        <input type="hidden" id="periodeId" name="id" value="">
        
        <label for="nom">Nom de la Période :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="mois">Mois :</label>
        <input type="number" id="mois" name="mois" required min="1" max="12"><br><br>

        <label for="annee">Année :</label>
        <input type="number" id="annee" name="annee" required min="1900" max="2100"><br><br>

        <input type="submit" value="Mettre à jour la Période">
    </form>

    <a href="periode-liste">Retour à la liste des Périodes</a>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const periodeId = urlParams.get('id');
        console.log(periodeId);

        async function loadPeriode() {
            try {
                const url = `rest/periode/${periodeId}`;
                console.log(url);
                const periodeResponse = await fetch(url);
                const periodeData = await periodeResponse.json();
                console.log("Résultat :", periodeData);

                if (!periodeData.success) {
                    alert('Période non trouvée');
                    return;
                }

                const periode = periodeData.data;
                document.getElementById('periodeId').value = periode.id_periode;
                document.getElementById('nom').placeholder = periode.nom;
                document.getElementById('mois').value = periode.mois;
                document.getElementById('annee').value = periode.annee;
            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
                alert('Une erreur est survenue lors du chargement des données.');
            }
        }

        document.addEventListener('DOMContentLoaded', loadPeriode);
    </script>

</body>

</html>
