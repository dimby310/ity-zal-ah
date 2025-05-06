<?php
namespace app\controllers;

use app\models\NatureModel;
use Flight;
use app\models\BaseModel;

class DepartementController
{
    public function __construct()
    {
    
    }

    public function create()
    {
        $table = 'departement';
        $modelNature = new BaseModel($table);
        if (Flight::request()->method === 'POST') {
            $nom = trim(Flight::request()->data->nom);
            if (!empty($nom)) {
                $insert = $modelNature->create(["nom" => $nom]);
                Flight::render('departementListe'); 
            } else {
                Flight::render('departementFormulaire', ['error' => 'Le nom est requis.']);
            }
        } else {
            Flight::render('departementFormulaire');
        }
    }
    public function update()
    {
        $table = 'departement';
        $modelNature = new BaseModel($table);
        
        if (Flight::request()->method === 'POST') {
            $departementId = Flight::request()->data->id; 
            $nom = trim(Flight::request()->data->nom);
    
            if (!empty($departementId) && !empty($nom)) {
                $update = $modelNature->update($departementId, ["nom" => $nom]);
                if ($update['success']) {
                    Flight::render('departementListe'); 
                } else {
                    Flight::render('departementFormulaire', ['error' => 'Erreur lors de la mise à jour.']);
                }
            } else {
                Flight::render('departementFormulaire', ['error' => 'Le nom et l\'ID sont requis.']);
            }
        } else {
            Flight::render('departementListe');
        }
    }
    
   
}

