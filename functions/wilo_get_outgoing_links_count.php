<?php
/**
 * Get outgoing internal and external links from a post ID.
 * This function extracts and categorizes outgoing links (internal / external).
 *
 * @param int $post_id The ID of the post to analyze.
 *
 * @return array An array containing two sub-arrays: 'internal' and 'external', each containing respective links.
 */
function wilo_get_outgoing_links_count($post_id, $content = null) {
	$outgoing_links = 0;

	if(!$content):
		$content = wilo_get_content($post_id);
	endif;

	$search_position = 0;

	while (($search_position = strpos($content, '<a ', $search_position)) !== false) {
		$tag_end = strpos($content, '>', $search_position);
		$search_position = $tag_end;
		$outgoing_links++;
	}

	return $outgoing_links;
} ?>