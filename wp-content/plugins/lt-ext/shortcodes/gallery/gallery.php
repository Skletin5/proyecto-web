<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Gallery
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_gallery_params' ) ) {

	function ltx_vc_gallery_params() {

		$cat = ltxGetGalleryPosts();

		$fields = array(

			array(
				"param_name" => "layout",
				"heading" => esc_html__("Layout", 'lt-ext'),
				"std" => "masonry",
				"value" => array(
					esc_html__('Simple Grid', 'lt-ext') => 'grid',
					esc_html__('Masonry Grid', 'lt-ext') => 'masonry',
				),
				"type" => "dropdown"
			),				
			array(
				"param_name" => "cat",
				"heading" => esc_html__("Gallery", 'lt-ext'),
				"value" => $cat,
				"type" => "dropdown"
			),
/*			
			array(
				"param_name" => "limit",
				"heading" => esc_html__("Limit", 'lt-ext'),
				"description" => esc_html__("Number of galleries to show", 'lt-ext'),
				"std"	=>	"3",
				"admin_label" => true,
				"type" => "textfield"
			),								
*/			
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_gallery' ) ) {

	function like_sc_gallery($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_gallery', $atts, array_merge( array(

			'limit' 		=> '',
			'cat' 			=> '',
			'layout' 		=> 'masonry',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('gallery', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_gallery", "like_sc_gallery");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_gallery_add')) {

	function ltx_vc_gallery_add() {
		
		vc_map( array(
			"base" => "like_sc_gallery",
			"name" 	=> esc_html__("Gallery Photos", 'lt-ext'),
			"description" => esc_html__("Last photos from LTx Gallery", 'lt-ext'),
			"class" => "like_sc_gallery",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/gallery/gallery.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_gallery_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_gallery_add', 30);
}


