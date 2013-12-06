<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Block extends Model_Database
{
    public function get_by_id($id)
    {
        $query = DB::select('b.id', 'b.title')
                ->from(array('block', 'b'))
                ->where('b.id', '=', $id);

        $block = $this->execute_for_object($query);
        
        return $block;
    }

    public function get_all_blocks()
    {
        $query = DB::select('b.id', 'b.title')
            ->from(array('block', 'b'));

        $blocks = $this->execute_for_objects_array($query);

        return $blocks;
    }

    public function delete_by_id($id)
    {

    }

    public function create($title)
    {
        $query = DB::insert('block', array('title'))
            ->values(array($title));

        $result = $this->execute($query);
        return $result[0];

    }

    public function edit($id, $title)
    {
        $query = DB::update('block')
            ->set(array('title' => $title))
            ->where('id', '=', $id);

        $this->execute($query);
    }

}