<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Page extends Model_Database
{
    public function get_page_by_uri($uri)
    {
        $query = DB::select('p.id', 't.path')
                ->from(array('page', 'p'))
                ->join(array('template', 't'), 'INNER')
                ->on('p.template_id', '=', 't.id')
                ->where('p.uri', '=', $uri)
                ->as_object();

        $page = $query->execute($this->_db)->current();
            
        if ($page) 
        {
            $relation_query = DB::select('b.title', 'pb.block_content')
                    ->from(array('page_block', 'pb'))
                    ->join(array('block', 'b'), 'INNER')
                    ->on('pb.block_id', '=', 'b.id')
                    ->where('page_id', '=', $page->id)
                    ->as_object();

            $page->blocks = $relation_query->execute($this->_db)->as_objects_array();
        }
        
        return $page;
    }
    
    public function get_all_pages_uri($above, $less)
    {
        $uris = DB::select('uri')
                ->from('page')
                ->where('id', '<', $less)
                ->and_where('id', '>', $above)
                ->as_object()
                ->execute($this->_db)
                ->as_objects_array();

        return $uris;
    }
    
    public function get_pages($offset = 0, $limit = 1)
    {
        $uris = DB::select('id', 'parent_id', 'uri', 'template_id')
                ->from('page')
                ->offset($offset)
                ->limit($limit)
                ->as_object()
                ->execute($this->_db)
                ->as_objects_array();

        return $uris;
    }
}