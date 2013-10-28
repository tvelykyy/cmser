<?php defined('SYSPATH') or die('No direct access allowed!');

class Helper_Array_Test extends Unittest_TestCase
{

    function test_correct_conversion()
    {
        /* Given */
        $array_to_convert = array();

        $array_object_1 = new stdClass;
        $array_object_1->title = 'DummyTitle1';
        $array_object_1->page_field_content = 'DummyPageContent1';

        $array_object_2 = new stdClass;
        $array_object_2->title = 'DummyTitle2';
        $array_object_2->page_field_content = 'DummyPageContent2';

        array_push($array_to_convert, $array_object_1);
        array_push($array_to_convert, $array_object_2);

        /* When */
        $actual_array = Helper_Array::convert_array_to_associative_array_for_page($array_to_convert);

        /* Then */
        $this->assertNotEmpty($actual_array);
        $this->assertCount(2, $actual_array);

        $this->assertArrayHasKey('DummyTitle1', $actual_array);
        $this->assertEquals('DummyPageContent1', $actual_array['DummyTitle1']);

        $this->assertArrayHasKey('DummyTitle2', $actual_array);
        $this->assertEquals('DummyPageContent2', $actual_array['DummyTitle2']);
    }

    function test_returning_null_if_not_array()
    {
        /* Given */
        $obj_to_pass = new stdClass;

        /* When */
        $actual_result = Helper_Array::convert_array_to_associative_array_for_page($obj_to_pass);

        /* Then */
        $this->assertNull($actual_result);
    }

    function test_returning_empty_array_if_array_with_title_property_passed()
    {
        /* Given */
        $array_to_pass = array();
        $array_object_1 = new stdClass();
        $array_object_1->other_title = 'DummyOtherTitle1';
        $array_object_1->page_field_content = 'DummyPageContent1';

        array_push($array_to_pass, $array_object_1);

        /* When */
        $actual_array = Helper_Array::convert_array_to_associative_array_for_page($array_to_pass);

        /* Then */
        $this->assertNotNull($actual_array);
        $this->assertEmpty($actual_array);
    }

    function test_returning_empty_array_if_empty_array_passed()
    {
        /* Given */
        $array_to_pass = array();

        /* When */
        $actual_array = Helper_Array::convert_array_to_associative_array_for_page($array_to_pass);

        /* Then */
        $this->assertNotNull($actual_array);
        $this->assertEmpty($actual_array);
    }
}