<?php 
/**
 * Extract existing anchor links along with their context from given content.
 *
 * This function searches for specified page references within the content and
 * extracts anchor links associated with them. For each anchor link found, it
 * captures the anchor text and a contextual snippet around the link for
 * better context understanding.
 *
 * @param array  $possible_page_href An array of possible page references (URLs).
 * @param string $content The content to search for anchor links.
 *
 * @return array An array of associative arrays containing anchor text and context.
 */
function wilo_get_outgoing_links_to_current_page($possible_page_href, $content) {
    $links = array();
	$content = preg_replace('/\s+/', ' ', $content);
    $link_positions = array();

    foreach ($possible_page_href as $url) {
        $link_positions = array();
        $search_position = 0;
		$link_count = 0;

        while (($search_position = strpos($content, $url, $search_position)) !== false) {
            $link_positions[] = $search_position;
            $search_position += strlen($url);
        }
    }

    foreach ($link_positions as $link_position) {
        $link_start = strpos($content, '>', $link_position) + 1;
        $link_end = strpos($content, '</a>', $link_start);
        
        if ($link_start !== false && $link_end !== false) {
            $link_context = substr($content, $link_start - 200,  $link_end + 200);
            $link_length = $link_end - $link_start;
            $anchor = strip_tags(substr($content, $link_start, $link_length));
            $links[$link_count]['anchor'] = $anchor;
            $links[$link_count]['context'] = strip_tags($link_context);
        }
        $link_count++;
    }

    return $links;
}