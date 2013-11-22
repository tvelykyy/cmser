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
                ->where('p.uri', '=', $uri);

        $page = $query->execute_for_object($this->_db);
            
        if ($page) 
        {
            $relation_query = DB::select('b.title', 'pb.block_content')
                    ->from(array('page_block', 'pb'))
                    ->join(array('block', 'b'), 'INNER')
                    ->on('pb.block_id', '=', 'b.id')
                    ->where('page_id', '=', $page->id);

            $page->blocks = $relation_query->execute_for_objects_array($this->_db);
        }
        
        return $page;
    }
    
    public function get_all_pages_uri($above, $less)
    {
        $uris = DB::select('uri')
                ->from('page')
                ->where('id', '<', $less)
                ->and_where('id', '>', $above)
                ->execute_for_objects_array($this->db);

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