<?php

namespace DataSaver;

/**
 *
 * @author po_taka
 */
interface DataSaverInterface
{
    /**
     * Add item under key
     * @param mixed $data
     * @param string $name
     */
    public function save($data, $name);
    /**
     * Retrieve data
     * @param string $name
     */
    public function load($name);
    /**
     * Delete saved data
     * @param string $name
     */
    public function delete($name);
}
