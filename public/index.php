<?php
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Fluent;

require __DIR__ . '/../vendor/autoload.php';

$app = new Illuminate\Container\Container;
with(new Illuminate\Events\EventServiceProvider($app))->register();
with(new Illuminate\Routing\RoutingServiceProvider($app))->register();
Illuminate\Container\Container::setInstance($app);

// database
$manager = new Manager();
$manager->addConnection(require '../config/database.php');
$manager->bootEloquent();

// view
$app->instance('config', new Fluent);
$app['config']['view.compiled'] = __DIR__ . '/../storage/framework/views/';
$app['config']['view.paths'] = [__DIR__ . '/../resources/views/'];
with(new Illuminate\View\ViewServiceProvider($app))->register();
with(new Illuminate\Filesystem\FilesystemServiceProvider($app))->register();

require __DIR__ . '/../app/Http/routes.php';
$request = Illuminate\Http\Request::createFromGlobals();
$response = $app['router']->dispatch($request);
$response->send();