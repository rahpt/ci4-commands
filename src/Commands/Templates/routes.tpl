
$routes->group('{{groupRouter}}', ['namespace'=>'App\Modules\{{moduleName}}\Controllers'] ,function($routes) {
    $routes->get('', '{{controllerName}}::index');
    $routes->get('create', '{{controllerName}}::create');
    $routes->post('', '{{controllerName}}::store');
{{#useController}}
    $routes->get('(:segment)', '{{controllerName}}::show/1');
    $routes->get('(:segment)/edit', '{{controllerName}}::edit/1');
    $routes->put('(:segment)', '{{controllerName}}::update/1');
    $routes->delete('(:segment)', '{{controllerName}}::destroy/1');
{{/useController}}
});
