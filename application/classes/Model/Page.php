<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Page extends Model_Database
{
    public function get_page_by_url($url)
    {
        $query = DB::query(Database::SELECT, 'SELECT p.id, t.filepath 
            FROM page p 
            INNER JOIN template ON p.template_id = t.id
            WHERE p.url = :url');
        
        $query->param(':url', $url);

        $page =  $query->execute();
    }
}