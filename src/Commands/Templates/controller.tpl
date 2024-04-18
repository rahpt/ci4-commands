<?php

namespace App\Modules\{{moduleName}}\Controllers;

use CodeIgniter\Controller;
use App\Modules\{{moduleName}}\Models\{{modelName}};

class {{controllerName}} extends Controller
{
    const VIEW = 'App\Modules\{{moduleName}}\Views/{{controllerNameLower}}';

    protected $helpers = ['form'];
    public function index()
    {
        $model = new {{modelName}}();
        $data['items'] = $model->findAll();

        return view(self::VIEW.'/index', $data);
    }

    public function create()
    {
        return view(self::VIEW.'/create');
    }

    public function store()
    {
          // Verifica se o formulário foi submetido
        if ($this->request->getMethod() === 'post') {
            // Obtém os dados do formulário
            $data = [
                // 'campo1' => $this->request->getPost('campo1'),
                $this->request->getPost(),
                // Adicione mais campos conforme necessário
            ];

            // Validação dos dados (opcional)

            // Salva os dados no banco de dados
            $this->model->insert($data);

            // Redireciona para uma página de sucesso ou exibe uma mensagem
            return redirect()->to({{moduleNameLower}}/{{controllerNameLower}});
        } else {
            // Se o formulário não foi submetido, redirecione para uma página de erro
            return redirect()->to(site_url('error'));
        }

    }

    public function edit($id = null)
    {
        // Fetch record by $id
    }

    public function update($id = null)
    {
        // Handle update operation
    }

    public function delete($id = null)
    {
        // Handle delete operation
    }
}
