<?php

namespace app\models;

use Flight;

class LiaisonDepartement extends BaseModel
{
    public function __construct()
    {
        parent::__construct('liaison_departement');
    }

    public static function create_or_update(int $source, int $destinataire, string $autorisation)
    {
        try {

            if ($source == $destinataire)
                return ["success" => false, "message" => "La source ne peut pas etre le destinataire"];

            $pdo = Flight::mysql();

            $sql_check = "SELECT id_liaison FROM liaison_departement WHERE source = :source AND destinataire = :destinataire";
            $stmt = $pdo->prepare($sql_check);
            $stmt->execute([
                ':source' => $source,
                ':destinataire' => $destinataire
            ]);

            if ($stmt->rowCount() > 0) {
                $sql_update = "UPDATE liaison_departement SET autorisation = :autorisation WHERE source = :source AND destinataire = :destinataire";
                $stmt = $pdo->prepare($sql_update);
                $stmt->execute([
                    ':autorisation' => $autorisation,
                    ':source' => $source,
                    ':destinataire' => $destinataire
                ]);
                return ["success" => true, "message" => "Liaison mise à jour avec succès"];
            } else {
                $sql_insert = "INSERT INTO liaison_departement (source, destinataire, autorisation) VALUES (:source, :destinataire, :autorisation)";
                $stmt = $pdo->prepare($sql_insert);
                $stmt->execute([
                    ':source' => $source,
                    ':destinataire' => $destinataire,
                    ':autorisation' => $autorisation
                ]);
                return ["success" => true, "message" => "Liaison creee avec succès"];
            }
        } catch (\PDOException $e) {
            return ["success" => false, "message" => "Erreur SQL : " . $e->getMessage()];
        }
    }

    public function getAll()
    {
        try {
            $sql = "
                SELECT 
                    ld.id_liaison, 
                    COALESCE(ld.autorisation, '0') AS autorisation,  -- Si autorisation est NULL, on met 0 par defaut
                    source.nom AS source_nom, 
                    destinataire.nom AS destinataire_nom
                FROM 
                    {$this->table} ld
                LEFT JOIN 
                    departement source ON ld.source = source.id_departement
                LEFT JOIN 
                    departement destinataire ON ld.destinataire = destinataire.id_departement
            ";

            $stmt = self::$pdo->query($sql);
            $all = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return ['success' => true, 'message' => "Toutes les liaisons entre departements recuperees", 'data' => $all];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Erreur lors de la recuperation des enregistrements : ' . $e->getMessage()];
        }
    }

    public function getRelationsMatrix()
    {
        try {
            $sql_departements = "SELECT id_departement, nom FROM departement";
            $stmt = self::$pdo->query($sql_departements);
            $departements = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $departement_map = [];
            foreach ($departements as $departement) {
                $departement_map[$departement['id_departement']] = $departement['nom'];
            }

            $relations = [];
            foreach ($departement_map as $source_id => $source_nom) {
                $relations[$source_nom] = [];
                foreach ($departement_map as $dest_id => $dest_nom) {
                    $sql_relation = "
                        SELECT autorisation
                        FROM liaison_departement
                        WHERE source = ? AND destinataire = ?
                    ";
                    $stmt = self::$pdo->prepare($sql_relation);
                    $stmt->execute([$source_id, $dest_id]);
                    $result = $stmt->fetch(\PDO::FETCH_ASSOC);

                    $relations[$source_nom][$dest_nom] = $result ? $result['autorisation'] : '0';
                }
            }

            return ['success' => true, 'message' => "Toutes les relations sont recuperees", 'data' => $relations];

        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Erreur lors de la recuperation des relations : ' . $e->getMessage()];
        }
    }

    public function getRelationsForDepartement($departement_id) {
        try {
            $query = "SELECT *
                      FROM liaison_departement ld
                      JOIN departement d ON ld.destinataire = d.id_departement
                      WHERE ld.source = ?
                      AND (ld.autorisation = '1' OR ld.autorisation = '2')";
                      
            $stmt = self::$pdo->prepare($query);
            $stmt->execute([$departement_id]);
            
            $departements = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            return ['success' => true, 'data' => $departements];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
