<?php

namespace View;

/**
 * Description of View
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class View
{
    private $params = [];
    
    private $templatePath;


    public function __construct($templatePath)
    {
        $this->templatePath = $templatePath;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }
    
    public function __get($name)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
        
        return null;
    }
    
    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }
    
    public function render()
    {
        require $this->templatePath;
    }
}
