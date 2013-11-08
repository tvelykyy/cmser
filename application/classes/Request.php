<?php defined('SYSPATH') or die('No direct script access.');

class Request extends Kohana_Request
{
    public function uri($uri = NULL)
    {
        if ($uri === NULL) {
            // Act as a getter
            return '/' . $this->_uri;
        }

        // Act as a setter
        $this->_uri = $uri;

        return $this;
    }
} // End Request