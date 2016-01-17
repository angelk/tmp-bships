<?php

namespace DataSaver;

/**
 *
 * @author po_taka
 */
interface DataSaverInterface
{
    public function save($data, $name);
    public function load($name);
}
