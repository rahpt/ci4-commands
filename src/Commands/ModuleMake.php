<?php

namespace Rahpt\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ModuleMake extends BaseCommand {

    use CommandTrait;

    protected $group = 'Modules';
    protected $name = 'module';
    protected $description = 'Generate a complete module (controller, model, entity and routes).';
    protected $usage = 'module [module_name] [controller_name] [table_name]';

    public function run(array $params) {
        // Verifica se foi passado o nome do módulo como argumento

        $moduleName = $this->getModuleName($params);
        $controllerName = $this->getControllerName($params, $moduleName);
        $modelName = $controllerName . 'Model';
        $tableName = strtolower($this->getcontrollerName($params, $controllerName));

        // Chama o comando para gerar o controller
        $generateController = "module:controller {$moduleName} {$controllerName}";
        CLI::write("Generating controller for module: {$moduleName}");
        $this->callCommand($generateController);

        // Chama o comando para gerar o model
        $generateModel = "module:model {$moduleName} {$modelName} {$tableName}";
        CLI::write("Generating model for module: {$moduleName}");
        $this->callCommand($generateModel);

        // Chama o comando para gerar as rotas
        $generateRoutes = "module:routes {$moduleName} {$controllerName}";
        CLI::write("Generating routes for module: {$moduleName}:{$controllerName}");
        $this->callCommand($generateRoutes);

        // Chama o comando para gerar as rotas
        $generateViews = "module:views {$moduleName} {$controllerName} {$tableName}";
        CLI::write("Generating views for module: {$moduleName}:{$controllerName}");
        $this->callCommand($generateViews);

        CLI::write('Module generated successfully.', 'green');
    }

    protected function callCommand($command) {
        $result = command($command);

        if ($result !== '') {
            CLI::error('Failed to execute command: ' . $command);
            exit();
        }
    }
}
