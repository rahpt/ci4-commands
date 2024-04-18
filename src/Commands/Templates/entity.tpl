<?php

namespace App\Modules\{{moduleName}}\Entities;

use CodeIgniter\Entity\Entity;

class {{entityName}} extends Entity
{
    {{#fields}}
    public {{type}} ${{name}};
    {{/fields}}
}