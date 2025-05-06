<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Département</title>
</head>

<body>
    <h1>Formulaire de création de Département</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="departement-formulaire" method="POST">
        <div>
            <label for="nom">Nom du Département :</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div>
            <button type="submit">Ajouter</button>
        </div>
    </form>
</body>

</html>
