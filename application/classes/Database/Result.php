<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Database_Result extends Kohana_Database_Result {
	/**
	 * Return all of the rows in the result as an array.
	 * @return  array
	 */
	public function as_objects_array()
	{
            $results = array();
            foreach ($this as $row)
            {
                    $results[] = $this->current();
            }
            
            $this->rewind();

            return $results;
	}

} // End Database_Result
