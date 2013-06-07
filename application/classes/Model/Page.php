<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Page extends Model_Database
{
    public function get_page_by_url($url)
    {
        $query = DB::query(Database::SELECT, 'SELECT p.id, t.filepath 
            FROM page p 
            INNER JOIN template t ON p.template_id = t.id
            WHERE p.url = :url');
        
        $query->param(':url', $url);

        $pages =  $query->execute();
        $page = $pages[0];
        
        $relation_query = DB::query(Database::SELECT, 'SELECT pf.id, pf.title, 
            ppf.page_field_content 
            FROM page_page_field ppf 
            INNER JOIN page_field pf  ON ppf.page_id = pf.id
            WHERE page_id = :id');
        $relation_query->param(':id', $page['id']);
        
        $page['fields'] = $relation_query->execute()->as_array();
        
        print_r($page);
    }
}