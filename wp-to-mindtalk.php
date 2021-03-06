<?php
/*
Plugin Name: Simple Wordpress to Mindtalk Poster
Plugin URI: https://www.github.com/at-/php/wp-to-mindtalk.php
Description: See plugin name
Version: 0.2
Author: at-
Author URI: https://www.github.com/at-
License: WTFPL (What The Fuck Public License) v6.9
*/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // required in order to access is_plugin_active()
function mtcall() {
	$url = 'http://api.mindtalk.com/v1/post/write_mind';
	// Register your apps here 
	// http://developer.mindtalk.com/api/wiki/RegisterApplication
	$token = '[YOUR TOKEN]';
	// Support uid, channel id, etc (read mindtalk docs)
	$id = '[UID/CID]'; 
	$c = curl_init ($url);
	// Support multi channel posting, separate by comma (,)
	$arrChannel = array('SysAdmin', 'HadetaMovie');
	reset($arrChannel);
	foreach ($arrChannel as $vChannel) {
	$body = 'access_token=' . $token . '&message='.get_the_title() .' '.get_permalink().' #' . $vChannel . '&origin_id=' . $id . '&rf=json';
		curl_setopt ($c, CURLOPT_POST, $url);
		curl_setopt ($c, CURLOPT_POST, true);
		curl_setopt ($c, CURLOPT_POSTFIELDS, $body);
		curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
		$page = curl_exec ($c);
	}
	curl_close ($c);
}
add_action( 'draft_to_publish', 'mtcall' );
?>
