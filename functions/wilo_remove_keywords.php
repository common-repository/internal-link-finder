<?php function wilo_remove_keywords(){

    $post_id = $_GET['post_id'];
    update_post_meta($post_id, 'wilo_keywords', array());
}
add_action('wp_ajax_wilo_remove_keywords', 'wilo_remove_keywords');
add_action('wp_ajax_nopriv_wilo_remove_keywords', 'wilo_remove_keywords');