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

        $page = $query->execute()->current();
        
//        $relation_query = DB::query(Database::SELECT, 'SELECT pf.title, 
//                ppf.page_field_content 
//            FROM page_page_field ppf 
//            INNER JOIN page_field pf ON ppf.page_field_id = pf.id
//            WHERE page_id = :id');
        $relation_query = DB::select('pf.title', 'ppf.page_field_content')
                ->from(array('page_page_field', 'ppf'))
                ->join(array('page_field', 'pf'), 'INNER')
                ->on('ppf.page_field_id', '=', 'pf.id')
                ->where('page_id', '=', ':id');
        $relation_query->param(':id', $page['id']);
        
        $page['fields'] = $relation_query->execute()->as_array('title', 'page_field_content');
        print_r($page);
        return $page;
    }
    
    public function get_all_pages_uri() 
    {
        $uris = DB::select('uri')
                ->from('page')
                ->execute()
                ->as_objects_array();
        
        return $uris;
    }
}