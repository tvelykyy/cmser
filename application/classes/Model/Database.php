<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Model_Database extends Kohana_Model_Database
{
    public function execute_for_object($query)
    {
        return $query->execute_for_object($this->_db);
    }

    public function execute_for_objects_array($query)
    {
        return $query->execute_for_objects_array($this->_db);
    }

    public function execute($query)
    {
        return $query->execute($this->_db);
    }
}
