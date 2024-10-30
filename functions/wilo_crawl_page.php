<?php /**
 * Build a data profile for a page.
 *
 * This function constructs a profile for a page, including its ID, URL, incoming internal links,
 * and outgoing links.
 *
 * @param int|null $post_id The ID of the post to build the profile for. Defaults to the current post.
 * @param bool     $debug   Whether to enable debugging output.
 */
function wilo_crawl_page($post_id){

	$incoming_pages = wilo_get_incoming_pages($post_id);

	$page_profile = array();
	$page_profile['post_id'] = $post_id;
	$page_profile['incoming_pages'] = $incoming_pages;
	
	$stuffed_links = 0;
	$incoming_internal_links = 0;
	$duplicate_anchors_count = 0;


	foreach($incoming_pages as $incoming_page):

		//Count stuffed links
		if(count($incoming_page['outgoing_links_to_current_page']) > 1):
			$stuffed_links = $stuffed_links + count($incoming_page['outgoing_links_to_current_page']) - 1;
		endif;

		//Count Links and duplicate anchors
		foreach($incoming_page['outgoing_links_to_current_page'] as $incoming_link):
			$incoming_internal_links++;

			if(isset($anchors_list[$incoming_link['anchor']])):
				$anchors_list[$incoming_link['anchor']] = $anchors_list[$incoming_link['anchor']] + 1;
			else:
				$anchors_list[$incoming_link['anchor']] = 1;
			endif;

		endforeach;

	endforeach;

	/**Calculate duplicate anchors */
	foreach($anchors_list as $anchor => $count):
		if($count > 1):
			$duplicate_anchors[] = $anchor;
			$duplicate_anchors_count = $duplicate_anchors_count + $count;
		endif;
	endforeach;

	$page_profile['duplicate_anchors_count'] = $duplicate_anchors_count;
	$page_profile['duplicate_anchors'] = $duplicate_anchors;
	$page_profile['stuffed_links'] = $stuffed_links;
	$page_profile['incoming_internal_links_count'] = $incoming_internal_links;
	$page_profile['internal_linking_score'] = wilo_get_internal_linking_score($page_profile);

	return $page_profile;

}