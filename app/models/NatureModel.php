<?php

namespace app\models;

use \PDO;
use Flight;
use app\models\util\ArrayUtil;

class NatureModel{
    protected $db;

    public function __construct() {
        $this->db = Flight::mysql();
    }

    public function getAll() {
        $query = "
            SELECT 
                n.id_nature, 
                n.nom AS nature_nom, 
                t.nom AS type_nom, 
                c.nom AS categorie_nom
            FROM nature n
            LEFT JOIN type t ON n.id_type = t.id_type
            LEFT JOIN categorie c ON t.id_categorie = c.id_categorie
        ";
        
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    
}