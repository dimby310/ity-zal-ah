<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Departement | Liaison</title>
</head>

<body>
  <form action="" method="post" id="liaisonform">
    <fieldset>
      <legend>Modifier les permissions des departement</legend>
      <label for="source">Source: </label>
      <select name="source" id="source"></select>

      <label for="destinataire">Destinataire: </label>
      <select name="destinataire" id="destinataire"></select>

      <label for="permission">Permission: </label>
      <select name="permission" id="permission"></select>

      <br>
      <input type="submit" value="Modifier permission" id="buttonmodif">
    </fieldset>
  </form>

  <div>
    <p id="result"></p>
  </div>

  <div>
    <h1>Relations entre Départements</h1>
    <table>
      <thead>
        <tr>
          <th>Département / Destinataire</th>
          <?php foreach (array_keys($relations) as $dest_nom): ?>
            <th><?php echo $dest_nom; ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($relations as $source_nom => $row): ?>
          <tr>
            <td><?php echo $source_nom; ?></td>
            <?php foreach ($row as $dest_nom => $autorisation): ?>
              <td><?php echo $autorisation; ?></td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script src="<?= Flight::get('flight.base_url') ?>/public/assets/js/liaisondepartement.js"></script>
</body>

</html>