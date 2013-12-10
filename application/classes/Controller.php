<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Controller extends Kohana_Controller
{
    public function prepare_json_response($response_data)
    {
        $this->response->headers('Content-Type','application/json');
        return json_encode($response_data);
    }
}
