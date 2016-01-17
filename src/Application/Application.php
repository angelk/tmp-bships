<?php

namespace Application;

/**
 * Description of Application
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Application
{
    protected $eventDispacher;
    protected $frontController;
    
    public function __construct()
    {
        $this->eventDispacher = new \EventDispatcher\EventDispatcher();
        $this->frontController = new \Controller\FrontController();
    }
    
    public function run()
    {
        $visualizerFactory = new \Model\Battlefield\Visualizer\VisualizerFactory();
        $this->eventDispacher->addSubscriber(
            new \Event\Model\Battlefield\ShootSubscriber(
                $visualizerFactory
            )
        );
        
        $controller = $this->frontController->getController();
        $controller->setEventDispacher($this->eventDispacher);
        $controller->setVisualizerFactory($visualizerFactory);
        $controller->setDataSaver(new \DataSaver\SessionDataSaver());
        
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
                $templateName =  $this->getTemplateControllerName() . DIRECTORY_SEPARATOR . $this->frontController->getAction();
            }
            $templatePath = __DIR__ . '/../Resources/views/' . $templateName;
            $templatePath = $templatePath . '.php';
            $view = new \View\View($templatePath);
            $view->setParams($response);
            echo $view->render();
        } else {
            return $response;
        }
    }
    
    public function getTemplateControllerName()
    {
        $contollerClass = get_class($this->frontController->getController());
        
        $contollerClassBase = preg_replace('/^Controller\\\\/', '', $contollerClass);
        $controllerClassnameExploded = explode('\\', $contollerClassBase);
        $controllerClassNameBase = $controllerClassnameExploded[0];
        return $controllerClassNameBase;
    }
}
