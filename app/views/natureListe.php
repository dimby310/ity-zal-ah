<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Natures</title>
</head>

<body>

    <h1>Liste des Natures</h1>
    <a href="nature-formulaire">Ajouter</a>
    <table>
        <thead>
            <tr>
                <th>ID Nature</th>
                <th>Nom</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="natureTableBody">
            <tr>
                <td colspan="2">Chargement...</td>
            </tr>
        </tbody>
    </table>
  
    <script>
        function loadNatures() {
            fetch('rest/nature')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('natureTableBody');
                    tbody.innerHTML = '';

                    if (data.data && data.data.length > 0) {
                        data.data.forEach(nature => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${nature.id_nature}</td>
                                <td>${nature.nom}</td>
                                <td>
                                    <a href="nature-modif?id=${nature.id_nature}">Modifier</a>
                                    <button onclick="deleteNature(${nature.id_nature})">Supprimer</button>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="2">Aucune donnée disponible</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des données:', error);
                    document.getElementById('natureTableBody').innerHTML =
                        '<tr><td colspan="2">Erreur de chargement</td></tr>';
                });
        }
        function deleteNature(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette nature ?')) {
                fetch(`rest/delete/nature/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadNatures(); 
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

        document.addEventListener('DOMContentLoaded', loadNatures);
    </script>

</body>

</html>