<?php

namespace Rahpt\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Commands\Classes\Convert;

class ModuleModel extends BaseCommand {

    use CommandTrait;

    protected $group = 'Modules';
    protected $name = 'module:model';
    protected $description = 'Create a model and entity from an existing database table';
    protected $usage = 'module:model [module_name] [model_name] [table_name]';
    protected $arguments = [
        'module_name' => 'The name of the module to create the model in',
        'model_name' => 'The name of the model to create',
        'table_name' => 'The name of the existing database table',
    ];

    public function run(array $params) {
        $moduleName = $this->getModuleName($params);
        $modelName = $this->getModelName($params, $moduleName);
        $tableName = $this->getTableName($params);

        // Obter detalhes da tabela
        $fields = $this->getFields($tableName);
        $modulePath = APPPATH . 'Modules/' . $moduleName;

        // Salvar modelo e entidade nos respectivos diretórios
        // Criar classe de entidade
        $entityName = $this->removeSuffixIfNeeded($modelName, 'Model') . 'Entity';
        $entityContent = $this->generateEntityContent($moduleName, $modelName, $entityName, $fields);
        $entityFile = $modulePath . '/Entities/' . $entityName . '.php';
        // Apenas para testes
        $this->test && delete_files(dirname($entityFile), true);

        if (file_exists($entityFile)) {
            $this->showError("Entity '$entityName' already exists in module '$moduleName'.");
        }
        if (!is_dir(dirNAme($entityFile))) {
            mkdir(dirname($entityFile), 777, true);
        }
        if (!write_file($entityFile, $entityContent)) {
            $this->showError("Failed to create entity '$entityName' in module '$moduleName'.");
        }
        $this->showMessage("Entity '$modelName' created successfully in module '$moduleName'.");

        // Criar classe de modelo
        $modelContent = $this->generateModelContent($moduleName, $tableName, $modelName, $fields);
        $modelFile = $modulePath . '/Models/' . $modelName . '.php';

        $this->test && delete_files(dirname($modelFile), true);

        if (file_exists($modelFile)) {
            $this->showError("Model '$modelName' already exists in module '$moduleName'.");
        }
        if (!is_dir(dirname($modelFile))) {
            mkdir(dirName($modelFile), 777, true);
        }
        if (!write_file($modelFile, $modelContent)) {
            $this->showError("Failed to create model '$modelName' in module '$moduleName'.");
        }
        $this->showMessage("Model '$modelName' created successfully in module '$moduleName'.");
    }

    protected function generateModelContent($moduleName, $tableName, $modelName, $fieldData) {
        // Carregar o template do modelo
        $templatePath = __DIR__  . '/Templates/model.tpl';
        $template = file_get_contents($templatePath);

        $entityName = $this->removeSuffixIfNeeded($modelName, 'Model') . 'Entity';

        // Campos da tabela
        $tableFieldNames = [];
        foreach ($fieldData as $field) {
            $tableFieldNames[] = ['name' => $field->name];
        }

        $primaryKey = $this->getPrimaryKey($fieldData);

        $data = [
            'moduleName' => $moduleName,
            'modelName' => $modelName,
            'tableName' => $tableName,
            'primaryKey' => $primaryKey,
            'entityName' => $entityName,
            'fields' => $tableFieldNames
        ];

        // Renderizar o template com os dados
        $modelContent = $this->renderTemplate($template, $data);

        return $modelContent;
    }

    protected function generateEntityContent($moduleName, $modelName, $entityName, $fields) {
        // Carregar o template da entidade
        $templatePath = __DIR__ .  '/Templates/entity.tpl';
        $template = file_get_contents($templatePath);

        // Campos da tabela
        $tableFields = [];
        foreach ($fields as $field) {
            $tableFields[] = [
                'name' => $field->name,
                'type' => Convert::DbTypeToPhpType($field->type),
            ];
        }

        $data = [
            'moduleName' => $moduleName,
            'modelName' => $modelName,
            'entityName' => $entityName,
            'fields' => $tableFields
        ];

        // Renderizar o template com os dados
        $entityContent = $this->renderTemplate($template, $data);

        return $entityContent;
    }
}
