<?php

/**
 * Generates an array of possible page reference URLs based on the given request.
 *
 * This function takes a request URL and generates multiple variations of page
 * reference URLs that might be relevant for different use cases.
 *
 * @param string $url_path The original request URL.
 * @return array An array containing possible page reference URLs.
 */
function wilo_get_possible_hrefs($post_id) {

    $url_path = get_permalink($post_id);
	$url_path = str_replace(get_site_url(), '', $url_path);

    $url_path_without_traling_slash = wilo_sanitize_link($url_path);

    if($url_path_without_traling_slash == ''):
        $possible_page_references = array(
            'href="/"',
        );
    else:
        $possible_page_references = array(
            'href="'.$url_path_without_traling_slash. '"',
        );
    endif;

    foreach($possible_page_references as $key => $possible_page_reference):
        if($possible_page_reference == 'href=""' || $possible_page_reference == "href=''"):
            unset($possible_page_references[$key]);
        endif;
    endforeach;

    return $possible_page_references;
} ?>