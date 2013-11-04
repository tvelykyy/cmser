<?php defined('SYSPATH') or die('No direct access allowed!');

abstract class Model_Base_Test extends Unittest_TestCase
{
    public static function setUpBeforeClass()
    {
//        Kohana::$config->load('database')->default = Kohana::$config->load('database')->test;
    }
}