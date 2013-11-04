<?php defined('SYSPATH') or die('No direct access allowed!');

class Request_Test extends Unittest_TestCase
{

    function test_empty_uri()
    {
        /* Given. */
        $uri_to_set = '';
        $request = Request::factory('news');

        /* When. */

        /* Then. */

    }

}