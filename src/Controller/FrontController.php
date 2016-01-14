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


    public function __construct()
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
    
    /**
     *
     * @return AbstractController
     */
    public function getController()
    {
        return $this->controller;
    }
    
    public function setController(AbstractController $controller)
    {
        $this->controller = $controller;
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
