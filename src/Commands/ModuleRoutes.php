<?php

namespace Rahpt\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ModuleRoutes extends BaseCommand {

    use CommandTrait;

    protected $group = 'Modules';
    protected $name = 'module:routes';
    protected $description = 'Generate routes for a module with CRUD methods.';
    protected $usage = 'module:routes [module_name]';

    public function run(array $params) {
        $moduleName = $this->getModuleName($params);
        $controllerName = $this->getControllerName($params);

        $modulePath = APPPATH . 'Modules/' . $moduleName;

        $routesFile = $modulePath . '/Config/Routes.php';

        $this->test && delete_files(dirname($routesFile), true);

        $RoutesContent = $this->generateRoutesContent($moduleName, $controllerName);

        if (!is_dir(dirname($routesFile))) {
            mkdir(dirName($routesFile), 777, true);
        }
        if (!file_exists($routesFile)) {
            write_file($routesFile, "<?php \n 
                 // Não utilizar segment na Rota principal do módulo.\n");
        }

        if (!file_put_contents($routesFile, $RoutesContent, FILE_APPEND)) {
            return CLI::error('Unable to write the file.');
        }

        CLI::write('Routes generated successfully for module: ' . $moduleName, 'green');
    }

    public function generateRoutesContent($moduleName, $controllerName) {
        // Carregar o template do modelo
        $templatePath = __DIR__ .  '/Templates/routes.tpl';
        if ($controllerName == $moduleName) {
            $groupRouter = strtolower($controllerName);
        } else {
            $groupRouter = strtolower($moduleName . '/' . $controllerName);
        }

        $template = file_get_contents($templatePath);
        $data = [
            'moduleName' => $moduleName,
            'moduleNameLower' => strtolower($moduleName),
            'controllerName' => $controllerName,
            'controllerNameLower' => strtolower($controllerName),
            'useController' => $controllerName != $moduleName,
            'groupRouter' => $groupRouter,
        ];
        // Renderizar o template com os dados
        $Content = $this->renderTemplate($template, $data);

        return $Content;
    }
}
