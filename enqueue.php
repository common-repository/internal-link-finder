<?php function wilo_enqueue_assets(){
    if(current_user_can('administrator') && in_array(get_post_type(), wilo_get_post_types()) && is_singular()):
        wp_enqueue_style('wilo_css', WILO_DIRECTORY . '/assets/css/frontend.css', array(), WILO_VERSION);
        wp_enqueue_script('jquery');
        wp_enqueue_script('wilo_js', WILO_DIRECTORY . '/assets/js/frontend.js', array('jquery'), WILO_VERSION, true);
        wp_enqueue_script('wilo_tooltip_js', WILO_DIRECTORY . '/assets/js/tooltip.js', array('jquery'), WILO_VERSION);
        wp_enqueue_style('wilo_tooltip_css', WILO_DIRECTORY . '/assets/css/tooltip.css', array(), WILO_VERSION);
        wp_enqueue_script('wilo_explorer', WILO_DIRECTORY . '/assets/js/explorer.js', array('jquery'), WILO_VERSION, true);

        if(isset($_GET['wilo_anchors'])):
            wp_enqueue_script( 'wilo_mark', 'https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.js', array('jquery'), WILO_VERSION);
            wp_enqueue_script('wilo_marker', WILO_DIRECTORY . '/assets/js/marker.js', array('jquery'), WILO_VERSION);
        endif;

    endif;
}
add_action('wp_enqueue_scripts', 'wilo_enqueue_assets');