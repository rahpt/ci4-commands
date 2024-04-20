<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace Rahpt\Commands;

use CodeIgniter\CLI\CLI;

/**
 * Description of BaseCommand
 *
 * @author jose.proenca
 */
trait CommandTrait {

    public bool $test = true;
    public array $fieldDefs = [];
    public string $keyField;

    protected function showError($message) {
        $this->print('Error: ' . $message, 'red');
        exit(1);
    }

    protected function showMessage($message) {
        $this->print($message, 'green');
    }

    protected function print($message, $color = null) {
        CLI::write($message, $color);
    }

    public function getModuleName(&$params) {
        $moduleName = array_shift($params);

        if (empty($moduleName)) {
            $moduleName = CLI::prompt('Enter the name of the module');
        }

        if (empty($moduleName)) {
            $this->showError('Module name is required.');
        }

        return ucfirst($moduleName);
    }

    public function getControllerName(&$params, $default = '') {
        $controllerName = array_shift($params);
        if (empty($controllerName) && !empty($default)) {
            return $default;
        }

        if (empty($controllerName)) {
            $controllerName = CLI::prompt('Enter the name of the module');
        }

        if (empty($controllerName)) {
            return CLI::error('You must provide a controller name.');
        }

        return ucfirst($controllerName);
    }

    private function getModelName(&$params, $default) {
        $modelName = array_shift($params);

        if (empty($modelName) && !empty($default)) {
            $modelName = $default;
        }

        if (empty($modelName)) {
            $modelName = CLI::prompt('Enter the name of the model');
        }
        $modelName = $this->addSuffixIfNeeded($modelName, 'Model');

        if (empty($modelName)) {
            $this->showError('Model name is required.');
        }
        return ucfirst($modelName);
    }

    private function getTableName(&$params) {
        $tableName = array_shift($params);

        if (empty($tableName)) {
            $tableName = CLI::prompt('Enter the name of the table');
        }

        if (empty($tableName)) {
            $this->showError('Table name is required.');
        }
        return $tableName;
    }

    public function getPrimaryKey($fieldData) {
        // Preencher os valores no template
        $primaryKey = ''; // Determinar a chave primária da tabela

        foreach ($fieldData as $field) {
            if ($field->primary_key) {
                $primaryKey = $field->name;
                break;
            }
        }
        return $primaryKey;
    }

    public function getFields($tableName) {
        // Obter detalhes da tabela
        $db = db_connect();
        if (!$db->tableExists($tableName)) {
            return [];
        }
        $fieldData = $db->getFieldData($tableName);

        if (empty($fieldData)) {
            $this->showError("Table '$tableName' does not exist or has no fields.");
        }

        return $fieldData;
    }

    public function getFieldNames($fieldDefs) {
        // Obter detalhes da tabela
        $tableFieldNames = [];
        // dd($fieldDefs);
        foreach ($fieldDefs as $field) {
            $tableFieldNames[] = [
                'name' => $field->name,
                'label' => ucfirst($field->name),
                'isRequired' => !$field->nullable,
            ];
        }
        return $tableFieldNames;
    }

    protected function renderTemplate($template, $data) {

        $mustache = new \Mustache_Engine();
        return $mustache->render($template, $data);
    }

    protected function addSuffixIfNeeded(string $string, string $suffix): string {
        // Verifica se a string já termina com o sufixo
        if (str_ends_with($string, $suffix)) {
            // Se sim, retorna a string original
            return $string;
        } else {
            // Se não, adiciona o sufixo e retorna
            return $string . $suffix;
        }
    }

    protected function removeSuffixIfNeeded(string $string, string $suffix): string {
        // Verifica se a string termina com o sufixo
        if (str_ends_with($string, $suffix)) {
            // Se sim, remove o sufixo e retorna a string modificada
            return substr($string, 0, -strlen($suffix));
        } else {
            // Se não, retorna a string original
            return $string;
        }
    }
}
