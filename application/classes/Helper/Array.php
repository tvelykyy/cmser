<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Array
{
    /**
     * Converts example array
     * Array ( [0] => stdClass Object ( [title] => MAIN_CONTENT [page_field_content] => some text. ) )
     * to
     * Array ( [MAIN_CONTENT] = > some text.
     */
    public static function convert_array_to_associative_array_for_page($fields_array)
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
} // End Helper_Array