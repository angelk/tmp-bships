<?php

/*
 * This is dev version.
 * Since I don't know if it is allowed to use Silex/twig
 * This will be for debug purposes only.
 * This will be deleted/rewrited.
 * 
 */

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
        $battlefield = unserialize($savedData);
    } else {
        $battlefield = new \Model\Battlefield\Battlefield(10, 10);
    }
    
    $visualizerFactory = new Model\Battlefield\Visualizer\VisualizerFactory();
    $visualizer = $visualizerFactory->create($battlefield);
    
    $placer = new Model\Battlefield\Placer(
        new \Model\Battleship\Destroyer(),
        new Model\Battlefield\Point\Point(1, 2),
        new Model\Battlefield\Point\Point(1, 6)
    );
    
    $battlefield->addBattleShip($placer);
    $battlefield->shoot(new Model\Battlefield\Point\Point(1, 1));
    $battlefield->shoot(new Model\Battlefield\Point\Point(0, 0));
    
    
    return $app['twig']->render(
        'home.html.twig',
        [
            'visualizer' => $visualizer,
        ]
    );
});

$app->run();
