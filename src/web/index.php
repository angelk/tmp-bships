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
    
    $savedData = isset($_SESSION['battleship.progress']) ? $_SESSION['battleship.progress'] : null;
    if ($savedData) {
        
    } else {
        $battlefield = unserialize($savedData);
    }
    
    return $app['twig']->render(
        'home.html.twig',
        [
            'battlefield' => $battlefield,
        ]
    );
});

$app->run();
