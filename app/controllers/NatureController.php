<?php
namespace app\controllers;

use app\models\NatureModel;
use Flight;
use app\models\BaseModel;

class NatureController
{
    public function __construct()
    {
    
    }

    public function create()
    {
        $table = 'nature';
        $modelNature = new BaseModel($table);
        if (Flight::request()->method === 'POST') {
            $nom = trim(Flight::request()->data->nom);
            $id_type = Flight::request()->data->id_type;
            if (!empty($nom)) {
                $insert = $modelNature->create(["nom" => $nom,"id_type"=> $id_type]);
                Flight::render('natureListe'); 
            } else {
                Flight::render('natureFormulaire', ['error' => 'Le nom est requis.']);
            }
        } else {
            $modelType = new BaseModel('type');
            $type = $modelType->getAll();
            Flight::render('natureFormulaire',["types"=>$type['data']]);
        }
    }
    public function update()
    {
        $table = 'nature';
        $modelNature = new BaseModel($table);
        
        if (Flight::request()->method === 'POST') {
            $natureId = Flight::request()->data->id; 
            $nom = trim(Flight::request()->data->nom);
            $id_type = Flight::request()->data->id_type;
    
            if (!empty($natureId) && !empty($nom)) {
                $update = $modelNature->update($natureId, ["nom" => $nom, "id_type" => $id_type]);
                if ($update['success']) {
                    Flight::render('natureListe'); 
                } else {
                    Flight::render('natureFormulaire', ['error' => 'Erreur lors de la mise à jour.']);
                }
            } else {
                Flight::render('natureFormulaire', ['error' => 'Le nom et l\'ID sont requis.']);
            }
        } else {
            $modelType = new BaseModel('type');
            $type = $modelType->getAll();
            Flight::render('natureListe', ["types" => $type['data']]);
        }
    }
    
   
}

