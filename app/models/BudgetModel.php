<?php

namespace app\models;

use \PDO;
use Flight;
use app\models\util\ArrayUtil;

class BudgetModel extends BaseModel
{
    public function __construct()
    {
        $table = "budget";
        $primaryKey = Flight::primaryKey()[$table];
        parent::__construct($table, $primaryKey);
    }

    public function getBudget($periode, $departement)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id_periode = ? AND id_departement = ?";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([$periode, $departement]);
            $budget = $stmt->fetch(PDO::FETCH_ASSOC);

            return ['success' => true, 'message' => 'Budget fetched', 'data' => $budget];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Erreur lors de la récupération du budget : ' . $e->getMessage()];
        }
    }

    public function getDetailsBudget($id_budget)
    {
        try {
            $sql = "SELECT 
                db.id_detail,
                db.montant_prevision,
                db.montant_realisation,
                
                n.id_nature,
                n.nom AS nom_nature,
                
                t.id_type,
                t.nom AS nom_type,
                
                c.id_categorie,
                c.nom AS nom_categorie,
                
                b.id_budget,
                b.solde_debut,
                b.solde_fin,
                
                d.id_departement,
                d.nom AS nom_departement,
                
                p.id_periode,
                p.nom AS nom_periode,
                p.mois,
                p.annee
            FROM detail_budget db
            JOIN nature n ON db.id_nature = n.id_nature
            JOIN type t ON n.id_type = t.id_type
            JOIN categorie c ON t.id_categorie = c.id_categorie
            JOIN budget b ON db.id_budget = b.id_budget
            JOIN departement d ON b.id_departement = d.id_departement
            JOIN periode p ON b.id_periode = p.id_periode

            WHERE db.id_budget = ?;";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([$id_budget]);
            $details = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['success' => true, 'data' => $details];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Erreur lors de la récupération des détails du budget : ' . $e->getMessage()];
        }
    }
}
