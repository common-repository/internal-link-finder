<?php
   /*
   Plugin Name: Wilo - WordPress Internal Link Optimizer
   Plugin URI:
   description: Unleash the power of effective internal linking with wilo.
   Version: 5.0.9
   Author: Toast Plugins
   Author URI: https://www.toastplugins.co.uk/
   */

if(! defined('ABSPATH')) exit;

if( ! class_exists('WILO') ) :

   class WILO {

      public $version = '5.0.9';

      function __construct() {
         // Do nothing.
      }

      function initialize(){

         define('WILO', true);
         define('WILO_PATH', plugin_dir_path( __FILE__ ));
         define('WILO_BASENAME', plugin_basename( __FILE__ ));
         define('WILO_DIRECTORY', plugin_dir_url( __FILE__ ));
         define('WILO_VERSION', $this->version);

         //Functions
         include WILO_PATH . 'functions/wilo_ajax_endpoint.php';
         include WILO_PATH . 'functions/wilo_calculate_impact.php';
         include WILO_PATH . 'functions/wilo_compare_impact.php';
         include WILO_PATH . 'functions/wilo_crawl_page.php';
         include WILO_PATH . 'functions/wilo_get_outgoing_links_to_current_page.php';
         include WILO_PATH . 'functions/wilo_get_content.php';
         include WILO_PATH . 'functions/wilo_get_incoming_pages.php';
         include WILO_PATH . 'functions/wilo_get_outgoing_links_count.php';
         include WILO_PATH . 'functions/wilo_get_internal_linking_score.php';
         include WILO_PATH . 'functions/wilo_get_possible_hrefs.php';
         include WILO_PATH . 'functions/wilo_get_post_types.php';
         include WILO_PATH . 'functions/wilo_sanitize_link.php';

         include WILO_PATH . 'functions/wilo_get_opportunities.php';
         include WILO_PATH . 'functions/wilo_get_keyword_matches.php';
         include WILO_PATH . 'functions/wilo_remove_keywords.php';

         //Enqueues
         include WILO_PATH . 'enqueue.php';

         //Frontend
         include WILO_PATH . 'templates/dashboard.php';

         function wilo_add_settings_link( $links ) {
            $settings_link = '<a href="/?wilo=true" target="_blank">Use WILO</a>';
            array_unshift( $links, $settings_link );
            return $links;
        }
        
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'wilo_add_settings_link' );

      }

   }

   $wilo = new WILO();
   $wilo->initialize();

endif; // class_exists check