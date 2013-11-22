<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Block extends Model_Database
{
    public function get_by_id($id)
    {
        $query = DB::select('b.id', 'b.title')
                ->from(array('block', 'b'))
                ->where('b.id', '=', $id)
                ->as_object();

        $block = $query->execute($this->_db)->current();
        
        return $block;
    }

    public function get_all_blocks()
    {
        $query = DB::select('b.id', 'b.title')
            ->from(array('block', 'b'))
            ->as_object();

        $blocks = $query->execute($this->_db);

        return $blocks;
    }

    public function delete_by_id($id)
    {

    }

    public function create($title)
    {

    }

    public function edit($id, $title)
    {

    }

}