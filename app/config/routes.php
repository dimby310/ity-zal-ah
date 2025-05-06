<?php

use app\controllers\DepartementController;
use app\controllers\NatureController;
use flight\Engine;
use flight\net\Router;
use app\controllers\RESTController;
use app\controllers\ImportController;
use app\controllers\BudgetController;
use app\controllers\PeriodeController;
use app\models\BaseModel;
use app\models\BudgetModel;
use app\models\LiaisonDepartement;
use app\models\NatureModel;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$router->get('/', function () {
  Flight::render('login');
});

$router->post('/login', function () {
  if (isset($_POST['departement'])) {
    $_SESSION['departement_id'] = $_POST['departement'];
    Flight::redirect('/budget-form');
  }
});

/****************************
 * Budget
 ****************************/

$router->get('/budget-form', function () {
  if ($_SESSION['departement_id']) {
    $actual_departement = $_SESSION['departement_id'];

    $model = new BaseModel('departement', Flight::primaryKey()['departement']);
    $_SESSION['departement'] = $model->getById($actual_departement)['data'];

    $liaisonDepartementModel = new LiaisonDepartement();
    $result = $liaisonDepartementModel->getRelationsForDepartement($actual_departement);

    if ($result['success']) 
      $departements = $result['data'];
    else 
      $departements = [];

    $periodeModel = new BaseModel('periode');
    $periodes = $periodeModel->getAll()['data'];
    
    Flight::render('budgetform', ['periodes' => $periodes, 'departements' => $departements]);
  }
});

$router->get('/budget', [BudgetController::class, "renderBudget"]);

/****************************
 * Admin
 ****************************/

$router->get('/budget', [BudgetController::class, "renderBudget"]);

/****************************
 * Admin
 ****************************/

$router->get('/admin', function () {
  $liaisonModel = new LiaisonDepartement();
  $result = $liaisonModel->getRelationsMatrix();
  if ($result['success'])
    $relations = $result['data'];
  else
    $relations = [];

  Flight::render('liaisondepartement', ['relations' => $relations]);
});

$router->group('/rest/liaisondepartement', function () use ($router) {
  $router->get('/', function () {
    $liaisonModel = new LiaisonDepartement();
    $result = $liaisonModel->getRelationsMatrix();
    if ($result['success'])
      $relations = $result['data'];
    else
      $relations = [];
    echo json_encode($relations);
  });
});


$router->post('/liaisondepartement/modif', function () {
  Flight::json(LiaisonDepartement::create_or_update($_POST['source'], $_POST['destinataire'], $_POST['permission']));
});

/****************************
 * Generalized Rest
 ****************************/

$router->group('/rest', function () use ($router) {
  // getAll
  $router->get('/@table:[a-zA-Z_]+', function ($table): void {
    $controller = new RESTController($table);
    $controller->getAll();
  });

  // getById
  $router->get('/@table:[a-zA-Z_]+/@id:[0-9]+', function ($table, $id): void {
    $controller = new RESTController($table);
    $controller->getById($id);
  });

  // delete
  $router->get('/delete/@table:[a-zA-Z_]+/@id:[0-9]+', function ($table, $id): void {
    $controller = new RESTController($table);
    $controller->delete($id);
  });
});

$natureController = new NatureController();
$router->get('/nature-formulaire', [$natureController,'create']);
$router->post('/nature-formulaire', [$natureController,'create']);
$router->get('/nature-liste', function() {
  Flight::render('natureListe');
});
$router->get('/nature-modif',function(){
  Flight::render('natureModif');
});
$router->post('/nature-modif', [$natureController,'update']);

$departementController = new DepartementController();
$router->get('/departement-formulaire', [$departementController, 'create']);
$router->post('/departement-formulaire', [$departementController, 'create']);
$router->get('/departement-liste', function() {
    Flight::render('departementListe');
});
$router->get('/departement-modif',function(){
  Flight::render('departementModif');
});
$router->post('/departement-modif', [$departementController, 'update']);

$periodeController = new PeriodeController();

$router->get('/periode-formulaire', [$periodeController, 'create']);
$router->post('/periode-formulaire', [$periodeController, 'create']);

$router->get('/periode-liste', function() {
    Flight::render('periodeListe');
});

$router->get('/periode-modif', [$periodeController, 'edit']);
$router->post('/periode-modif', [$periodeController, 'update']);

