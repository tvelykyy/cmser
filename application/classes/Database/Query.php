<?php defined('SYSPATH') OR die('No direct script access.');

class Database_Query extends Kohana_Database_Query {

    public function execute_for_object($db)
    {
        return $this->as_object()->execute($db)->current();
    }

    public function execute_for_objects_array($db)
    {
        return $this->as_object()->execute($db)->as_objects_array();
    }
}
