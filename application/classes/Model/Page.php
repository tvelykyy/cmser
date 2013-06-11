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
                ->where('p.uri', '=', ':uri');
        $query->param(':uri', $uri);

        $page = $query->as_object()->execute()->current();

        $relation_query = DB::select('pf.title', 'ppf.page_field_content')
                ->from(array('page_page_field', 'ppf'))
                ->join(array('page_field', 'pf'), 'INNER')
                ->on('ppf.page_field_id', '=', 'pf.id')
                ->where('page_id', '=', ':id');
        $relation_query->param(':id', $page->id);
        
        $page->fields = $relation_query->as_object()->execute()->as_objects_array();
        print_r($page);
        
        return $page;
    }
    
    public function get_all_pages_uri() 
    {
        $uris = DB::select('uri')
                ->from('page')
                ->as_object()
                ->execute()
                ->as_objects_array();

        return $uris;
    }
}