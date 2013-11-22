<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Template extends Model_Database
{
    public function get_template_by_id($id)
    {
        $query = DB::select('id', 'title', 'path')
                ->from('template')
                ->where('id', '=', $id)
                ->as_object();

        return $query->execute($this->_db)->current();
    }
}