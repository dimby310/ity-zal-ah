<!DOCTYPE html>
<html lang="en">
<l>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Budget | Login</title>
  <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/public/assets/css/login.css">
</l>
<body>
  <form action="<?= Flight::get('flight.base_url') ?>/login" method="post">
    <fieldset class="retro-bordered">
      <legend><h3>Login de Departement</h3></legend>
      <div>
        <label for="choix-departement">Departement:</label>
        <select name="departement" id="choix-departement">
        </select>
      </div>
      <input type="submit" value="Login" class="btn-submit">
    </fieldset>
  </form>

  <script src="<?= Flight::get('flight.base_url') ?>/public/assets/js/login.js"></script>
</body>
</html>