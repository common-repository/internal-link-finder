<?php 

/**
 * Cleans a given link by removing the site URL and any trailing slashes.
 *
 * This function takes a link as input and performs the following operations:
 * 1. Removes the protocol (http:// or https://) and site URL from the link.
 * 2. Removes any trailing slashes from the link.
 *
 * @param string $link The link to be cleaned.
 * @return string The cleaned link without the site URL and trailing slashes.
 */
function wilo_sanitize_link($link){
	$site_url = str_replace('http://', '', get_site_url());
	$site_url = str_replace('https://', '', $site_url);

	$clean_link = str_replace($site_url, '', $link);
	$clean_link = str_replace(array('http://', 'https://'), '', $clean_link);
	$clean_link = rtrim($clean_link, '/');

	if($clean_link == ''):
		$clean_link = '/';
	endif;

	return $clean_link;
} ?>