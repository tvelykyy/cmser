<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Page extends Model_Database
{
    public function get_page_by_uri($uri)
    {
        $query = DB::select('p.id', 't.filepath')
                ->from(array('page', 'p'))
                ->join(array('template', 't'), 'INNER')
                ->on('p.template_id', '=', 't.id')
                ->where('p.uri', '=', $uri);

        $page = $query->as_object()->execute($this->_db)->current();
            
        if ($page) 
        {
            $relation_query = DB::select('pf.title', 'ppf.page_field_content')
                    ->from(array('page_page_field', 'ppf'))
                    ->join(array('page_field', 'pf'), 'INNER')
                    ->on('ppf.page_field_id', '=', 'pf.id')
                    ->where('page_id', '=', $page->id);

            $page->fields = $relation_query->as_object()->execute($this->_db)->as_objects_array();
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
    
    public function get_pages_with_limit($limit)
    {
        $uris = DB::select('id', 'parent_id', 'uri', 'template_id')
                ->from('page')
                ->limit($limit)
                ->as_object()
                ->execute($this->_db)
                ->as_objects_array();

        return $uris;
    }
}