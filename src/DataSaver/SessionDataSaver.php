<?php

namespace DataSaver;

/**
 * DataSaver implementation using $_SESSION
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class SessionDataSaver implements DataSaverInterface
{
    /**
     * @inheritdoc
     */
    public function save($data, $name)
    {
        $_SESSION[$name] = serialize($data);
    }
    
    /**
     * @inheritdoc
     */
    public function load($name)
    {
        if (isset($_SESSION[$name])) {
            return unserialize($_SESSION[$name]);
        }
        
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function delete($name)
    {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }
}
