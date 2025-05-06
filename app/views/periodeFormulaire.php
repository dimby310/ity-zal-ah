<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Période</title>
</head>

<body>
    <h1>Formulaire de création de Période</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="periode-formulaire" method="POST">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div>
            <label for="mois">Mois :</label>
            <input type="number" id="mois" name="mois" required min="1" max="12">
        </div>

        <div>
            <label for="annee">Année :</label>
            <input type="number" id="annee" name="annee" required min="1900" max="2100">
        </div>

        <div>
            <button type="submit">Ajouter</button>
        </div>
    </form>
</body>

</html>