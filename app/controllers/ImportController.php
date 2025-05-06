<?php

namespace app\controllers;

use app\models\BaseModel;
use Flight;

class ImportController
{
    protected $model;

    public function __construct($table, $primaryKey) {
        $this->model = new BaseModel($table, $primaryKey);
    }

    public function importCsv($fileContent, $separator = ",") {
        $lines = $this->extractLines($fileContent);
        
        if (empty($lines)) {
            return json_encode(["success" => false, "message" => "Empty file content"]);
        }
        
        $given_columns = $this->processGivenColumns(array_shift($lines), $separator);
        
        $columns = $this->getCleanedColumns();
        
        $unknown_columns = $this->checkUnknownColumns($given_columns, $columns);
        
        if (!empty($unknown_columns)) {
            return json_encode(["success" => false, "message" => "Unknown columns: " . implode(", ", $unknown_columns)]);
        }
        
        foreach ($lines as $line) {
            $data = $this->processCsvLine($line, $given_columns, $separator);
            
            if ($data) {
                $result = $this->model->create($data);
                if (!$result['success']) {
                    return json_encode($result);
                }
            }
        }
        
        return json_encode(["success" => true, "message" => "CSV imported successfully"]);
    }
    
    private function extractLines($fileContent) {
        $lines = explode("\n", trim($fileContent));
        return array_filter($lines, function ($line) {
            return trim($line) !== "";
        });
    }
    
    private function processGivenColumns($line, $separator) {
        $given_columns = explode($separator, $line);
        foreach ($given_columns as $index => $column) {
            $given_columns[$index] = strtolower(trim($column));
        }
        return $given_columns;
    }
    
    private function getCleanedColumns() {
        $columns = $this->model->getTableColumns();
        foreach ($columns as $index => $column) {
            $columns[$index] = strtolower(trim($column));
        }
        return array_diff($columns, [strtolower($this->model->primaryKey)]); // Remove primary key
    }
    
    private function checkUnknownColumns($given_columns, $columns) {
        return array_diff($given_columns, $columns);
    }
    
    private function processCsvLine($line, $given_columns, $separator) {
        $data = explode($separator, $line);
        if (count($data) === count($given_columns)) {
            $dataAssoc = [];
            foreach ($given_columns as $index => $column) {
                $dataAssoc[$column] = $this->removeQuotes($data[$index]);
            }
            return $dataAssoc;
        }
        return null; 
    }
    
    private function removeQuotes($value) {
        if (is_string($value)) {
            $value = trim($value, "'\""); // Single and double quotes
        }
        return $value;
    }
    
}
