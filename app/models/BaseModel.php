<?php

namespace app\models;

use \PDO;
use Flight;
use app\models\util\ArrayUtil;

class BaseModel
{
    protected static $pdo;
    public $table;
    public $primaryKey;
    
    public static function init()
    {
        self::$pdo = Flight::mysql();
    }
    
    public function __construct($table, $primaryKey = null)
    {
        if (self::$pdo === null) {
            self::init();
        }
        
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        
        if ($this->primaryKey === null) {
            $primaryKeys = Flight::primaryKey();
            if (isset($primaryKeys[$table])) {
                $this->primaryKey = $primaryKeys[$table];
            } else {
                $this->primaryKey = 'id'; // Valeur par défaut
            }
        }
    }

    public function create($data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));

            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            $stmt = self::$pdo->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            $stringData = ArrayUtil::arrayToString($data);

            return ['success' => true, 'message' => "Record created successfully: {$stringData}"];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Error creating record: ' . $e->getMessage()];
        }
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = self::$pdo->query($sql);
            $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return (['success' => true, 'message' => "All records of {$this->table} fetched", 'data' => $all]);
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Error fetching records: ' . $e->getMessage()];
        }
    }

    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $element = $stmt->fetch(PDO::FETCH_ASSOC);
            return ['success' => true, 'message' => "Record of {$this->table} id {$id} fetched", 'data' => $element];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Error fetching record: ' . $e->getMessage()];
        }
    }

    public function update($id, $data)
    {
        try {
            $setClause = '';
            foreach ($data as $key => $value) {
                $setClause .= "$key = :$key, ";
            }
            $setClause = rtrim($setClause, ", ");
            $sql = "UPDATE {$this->table} SET $setClause WHERE {$this->primaryKey} = :id";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute();
            return ['success' => true, 'message' => "ID: {$id} of table {$this->table} updated"];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Error updating record: ' . $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return ['success' => true, 'message' => "ID: {$id} of table {$this->table} deleted"];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Error deleting record: ' . $e->getMessage()];
        }
    }

    public function getTableColumns()
    {
        try {
            $sql = "SHOW COLUMNS FROM {$this->table}";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute();
            $columns = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $columns[] = $row['Field'];
            }

            return ['success' => true, 'data' => $columns];
        } catch (\PDOException $e) {
            return ['success' => false, 'message' => 'Error fetching columns: ' . $e->getMessage()];
        }
    }
}

// Ne pas initialiser ici, mais plutôt dans le bootstrap de l'application
// BaseModel::init();