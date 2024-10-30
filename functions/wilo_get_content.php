<?php
/**
 * Retrieve and format all content including post content and ACF fields.
 * 
 * @param bool $strip_html Whether to strip HTML from the content.
 *
 * @return string Formatted content including post content and ACF fields.
 */
function wilo_get_content($post_id = null) {

	if($post_id !== null):
		global $post;
		$post = get_post($post_id);
		setup_postdata($post);
		if (!$post) {
			return '';
		}
	endif;

    $content = get_the_content();
	$content = str_replace('[wpseo_breadcrumb]', '', $content);
    if(strpos( $content, '<!-- wp:' ) == false):
        $blocks = parse_blocks($content);
        $content = '';
        foreach($blocks as $block){
            $content .= render_block($block);
        }
    endif;

	// 	$content .= wilo_acf_content();
	$content = do_shortcode($content);
	$content = str_replace(get_site_url(), '', $content);
	$content = preg_replace("/href='(.*?)'/", 'href="$1"', $content);
	$content = preg_replace('/href="(.*?)\/"/', 'href="$1"', $content);
	$content = str_replace('href=""', 'href="/"', $content);

	if($content):
		$dom = new DOMDocument();
		@$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

		$xpath = new DOMXPath($dom);

		$breadcrumb_selectors = [
			'//*[contains(concat(" ", normalize-space(@class), " "), " breadcrumb ")]',
			'//*[@id="breadcrumbs"]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " breadcrumbs ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " breadcrumb-trail ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " seopress-breadcrumbs ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " seopress_breadcrumbs ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " rank-math-breadcrumb ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " rank-math-breadcrumbs ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " woocommerce-breadcrumb ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " aioseo-breadcrumbs ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " aioseo-breadcrumb ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " breadcrumb-navxt ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " simple-breadcrumbs ")]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " flexy-breadcrumbs ")]',
			'//*[@id="flexy_breadcrumbs"]',
			'//*[contains(concat(" ", normalize-space(@class), " "), " genesis-breadcrumbs ")]'
		];
	
		foreach ($breadcrumb_selectors as $selector) {
			$breadcrumbs = $xpath->query($selector);
			foreach ($breadcrumbs as $breadcrumb) {
				$breadcrumb->parentNode->removeChild($breadcrumb);
			}
		}
	
		$content = $dom->saveHTML();
	endif;
 
	 return strtolower($content);
}

/**
 * Retrieve ACF content and format it.
 *
 * @return string|null Formatted ACF content or null if ACF is not available.
 */
function wilo_acf_content() {
	if (class_exists('ACF') && is_array(get_field_objects())) {
		$acf_content = array();

		foreach (get_field_objects() as $acf_field) {
			$acf_content[] = stripslashes(json_encode($acf_field));
		}

		$content = implode(' ', $acf_content);
		$content = preg_replace('/"choices":{[\s\S]+?}/', '', $content);

		// Convert content to lowercase
		$content = strtolower($content);

		return $content;
	}

	return null;
}