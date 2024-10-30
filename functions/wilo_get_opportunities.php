<?php function wilo_get_opportunities(){
    
    $post_id = $_GET['post_id'];
    $keywords = $_GET['keywords'];
    $keywords = explode("\n", $keywords);
    update_post_meta($post_id, 'wilo_keywords', $keywords);

    $excluded = array($post_id);
    $incoming_pages = wilo_get_incoming_pages($post_id);
    foreach($incoming_pages as $incoming_page):
        $excluded[] = $incoming_page['post_id'];
    endforeach;
	
	$args = array(
        'post_type' => 'any', 
        'posts_per_page' => -1, 
        'post_status' => 'publish',
        'suppress_filters' => true,
        'post__not_in' => $excluded
	);
 
 	$query = new WP_Query($args);
	$potential_links = array();
    $post_ids_containing_keywords = array(0);

	while($query->have_posts()): $query->the_post();
		
		$content = wilo_get_content();
        foreach($keywords as $keyword){

            if(strpos($content, $keyword) !== false && $keyword !== '' && $keyword !== ' '):
                $opportunities[] = array(
                    'post_title' => get_the_title(),
                    'post_id' => get_the_id(),
                    'post_url' => wilo_sanitize_link(get_the_permalink()),
                    'keyword' => $keyword,
                    'impact' => wilo_calculate_impact(wilo_get_outgoing_links_count(get_the_id()))
                );
            endif;

        }

	endwhile;
    wp_reset_postdata();

    if(isset($opportunities) && is_array($opportunities) && count($opportunities) > 0):
		usort($opportunities, 'wilo_compare_impact');
	endif;

    echo wp_json_encode($opportunities);

die(); }
add_action('wp_ajax_wilo_get_opportunities', 'wilo_get_opportunities');
add_action('wp_ajax_nopriv_wilo_get_opportunities', 'wilo_get_opportunities');

?>