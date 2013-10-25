<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller 
{

    public function action_index()
    {
        $uri = $this->request->uri();
        $page = Model_Page::get_page_by_uri($uri);

        if ($page)
        {
            Resolver_Snippet::resolve($page->fields);
            $page->fields = self::convert_field_array($page->fields);

            echo Generator_Html::generate_html_by_filepath_and_params($page->filepath, $page->fields);
        }
        else 
        {
            throw new Kohana_HTTP_Exception_404();
        }
    }

    /**
     * Converts example array
     * Array ( [0] => stdClass Object ( [title] => MAIN_CONTENT [page_field_content] => some text. ) )
     * to
     * Array ( [MAIN_CONTENT] = > some text.
     */
    /* TODO move this out. */
    private static function convert_field_array($fields_array)
    {
        if (is_array($fields_array))
        {
            $result_array = array();

            foreach ($fields_array as $field)
            {
                if (isset($field->title))
                {
                    $result_array[$field->title] = $field->page_field_content;
                }
            }
            return $result_array;
        }
        return NULL;
    }
   
} // End Welcome
