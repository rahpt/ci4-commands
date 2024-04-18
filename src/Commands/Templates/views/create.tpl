
<h1>Add New Item</h1>

<?= form_open('{{moduleNameLower}}/{{controllerNameLower}}') ?>
    {{#fields}}
        <label for="{{name}}">{{label}}:</label>
        {{#isRequired}}
        <input type="text" id="{{name}}" name="{{name}}" required><br>
        {{/isRequired}}            
        {{^isRequired}}
        <input type="text" id="{{name}}" name="{{name}}"><br>
        {{/isRequired}}
    {{/fields}}

    <button type="submit">Submit</button>
<?= form_close() ?>