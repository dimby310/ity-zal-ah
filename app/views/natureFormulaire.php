<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Nature</title>
</head>
<body>
    <h1>Formulaire de création de Nature</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="nature-formulaire" method="POST">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div>
            <label for="id_type">Type :</label>
            <select id="id_type" name="id_type" required>
                <?php if (isset($types) && count($types) > 0): ?>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo $type['id_type']; ?>">
                            <?php echo htmlspecialchars($type['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">Aucun type disponible</option>
                <?php endif; ?>
            </select>
        </div>

        <div>
            <button type="submit">Ajouter</button>
        </div>
    </form>
</body>
</html>
