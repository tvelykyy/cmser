<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Admin extends Controller 
{

    public function action_login()
    {
        $page = new stdClass();
        $page->filepath = 'admin/skeleton.html';
        $page->fields = array();
        echo Renderer::generate_html($page);
    }    
   
} // End Welcome
