<?php 

/**
 * Handles an AJAX request to fetch page data based on a given URL.
 *
 * This function retrieves the URL from the AJAX request's query parameters,
 * converts it to a post ID using WordPress's url_to_postid function, and then
 * builds a link profile using the wilo_build_link_profile function. The resulting
 * link profile is encoded as JSON and echoed in the response.
 */
function wilo_ajax_endpoint(){

	$url = $_GET['url'];
	$post_id = url_to_postid($url);

	if(isset($_GET['id'])):
		$post_id = $_GET['id'];
	endif;
	
	echo wp_json_encode(wilo_crawl_page($post_id));

	die();
}
add_action('wp_ajax_wilo_ajax_endpoint', 'wilo_ajax_endpoint');
add_action('wp_ajax_nopriv_wilo_ajax_endpoint', 'wilo_ajax_endpoint'); ?>