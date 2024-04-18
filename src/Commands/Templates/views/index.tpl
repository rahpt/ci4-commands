<h1>List of Items</h1>

<a href="/{{moduleNameLower}}/{{controllerNameLower}}/create">Add New Item</a>

<table>
    <thead>
        <tr>
        {{#fields}}
            <th>{{label}}</td>
        {{/fields}}
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item) : ?>
            <tr>
            {{#fields}}
                <td><?= $item->{{name}}?></td>
            {{/fields}}
                <td>
                    <a href="<?= site_url('{{moduleNameLower}}/{{controllerNameLower}}/edit'.$item->id) ?>">Edit</a>
                    <a href="<?= site_url('{{moduleNameLower}}/{{controllerNameLowers}}/delete').$item->id ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>