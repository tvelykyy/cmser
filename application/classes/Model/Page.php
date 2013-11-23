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

        $page = $this->execute_for_object($query);
            
        if ($page) 
        {
            $relation_query = DB::select('b.title', 'pb.block_content')
                    ->from(array('page_block', 'pb'))
                    ->join(array('block', 'b'), 'INNER')
                    ->on('pb.block_id', '=', 'b.id')
                    ->where('page_id', '=', $page->id);

            $page->blocks = $this->execute_for_objects_array($relation_query);
        }
        
        return $page;
    }
    
    public function get_all_pages_uri($above, $less)
    {
        $query = DB::select('uri')
                ->from('page')
                ->where('id', '<', $less)
                ->and_where('id', '>', $above);

        $uris = $this->execute_for_objects_array($query);
        return $uris;
    }
    
    public function get_pages($offset = 0, $limit = 1)
    {
        $query = DB::select('id', 'parent_id', 'uri', 'template_id')
                ->from('page')
                ->offset($offset)
                ->limit($limit);

        $uris = $this->execute_for_objects_array($query);
        return $uris;
    }
}