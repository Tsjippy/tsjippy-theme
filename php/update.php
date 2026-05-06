<?php
namespace TSJIPPYTHEME;
use TSJIPPY;

use Github\Exception\ApiLimitExceedException;

// https://github.com/KnpLabs/php-github-api 	-- github api
// https://github.com/michelf/php-markdown		-- convert markdown to html


/**
 * Adds a custom description to the plugin in the plugin page
 */
add_filter( 'themes_api', function ( $res, $action, $args ) {
	// do nothing if you're not getting plugin information or this is not our plugin
	if( 'plugin_information' !== $action || 'tsjippy-theme' !== $args->slug) {
		return $res;
	}

	$github					= new TSJIPPY\GITHUB\Github();
	return $github->pluginData(THEME_PATH, 'Tsjippy', 'tsjippy-theme', [
		'active_installs'	=> 2, 
		'donate_link'		=> 'harmseninnigeria.nl', 
		'rating'			=> 5, 
		'ratings'			=> [4,5,5,5,5,5], 
		'banners'			=> [
			'high'	=> TSJIPPY\PICTURESURL."/banner-1544x500.jpg",
			'low'	=> TSJIPPY\PICTURESURL."/banner-772x250.jpg"
		], 
		'tested'			=> '6.6.2'		
	]);

}, 10, 3);

add_filter( 'pre_set_site_transient_update_themes', function($transient){
	if(!class_exists('TSJIPPY\GITHUB\Github')){
		return $transient;
	}
	$github			= new TSJIPPY\GITHUB\Github();

	$item			= $github->getVersionInfo(THEME_PATH, 'Tsjippy', 'tsjippy-theme');

	// Git has a newer version
	if(isset($item->new_version)){
		$transient->response['tsjippy-theme']	= (array)$item;
	}else{
		$transient->no_update['tsjippy-theme']	= (array)$item;
	}

	return $transient;
});

add_action('admin_menu', function(){
	add_submenu_page('themes.php', 'Update', 'Update', 'edit_theme_options', 'update', function($test){
		$github		= new TSJIPPY\GITHUB\Github();
		$release	= $github->getLatestRelease('tsjippy', 'tsjippy-theme', true);
		$theme		= wp_get_theme('tsjippy-theme');

		if(version_compare($release['tag_name'], $theme->version)){
			$url  		= wp_nonce_url( admin_url( 'update.php?action=upgrade-theme&amp;theme=' . urlencode( 'tsjippy-theme' ) ), 'upgrade-theme_tsjippy-theme' );

			$link   = "<a href='$url' class='update-link'>Update to {$release['tag_name']}</a>";
			echo "Checking for update<br>Current version $theme->version<br>Remote version {$release['tag_name']}<br>$link";
		}else{
			echo "Checking for update<br>No update available";
		}
	});
});

add_action('upgrader_process_complete', __NAMESPACE__.'\themeUpdated', 10, 2);
function themeUpdated($upgraderObject, $options) {
    // Check if it's a theme update
    if (
		$options['action'] == 'update' && 
		$options['type'] == 'theme' &&
		in_array(THEME, $options['themes'])
	) {
		$oldVersion = $upgraderObject->skin->theme_info['Version'];

		TSJIPPY\printArray($oldVersion);

        wp_schedule_single_event(time() + 10, 'tsjippy_theme_update_action', [ $oldVersion ]);
    }
}

// Runs 10 seconds after a succesfull update of a tsjippy- plugin to be able to use the new files
add_action( 'tsjippy_theme_update_action', function($oldVersion){
	global $wpdb;

    if(version_compare('3.0.1', $oldVersion)){
		// Rename option
		$old	= get_option('theme_mods_SIM-Theme', '');

		if(!empty($old)){
			update_option('theme_mods_tsjippy-theme', $old);
		}
	}

	if(version_compare('3.0.4', $oldVersion)){
		$blocks	= get_option('widget_block');

		foreach($blocks as &$block){
			if(is_array($block)){
				foreach($block as &$content){
					$content	= str_replace('<!-- wp:sim/', '<!-- wp:tsjippy/', $content);
				}
			}
		}
		update_option('widget_block', $blocks);

		$posts = $wpdb->get_results( "SELECT * FROM {$wpdb->posts} WHERE post_content LIKE '%<!-- wp:sim/%'" );
		foreach($posts as $post){
			wp_update_post( [
				'ID' 			=> $post->ID,
				'post_content' 	=> str_replace( '<!-- wp:sim/', '<!-- wp:tsjippy/', $post->post_content ),
			], true );
		}
	}
} );