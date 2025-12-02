<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_ripples_params' ) ) {

	function ltx_vc_ripples_params() {

		$fields = array(
			array(
				"param_name" => "image",
				"heading" => esc_html__("Background Image", 'lt-ext'),
				"type" => "attach_image"
			),			
			array(
				"param_name" => "fog",
				"heading" => esc_html__("Fog", 'lt-ext'),
				"std" => "visible",
				"value" => array(
					esc_html__('Visible', 'lt-ext') 	=> 'visible',
					esc_html__('Hidden', 'lt-ext') 	=> 'hidden',
				),
				"type" => "dropdown"
			),				
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_ripples' ) ) {

	function like_sc_ripples($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_ripples', $atts, array_merge( array(

				'image' 			=> '',
				'fog' 		=> '',
			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('ripples', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_ripples", "like_sc_ripples");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_ripples_add')) {

	function ltx_vc_ripples_add() {
		
		vc_map( array(
			"base" => "like_sc_ripples",
			"name" 	=> esc_html__("Water Ripples", 'lt-ext'),
			"description" => esc_html__("Adds flowing ripples element", 'lt-ext'),
			"class" => "like_sc_ripples",
			//"icon"	=>	ltxGetPluginUrl('/shortcodes/ripples/ripples.png'),
			"show_settings_on_create" => true,
			"is_container" => true,
			"js_view" => 'VcColumnView',
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_ripples_params(),
				ltx_vc_default_params()
			),
		) );

		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		    class WPBakeryShortCode_like_sc_ripples extends WPBakeryShortCodesContainer {
		    }
		}		
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_ripples_add', 30);
}


