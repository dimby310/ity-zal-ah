<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Départements</title>
</head>

<body>

    <h1>Liste des Départements</h1>
    <a href="departement-formulaire">Ajouter</a>
    <table>
        <thead>
            <tr>
                <th>ID Département</th>
                <th>Nom</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="departementTableBody">
            <tr>
                <td colspan="3">Chargement...</td>
            </tr>
        </tbody>
    </table>
  
    <script>
        function loadDepartements() {
            fetch('rest/departement')  
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('departementTableBody');
                    tbody.innerHTML = '';

                    if (data.data && data.data.length > 0) {
                        data.data.forEach(departement => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${departement.id_departement}</td>
                                <td>${departement.nom}</td>
                                <td>
                                    <a href="departement-modif?id=${departement.id_departement}">Modifier</a>
                                    <button onclick="deleteDepartement(${departement.id_departement})">Supprimer</button>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="3">Aucun département disponible</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des données:', error);
                    document.getElementById('departementTableBody').innerHTML =
                        '<tr><td colspan="3">Erreur de chargement</td></tr>';
                });
        }

        function deleteDepartement(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce département ?')) {
                fetch(`rest/delete/departement/${id}`)  
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadDepartements(); 
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

        document.addEventListener('DOMContentLoaded', loadDepartements); 
    </script>

</body>

</html>
