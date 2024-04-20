<?php

namespace Rahpt\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ModuleController extends BaseCommand {

    use CommandTrait;

    /** @var String $group Group */
    protected $group = 'Modules';

    /** @var String $name Command's name */
    protected $name = 'module:controller';

    /** @var String $description Command description */
    protected $description = 'Create a new Modules controller.';

    /** @var String $usage Command usage */
    protected $usage = 'module:controller [module_name] [controller_name]';

    /** @var Array $arguments the Command's Arguments */
    protected $arguments = [
        'module_name' => 'The name of the module to create the model in',
        'controller_name' => 'The name of the controller to create',
    ];

    public function run(array $params) {
        $moduleName = $this->getModuleName($params);
        $controllerName = $this->getControllerName($params, $moduleName);

        $modulePath = APPPATH . 'Modules/' . $moduleName;
        $controllerFile = $modulePath . '/Controllers/' . ucfirst($controllerName) . '.php';

        $this->test && delete_files(dirname($controllerFile), true);

        if (file_exists($controllerFile)) {
            return CLI::error('Controller already exists.');
        }

        $controllerContent = $this->generateControllerContent($moduleName, $controllerName);
        if (!is_dir(dirname($controllerFile))) {
            mkdir(dirName($controllerFile), 777, true);
            $this->generateAppJson($modulePath);
        }
        if (!write_file($controllerFile, $controllerContent)) {
            return CLI::error('Unable to write the file.');
        }

        return CLI::write('Controller created successfully: ' . $controllerName);
    }

    public function generateAppJson($modulePath) {
        $templatePath = __DIR__ . '/Templates/app.json.tpl';
        $template = file_get_contents($templatePath);
        write_file($modulePath . '/app.json', $template);
    }

    public function generateControllerContent($moduleName, $controllerName) {
        // Carregar o template do modelo
        $dummy = [$controllerName];
        $modelName = $this->getModelName($dummy, $controllerName);

        $templatePath = __DIR__ . '/Templates/controller.tpl';
        $template = file_get_contents($templatePath);
        $data = [
            'moduleName' => ucfirst($moduleName),
            'ModuleNameLower' => strtolower($controllerName),
            'controllerName' => ucfirst($controllerName),
            'controllerNameLower' => strtolower($controllerName),
            'modelName' => ucfirst($modelName),
        ];
        // Renderizar o template com os dados
        $Content = $this->renderTemplate($template, $data);

        return $Content;
    }
}
