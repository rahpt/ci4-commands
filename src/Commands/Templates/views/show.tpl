   <h1>Item Details</h1>

    <ul>
    {{#fields}}        
        <li><strong>{{label}}:</strong> {{name}}</li>
    {{/fields}}
    </ul>

    <a href="<?= site_url('{{moduleNameLower}}/{{controllerNameLower}}/edit/').$item['{{primaryKey}}']?>">Edit</a>
    <a href="<?= site_url('{{moduleNameLower}}/{{controllerNameLower}}/delete/').$item['{{primaryKey}}'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
