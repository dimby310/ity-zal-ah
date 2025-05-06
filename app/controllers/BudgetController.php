<?php

namespace app\controllers;

use app\models\BaseModel;
use Flight;
use app\models\BudgetModel;

class BudgetController
{
    private $budgetModel;
    private $departementModel;
    private $periodeModel;


    public function __construct()
    {
        $this->budgetModel = new BudgetModel();
        $this->departementModel = new BaseModel("departement");
        $this->periodeModel = new BaseModel("periode");
    }

    // Ajout d'une méthode pour afficher le formulaire
    public function renderBudgetForm()
    {
        // Récupérer tous les départements
        $departementsResult = $this->departementModel->getAll();
        $departements = ($departementsResult['success'] && isset($departementsResult['data'])) ? $departementsResult['data'] : [];
        
        // Récupérer toutes les périodes
        $periodesResult = $this->periodeModel->getAll();
        $periodes = ($periodesResult['success'] && isset($periodesResult['data'])) ? $periodesResult['data'] : [];
        
        // Passer les données à la vue
        $data = [
            'departements' => $departements,
            'periodes' => $periodes
        ];
        
        Flight::render("budget_form", $data);
    }

    public function renderBudget()
    {
        $query = Flight::request()->query;
        $periode_id = $query->periode_id;
        $departement_id = $query->departement_id;

        // Si aucun période_id ou departement_id n'est fourni, rediriger vers le formulaire
        if (empty($periode_id) || empty($departement_id)) {
            $this->renderBudgetForm();
            return;
        }

        $departementResult = $this->departementModel->getById($departement_id);
        $periodeResult = $this->periodeModel->getById($periode_id);

        $departement = $departementResult['data'];
        $periode = $periodeResult['data'];

        $budgetResult = $this->budgetModel->getBudget($periode_id, $departement_id);
        if (!$budgetResult['success'] || !isset($budgetResult['data']) || $budgetResult['data'] == null) {
            $data = ['departement' => $departement, 'periode' => $periode, 'error' => "Aucun budget disponible pour ce departement et la periode ({$periode['nom']}) ."];
            Flight::render("budget", $data);
            return;
        }

        $budget = $budgetResult['data'];

        $detailsResult = $this->budgetModel->getDetailsBudget($budget['id_budget']);
        $details = ($detailsResult['success'] && isset($detailsResult['data'])) ? $detailsResult['data'] : [];

        $data = [
            'departement' => $departement,
            'periode' => $periode,
            'budget' => $budget,
            'details' => $details,
        ];

        Flight::render("budget", $data);
    }
}