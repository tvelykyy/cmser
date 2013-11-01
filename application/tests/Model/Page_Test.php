<?php defined('SYSPATH') or die('No direct access allowed!');

class Model_Page_Test extends Model_Base_Test
{
    function testConnection()
    {
        $model = new Model_Page('test');
        $uris = $model->get_all_pages_uri(0, 5);

        $this->assertEquals(4, count($uris));
    }
}