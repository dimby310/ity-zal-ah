<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Périodes</title>
</head>

<body>

    <h1>Liste des Périodes</h1>
    <a href="periode-formulaire">Ajouter</a>
    <table>
        <thead>
            <tr>
                <th>ID Période</th>
                <th>Nom</th>
                <th>Mois</th>
                <th>Année</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="periodeTableBody">
            <tr>
                <td colspan="5">Chargement...</td>
            </tr>
        </tbody>
    </table>

    <script>
        function loadPeriodes() {
            fetch('rest/periode')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('periodeTableBody');
                    tbody.innerHTML = '';

                    if (data.data && data.data.length > 0) {
                        data.data.forEach(periode => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${periode.id_periode}</td>
                                <td>${periode.nom}</td>
                                <td>${periode.mois}</td>
                                <td>${periode.annee}</td>
                                <td>
                                    <a href="periode-modif?id=${periode.id_periode}">Modifier</a>
                                    <button onclick="deletePeriode(${periode.id_periode})">Supprimer</button>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="5">Aucune donnée disponible</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des données:', error);
                    document.getElementById('periodeTableBody').innerHTML =
                        '<tr><td colspan="5">Erreur de chargement</td></tr>';
                });
        }

        function deletePeriode(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette période ?')) {
                fetch(`rest/delete/periode/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadPeriodes();
                        } else {
                            alert('Échec de la suppression');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la suppression:', error);
                        alert('Une erreur est survenue lors de la suppression.');
                    });
            }
        }

        document.addEventListener('DOMContentLoaded', loadPeriodes);
    </script>

</body>

</html>
