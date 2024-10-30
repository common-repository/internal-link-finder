<?php 

/**
 * Get existing internal links from content that reference the given URL path.
 *
 * @param int $post_id Post ID.
 * 
 * @return array An array of existing internal links and there corresponding anchors and contexts.
 */
function wilo_get_incoming_pages($post_id) {


	$args = array(
		'post_type' => wilo_get_post_types(),
        'public' => true,
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'suppress_filters' => true,
		'post__not_in' => array($post_id)
	);


	$query = new WP_Query($args);

    $possible_page_hrefs = wilo_get_possible_hrefs($post_id);

	while($query->have_posts()): $query->the_post();

		$page_contains_href = false;
		$post_content = wilo_get_content();

		foreach ($possible_page_hrefs as $possible_page_href):
			$possible_page_href = strtolower($possible_page_href);

			if (strpos($post_content, $possible_page_href) !== false):
				$page_contains_href = true;
				break;
            endif;
        endforeach;

		$outgoing_links_count = wilo_get_outgoing_links_count(get_the_id(), $post_content);

		if ($page_contains_href):
				
			$impact = wilo_calculate_impact($outgoing_links_count);

			$incoming_pages[] = array(
				'post_id' => get_the_id(),
				'post_title' => get_the_title(),
				'edit_url' => get_edit_post_link(),
				'post_url' => wilo_sanitize_link(get_permalink()),
				'outgoing_links_count' => $outgoing_links_count,
				'outgoing_links_to_current_page' => wilo_get_outgoing_links_to_current_page($possible_page_hrefs, $post_content),
				'impact' => $impact,
			);

		endif;

	endwhile;

	if(isset($incoming_pages) && is_array($incoming_pages) && count($incoming_pages) > 0):
		usort($incoming_pages, 'wilo_compare_impact');
	endif;

	return $incoming_pages;
	wp_reset_postdata();
} ?>