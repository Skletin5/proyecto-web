<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_bubbles_params' ) ) {

	function ltx_vc_bubbles_params() {

		$fields = array(
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_bubbles' ) ) {

	function like_sc_bubbles($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_bubbles', $atts, array_merge( array(

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('bubbles', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_bubbles", "like_sc_bubbles");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_bubbles_add')) {

	function ltx_vc_bubbles_add() {
		
		vc_map( array(
			"base" => "like_sc_bubbles",
			"name" 	=> esc_html__("Bubbles", 'lt-ext'),
			"description" => esc_html__("Adds flowing bubbles element", 'lt-ext'),
			"class" => "like_sc_bubbles",
			//"icon"	=>	ltxGetPluginUrl('/shortcodes/bubbles/bubbles.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_bubbles_params(),
				ltx_vc_default_params()
			),
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_bubbles_add', 30);
}


