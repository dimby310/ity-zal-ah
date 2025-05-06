<?php

use flight\Engine;
use flight\database\PdoWrapper;
use flight\debug\database\PdoQueryCapture;
use Tracy\Debugger;

/** 
 * @var array $config This comes from the returned array at the bottom of the config.php file
 * @var Engine $app
 */

// uncomment the following line for MySQL
 $mysqldsn = 'mysql:host=' . $config['mysql']['host'] . ';dbname=' . $config['mysql']['dbname'] . ';charset=utf8mb4';

// uncomment the following line for SQLite
//$dsn = 'sqlite:' . $config['database']['file_path'];

// Uncomment the below lines if you want to add a Flight::db() service
// In development, you'll want the class that captures the queries for you. In production, not so much.
 $pdoClass = Debugger::$showBar === true ? PdoQueryCapture::class : PdoWrapper::class;
 $app->register('mysql', $pdoClass, [ $mysqldsn, $config['mysql']['user'] ?? null, $config['mysql']['password'] ?? null ]);
// Got google oauth stuff? You could register that here
// $app->register('google_oauth', Google_Client::class, [ $config['google_oauth'] ]);

// Redis? This is where you'd set that up
// $app->register('redis', Redis::class, [ $config['redis']['host'], $config['redis']['port'] ]);

Flight::map('primaryKey', function() {
    $primaryKey = [
        'categorie' => 'id_categorie',
        'departement' => 'id_departement',
        'periode' => 'id_periode',
        'type' => 'id_type',
        'budget' => 'id_budget',
        'liaison_departement' => 'id_liaison',
        'nature' => 'id_nature',
        'detail_budget' => 'id_detail'
    ];
    return $primaryKey;
});
// Flight::map('productModel', function () {
    // return new ProductModel(Flight::db());
// });