<?php

namespace TSJIPPY\FRONTPAGE;

use TSJIPPY;

add_action('rest_api_init', function () {
	// show displayname
	register_rest_route(
		RESTAPIPREFIX . '/frontpage',
		'/show_display_name',
		array(
			'methods' 				=> 'GET',
			'callback' 				=> __NAMESPACE__ . '\displayName',
			'permission_callback' 	=> function () {
				return current_user_can('read');
			},
		)
	);

	// show login count
	register_rest_route(
		RESTAPIPREFIX . '/frontpage',
		'/show_login_count',
		array(
			'methods' 				=> 'GET',
			'callback' 				=> __NAMESPACE__ . '\loginCount',
			'permission_callback' 	=> function () {
				return current_user_can('read');
			},
		)
	);

	// show welcome_message
	register_rest_route(
		RESTAPIPREFIX . '/frontpage',
		'/show_welcome_message',
		array(
			'methods' 				=> 'GET',
			'callback' 				=> __NAMESPACE__ . '\welcomeMessage',
			'permission_callback' 	=> function () {
				return current_user_can('read');
			},
		)
	);
});
