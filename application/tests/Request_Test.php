<?php defined('SYSPATH') or die('No direct access allowed!');

class Request_Test extends Unittest_TestCase
{

    function test_empty_uri()
    {
        /* Given. */
        $uri_to_set = '';
        $request = Request::factory($uri_to_set);

        /* When. */
        $actual_uri = $request->uri();

        /* Then. */
        $this->assertEquals('/', $actual_uri);
    }

    function test_not_empty_uri()
    {
        /* Given. */
        $uri_to_set = '/news';
        $request = Request::factory($uri_to_set);

        /* When. */
        $actual_uri = $request->uri();

        /* Then. */
        $this->assertEquals($uri_to_set, $actual_uri);
    }

    function test_uri_as_setter()
    {
        /* Given. */
        $uri_to_set = 'news';
        $request = Request::factory();

        /* When. */
        $actual_request = $request->uri($uri_to_set);

        /* Then. */
        $this->assertEquals(get_class($request), get_class($actual_request));
    }

}