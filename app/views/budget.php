<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget</title>
</head>

<body>
    <?php if (isset($error)): ?>
        <p><?= $error ?></p>
    <?php else: ?>

        <h2>Budget du departement <?= $departement['nom'] ?> pour la periode <?= $periode['nom'] ?></h2>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">Rubrique / Nature</th>
                    <th rowspan="2">Type</th>
                    <th rowspan="2">Catégorie</th>
                    <th colspan="3">Montant</th>
                </tr>
                <tr>
                    <th>Prévision</th>
                    <th>Réalisation</th>
                    <th>Écart</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Solde début</td>
                    <td colspan="5"><?= number_format($budget['solde_debut'], 2, ',', ' ') ?></td>
                </tr>

                <?php foreach ($details as $detail): ?>
                    <tr>
                        <td><?= $detail['nom_nature'] ?></td>
                        <td><?= $detail['nom_type'] ?></td>
                        <td><?= $detail['nom_categorie'] ?></td>
                        <td><?= number_format($detail['montant_prevision'], 2, ',', ' ') ?></td>
                        <td><?= number_format($detail['montant_realisation'], 2, ',', ' ') ?></td>
                        <td><?= number_format($detail['montant_prevision'] - $detail['montant_realisation'], 2, ',', ' ') ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td>Solde fin</td>
                    <td colspan="5"><?= number_format($budget['solde_fin'], 2, ',', ' ') ?></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>