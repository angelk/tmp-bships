<?php

namespace Controller;

use Controller\AbstractController;

/**
 * FrontController
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class FrontController
{
    
    protected $viewEnabled = true;
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
    
    /**
     * View auto rendering option
     * @return bool
     */
    public function getViewEnabled()
    {
        return $this->viewEnabled;
    }

    /**
     * Get controller action
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * Set controller action
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
    
    /**
     * get name of the method witch will
     * be called in controller
     * @return string
     */
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
    
    /**
     * @param AbstractController $controller
     */
    public function setController(AbstractController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Initialize  command line controller
     */
    protected function initCli()
    {
        $this->viewEnabled = false;
        $this->setController(new Cli\IndexController());
        $this->setAction('home');
    }
    
    /**
     * Initialize web controller
     */
    protected function initWeb()
    {
        $this->setController(new Web\IndexController());
        $this->setAction('home');
    }
}
