<?php

namespace Rahpt\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ModuleViews extends BaseCommand {

    use CommandTrait;

    protected $group = 'Modules';
    protected $name = 'module:views';
    protected $description = 'Generate views for a module CRUD.';
    protected $usage = 'module:views [module_name]';

    public function run(array $params) {
        // Verifica se foi passado o nome do módulo como argumento
        if (empty($params)) {
            return CLI::error('You must provide the module name.');
        }

        $moduleName = $this->getModuleName($params);
        $controllerName = $this->getControllerName($params, $moduleName);
        $tableName = $this->getTableName($params, strtolower($controllerName));

        $fieldDefs = $this->getFields($tableName);
        $viewsPath = APPPATH . "Modules/$moduleName/Views/$controllerName/";
        // Apenas para testes
        $this->test && delete_files(dirname($viewsPath), true);

        // Verifica se o diretório de views do módulo existe
        if (!is_dir($viewsPath)) {
            mkdir($viewsPath, 0777, true);
        }

        // Gera os arquivos de views para o CRUD
        $this->generateViewIndex($viewsPath, 'index', $moduleName, $controllerName, $fieldDefs);
        $this->generateViewCreate($viewsPath, 'create', $moduleName, $controllerName, $fieldDefs);
        $this->generateViewEdit($viewsPath, 'edit', $moduleName, $controllerName, $fieldDefs);
        $this->generateViewShow($viewsPath, 'show', $moduleName, $controllerName, $fieldDefs);

        CLI::write('Views generated successfully for module: ' . $moduleName, 'green');
    }

    protected function generateViewCreate($viewPath, $viewName, $moduleName, $controllerName, $fieldDefs) {
        // Caminho do arquivo de view
        $filePath = $viewPath . $viewName . '.php';

        // Verifica se o arquivo de view já existe
        if (file_exists($filePath)) {
            return CLI::error('View file already exists: ' . $viewName . '.php');
        }

        $templatePath = __DIR__ .  "/Templates/views/$viewName.tpl";
        $template = file_get_contents($templatePath);
        $data = [
            'moduleNameLower' => strtolower($moduleName),
            'controllerNameLower' => strtolower($controllerName),
            // 'modelName' => $modelName,
            // 'tableName' => $tableName,
            'primaryKey' => $this->getPrimaryKey($fieldDefs),
            // 'entityName' => $entityName,
            'fields' => $this->getFieldNames($fieldDefs),
        ];

        // Renderizar o template com os dados
        $content = $this->renderTemplate($template, $data);

        // Cria o arquivo de view
        file_put_contents($filePath, $content);
    }

    protected function generateViewIndex($viewPath, $viewName, $moduleName, $controllerName, $fieldDefs) {
        // Caminho do arquivo de view
        $filePath = $viewPath . $viewName . '.php';

        // Verifica se o arquivo de view já existe
        if (file_exists($filePath)) {
            return CLI::error('View file already exists: ' . $viewName . '.php');
        }

        $templatePath = __DIR__ .  "/Templates/views/$viewName.tpl";
        $template = file_get_contents($templatePath);
        $data = [
            'moduleNameLower' => strtolower($moduleName),
            'controllerNameLower' => strtolower($controllerName),
            // 'modelName' => $modelName,
            // 'tableName' => $tableName,
            'primaryKey' => $this->getPrimaryKey($fieldDefs),
            // 'entityName' => $entityName,
            'fields' => $this->getFieldNames($fieldDefs),
        ];

        // Renderizar o template com os dados
        $content = $this->renderTemplate($template, $data);

        // Cria o arquivo de view
        file_put_contents($filePath, $content);
    }

    protected function generateViewEdit($viewPath, $viewName, $moduleName, $controllerName, $fieldDefs) {
        // Caminho do arquivo de view
        $filePath = $viewPath . $viewName . '.php';

        // Verifica se o arquivo de view já existe
        if (file_exists($filePath)) {
            return CLI::error('View file already exists: ' . $viewName . '.php');
        }

        $templatePath = __DIR__ .  "/Templates/views/$viewName.tpl";
        $template = file_get_contents($templatePath);
        $data = [
            'moduleNameLower' => strtolower($moduleName),
            'controllerNameLower' => strtolower($controllerName),
            // 'modelName' => $modelName,
            // 'tableName' => $tableName,
            'primaryKey' => $this->getPrimaryKey($fieldDefs),
            // 'entityName' => $entityName,
            'fields' => $this->getFieldNames($fieldDefs),
        ];
        // Renderizar o template com os dados
        $content = $this->renderTemplate($template, $data);

        // Cria o arquivo de view
        file_put_contents($filePath, $content);
    }

    protected function generateViewShow($viewPath, $viewName, $moduleName, $controllerName, $fieldDefs) {
        // Caminho do arquivo de view
        $filePath = $viewPath . $viewName . '.php';

        // Verifica se o arquivo de view já existe
        if (file_exists($filePath)) {
            return CLI::error('View file already exists: ' . $viewName . '.php');
        }

        $templatePath = __DIR__ .  "/Templates/views/$viewName.tpl";
        $template = file_get_contents($templatePath);
        $data = [
            'moduleNameLower' => strtolower($moduleName),
            'controllerNameLower' => strtolower($controllerName),
            // 'modelName' => $modelName,
            // 'tableName' => $tableName,
            'primaryKey' => $this->getPrimaryKey($fieldDefs),
            // 'entityName' => $entityName,
            'fields' => $this->getFieldNames($fieldDefs),
        ];
        // Renderizar o template com os dados
        $content = $this->renderTemplate($template, $data);

        // Cria o arquivo de view
        file_put_contents($filePath, $content);
    }
}
