<?php

namespace Controller;

/**
 * Description of FrontController
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class FrontController
{
    
    protected $controller;
    protected $action;
    protected $params = [];
    
    public function getAction()
    {
        return $this->action;
    }
    
    public function setAction($action)
    {
        $this->action = $action;
    }
    
    public function getMethod()
    {
        $methodname = ucfirst($this->getAction()) . 'Action';
        return $methodname;
    }
    
    public function getTemplateControllerName()
    {
        $contollerClass = get_class($this->controller);
        
        $contollerClassBase = preg_replace('/^Controller\\\\/', '', $contollerClass);
        $controllerClassnameExploded = explode('\\', $contollerClassBase);
        $controllerClassNameBase = $controllerClassnameExploded[0];
        return $controllerClassNameBase;
    }

            

    public function getController()
    {
        return $this->controller;
    }
    
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function run()
    {
        $this->init();
        
        $response = call_user_func_array(
            [
                $this->controller,
                $this->getMethod(),
            ],
            $this->params
        );
        
        $templatePath = __DIR__ . '/../Resources/views/' . $this->getTemplateControllerName() . '/' . $this->action . '.php';
        $view = new \View\View($templatePath);
        $view->setParams($response);
        
        echo $view->render();
        
    }
    
    protected function init()
    {
        // cgi could also be called from cli
        // some additional check will be useful
        $isCli = php_sapi_name() == 'cli';
        if ($isCli) {
            $this->initCli();
        } else {
            $this->initWeb();
        }
        
        
    }
    
    protected function initCli()
    {
        throw new \Exception('not implemented');
    }
    
    protected function initWeb()
    {
        $this->setController(new Web\IndexController());
        $this->setAction('home');
    }
}
