<h1>Edit Item</h1>

<?= form_open('{{moduleNameLower}}/{{controllerNameLower}}/update/'.$item['{{primaryKey}}']) ?>
    {{#fields}}
        <label for="{{name}}">{{label}}:</label>
        {{#isRequired}}
        <input type="text" id="{{name}}" name="{{name}}" value="<?= $item['{{name}}']?>" required><br>
        {{/isRequired}}            
        {{^isRequired}}
        <input type="text" id="{{name}}" name="{{name}}" value="<?= $item['{{name}}']?>"><br>
        {{/isRequired}}
    {{/fields}}

    <button type="submit">Update</button>
<?= form_close() ?>