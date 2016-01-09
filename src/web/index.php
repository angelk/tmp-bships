<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = new Silex\Application();

$debug = getenv('DEBUG');
if ($debug) {
    $app['debug'] = true;
}

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../Resources/views',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render(
        'home.html.twig',
        [
            'test' => uniqid(),
        ]
    );
});

$app->run();
