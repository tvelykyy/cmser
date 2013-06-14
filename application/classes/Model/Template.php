<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Template extends Model_Database
{
    public function get_template_by_id($id)
    {
        $query = DB::select('id', 'title', 'filepath')
                ->from('template')
                ->where('id', '=', $id);

        return $query->as_object()->execute()->current();
    }
}