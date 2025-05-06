<?php 
namespace app\controllers;

use app\models\BaseModel;
use Flight;

class RESTController {
    
    protected $table;

    public function __construct($table) {
        $this->table = $table;
    }

    public function getAll() {
        $model = new BaseModel( $this->table);
        $data = $model->getAll();
        Flight::json($data);
    }

    public function getById($id) {
        $model = new BaseModel( $this->table);
        $data = $model->getById($id);
        Flight::json($data);
    }

    public function delete($id) {
        $model = new BaseModel( $this->table);
        $json = $model->delete($id);
        Flight::json($json);
    }
}