<?php

namespace Application;

use EventDispatcher\EventDispatcher;
use Controller\FrontController;
use DataSaver\SessionDataSaver;

use Model\Battlefield\Visualizer\VisualizerFactory;

/**
 * Application
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Application
{
    /**
     * @var EventDispatcher
     */
    protected $eventDispacher;
    
    /**
     * @var FrontController
     */
    protected $frontController;
    
    public function __construct()
    {
        $this->registerErrorHandler();
        $this->eventDispacher = new EventDispatcher();
        $this->frontController = new FrontController();
    }
    
    public function run()
    {
        $visualizerFactory = new VisualizerFactory();
        $this->eventDispacher->addSubscriber(
            new \Event\Model\Battlefield\ShootSubscriber(
                $visualizerFactory
            )
        );
        
        $controller = $this->frontController->getController();
        $controller->setEventDispacher($this->eventDispacher);
        $controller->setVisualizerFactory($visualizerFactory);
        $controller->setDataSaver(new SessionDataSaver());
        
        $response = call_user_func_array(
            [
                $controller,
                $this->frontController->getMethod()
            ],
            []
        );
        
        if ($this->frontController->getViewEnabled()) {
            if ($this->frontController->getController()->getTemplate()) {
                $templateName = $this->frontController->getController()->getTemplate();
            } else {
                $templateName =  $this->getTemplateControllerName()
                        . DIRECTORY_SEPARATOR . $this->frontController->getAction();
            }
            $templatePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
                    . 'Resources' . DIRECTORY_SEPARATOR
                    .'views' . DIRECTORY_SEPARATOR . $templateName;
            $templatePath = $templatePath . '.php';
            $view = new \View\View($templatePath);
            $view->setParams($response);
            echo $view->render();
        } else {
            return $response;
        }
    }
    
    /**
     * Register custom error handler
     */
    protected function registerErrorHandler()
    {
        $handler = new \Error\ErrorHandler();
        $handler->register();
    }
    
    /**
     * Return controller name used to build template path.
     *
     * ontroller\Web\Index will return 'Web'
     * @return string
     */
    public function getTemplateControllerName()
    {
        $contollerClass = get_class($this->frontController->getController());
        
        $contollerClassBase = preg_replace('/^Controller\\\\/', '', $contollerClass);
        $controllerClassnameExploded = explode('\\', $contollerClassBase);
        $controllerClassNameBase = $controllerClassnameExploded[0];
        return $controllerClassNameBase;
    }
}
