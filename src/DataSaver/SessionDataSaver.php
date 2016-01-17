<?php

namespace DataSaver;

/**
 * Description of Progress
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class SessionDataSaver implements DataSaverInterface
{
    public function save($data, $name)
    {
        $_SESSION[$name] = serialize($data);
    }
    
    public function load($name)
    {
        if (isset($_SESSION[$name])) {
            return unserialize($_SESSION[$name]);
        }
        
        return false;
    }
    
    public function delete($name)
    {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }
}
