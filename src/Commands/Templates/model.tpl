<?php

namespace App\Modules\{{moduleName}}\Models;

use CodeIgniter\Model;
use App\Modules\{{moduleName}}\Entities\{{entityName}};

class {{modelName}} extends Model
{
    protected $table      = '{{tableName}}'; 
    {{#primaryKey}}
    protected $primaryKey = '{{primaryKey}}';
    {{/primaryKey}}
    protected $returnType = {{entityName}}::class;
    
    // protected $useSoftDeletes = true;
    
    protected $allowedFields = [
        {{#fields}}
        '{{name}}',
        {{/fields}}
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';    
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
