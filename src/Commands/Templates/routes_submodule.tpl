$routes->group('{{moduleName}}/{{controllerNameLower}}', function($routes) {
    $routes->get('', '{{controllerName}}::index');
    $routes->get('create', '{{controllerName}}::create');
    $routes->post('', '{{controllerName}}::store');
    $routes->get('(:segment)', '{{controllerName}}::show/1');
    $routes->get('(:segment)/edit', '{{controllerName}}::edit/1');
    $routes->put('(:segment)', '{{controllerName}}::update/1');
    $routes->delete('(:segment)', '{{controllerName}}::destroy/1');
});
