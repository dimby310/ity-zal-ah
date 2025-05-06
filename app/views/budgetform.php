<?php
$baseUrl = Flight::get("flight.base_url");
$departement_id = isset($_SESSION['departement_id']) ? $_SESSION['departement_id'] : '';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Budget | Form</title>
  <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/budgetform.css">
</head>

<body>
  <form action="<?= $baseUrl ?>/budget" method="GET">
    <fieldset class="retro-bordered">
      <legend>Choisir une période et un département</legend>
      <input type="hidden" name="departement_actuel" value="<?= $departement_id ?>">
      <div>
        <label for="choix-periode">Période</label>
        <select name="periode_id" id="choix-periode">
          <?php if(isset($periodes) && is_array($periodes) && count($periodes) > 0): ?>
            <?php foreach ($periodes as $periode): ?>
              <option value="<?= $periode['id_periode'] ?>"><?= $periode['nom'] ?></option>
            <?php endforeach; ?>
          <?php else: ?>
            <option value="">Aucune période disponible</option>
          <?php endif; ?>
        </select>
      </div>
      <div>
        <label for="choix-departement">Département</label>
        <select name="departement_id" id="choix-departement">
          <?php if(isset($departements) && is_array($departements) && count($departements) > 0): ?>
            <?php foreach ($departements as $departement): ?>
              <option value="<?= $departement['id_departement'] ?>"><?= $departement['nom'] ?></option>
            <?php endforeach; ?>
          <?php else: ?>
            <option value="">Aucun département disponible</option>
          <?php endif; ?>
        </select>
      </div>
      <button class="btn-submit">Confirmer</button>
    </fieldset>
  </form>

  <script src="<?= $baseUrl ?>/public/assets/js/main.js"></script>
</body>

</html>