<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'MySQL',
		'connection' => array(
			'hostname'   => 'localhost',
			'database'   => 'cmser',
			'username'   => 'root',
			'password'   => 'root',
			'persistent' => FALSE
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),

    'test' => array
    (
        'type'       => 'MySQL',
        'connection' => array(
            'hostname'   => 'localhost',
            'database'   => 'cmser_test',
            'username'   => 'root',
            'password'   => 'root',
            'persistent' => FALSE
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
    )
);
