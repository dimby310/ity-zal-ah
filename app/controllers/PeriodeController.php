<?php
namespace app\controllers;

use app\models\BaseModel;
use Flight;

class PeriodeController
{
    public function __construct()
    {
        
    }

    public function create()
    {
        $table = 'periode';
        $modelPeriode = new BaseModel($table);
        
        if (Flight::request()->method === 'POST') {
            $nom = trim(Flight::request()->data->nom);
            $mois = (int) Flight::request()->data->mois;
            $annee = (int) Flight::request()->data->annee;

            if (!empty($nom) && $mois > 0 && $mois <= 12 && $annee > 1900) {
              
                $insert = $modelPeriode->create([
                    "nom" => $nom,
                    "mois" => $mois,
                    "annee" => $annee
                ]);
                
                Flight::render('periodeListe');  
            } else {
                Flight::render('periodeFormulaire', ['error' => 'Tous les champs sont requis et valides.']);
            }
        } else {
            Flight::render('periodeFormulaire');
        }
    }

    public function update()
    {
        $table = 'periode';
        $modelPeriode = new BaseModel($table);
        
        if (Flight::request()->method === 'POST') {
            
            $periodeId = Flight::request()->data->id;
            $nom = trim(Flight::request()->data->nom);
            $mois = (int) Flight::request()->data->mois;
            $annee = (int) Flight::request()->data->annee;
    
            if (!empty($periodeId) && !empty($nom) && $mois > 0 && $mois <= 12 && $annee > 1900) {
                $update = $modelPeriode->update($periodeId, [
                    "nom" => $nom,
                    "mois" => $mois,
                    "annee" => $annee
                ]);
                if ($update['success']) {
                    Flight::render('periodeListe'); 
                } else {
                    Flight::render('periodeFormulaire', ['error' => 'Erreur lors de la mise à jour de la période.']);
                }
            } else {
                Flight::render('periodeFormulaire', ['error' => 'Tous les champs sont requis et valides.']);
            }
        } else {
            Flight::render('periodeListe');
        }
    }
}
