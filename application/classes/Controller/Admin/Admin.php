<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Admin extends Controller 
{

    public function action_login()
    {
        $page = new stdClass();
        $page->filepath = 'admin/skeleton.html';
        $page->fields = array();
        echo Renderer::convert_fields_and_generate_html($page);
    }
    
    public function action_pages()
    {        
        $page_model = new Model_Page();
        
        $limit = $this->get_query_or_default_value('limit', 1);
        $pages = $page_model->get_pages_with_limit($limit);      
        $page = self::init_page('admin/pages.html', 
                array('title' => 'Site Pages',
                    'pages' => $pages));

        echo Renderer::generate_html($page);
    }
    
    private static function init_page($filepath, array $fields)
    {
        $page = new stdClass();
        $page->filepath = $filepath;
        $page->fields = $fields;
        return $page;
    }
    
    private function get_query_or_default_value($param, $default)
    {
        $query_param = $this->request->query('limit');        
        if($query_param == NUll)
        {
            $query_param = $default;
        }
        
        return $query_param;
    }
   
}
