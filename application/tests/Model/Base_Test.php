<?php defined('SYSPATH') or die('No direct access allowed!');

abstract class Model_Base_Test extends Unittest_TestCase
{
    public static function setUpBeforeClass()
    {
//        Kohana::$config->load('database')->default = Kohana::$config->load('database')->test;
    }

    public function runSchema($schema)
    {
        $testDb = Kohana::$config->load('database.test');

        if(is_null($testDb)){
            return false;
        }

        $command = "-u{$testDb['connection']['username']} -p{$testDb['connection']['password']} {$testDb['connection']['database']}";
        $filePath = APPPATH . 'tests/data/' . $schema;

        exec("mysql $command < $filePath ");
    }
}