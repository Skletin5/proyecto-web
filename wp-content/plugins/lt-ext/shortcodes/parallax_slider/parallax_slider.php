<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_parallax_slider_params' ) ) {

	function ltx_vc_parallax_slider_params() {

		$fields = array(
			array(
				'type' => 'param_group',
				'param_name' => 'items',
				'heading' => esc_html__( 'Layers', 'lt-ext' ),
				"description" => wp_kses_data( __("The upper layers have higher visibility priority, the background goes last", 'lt-ext') ),
				'value' => urlencode( json_encode( array(
					array(
						'header' => '',
						'size' => '',
					),
				) ) ),
				'params' => array(
					array(
						"param_name" => "image",
						"heading" => esc_html__("image", 'lt-ext'),
						"admin_label" => true,
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_size",
						"heading" => esc_html__("Backgrond Size", 'lt-ext'),
						"std" => "100%",
						"value" => array(
							esc_html__('Cover', 'lt-ext') => 'cover',
							esc_html__('100%', 'lt-ext') => '100%',
							esc_html__('Contain', 'lt-ext') => 'contain',
						),
						"type" => "dropdown"
					),											
					array(
						'param_name' => 'pos_bottom',
						'heading' => esc_html__( 'Bottom offset', 'lt-ext' ),
						'type' => 'textfield',
						'value'	=>	 0,
						'admin_label' => true,
					),
					array(
						'param_name' => 'strength',
						'heading' => esc_html__( 'Strength (float)', 'lt-ext' ),
						'type' => 'textfield',
						'value'	=>	 1,
						'admin_label' => true,
					),
					array(
						"param_name" => "direction",
						"heading" => esc_html__("Direction", 'lt-ext'),
						"std" => "vertical",
						"value" => array(
							esc_html__('Vertical', 'lt-ext') => 'vertical',
							esc_html__('Heading Horizontal', 'lt-ext') => 'horizontal',
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "type",
						"heading" => esc_html__("Animation Type", 'lt-ext'),
						"std" => "foreground",
						"value" => array(
							esc_html__('Background', 'lt-ext') => 'background',
							esc_html__('Foreground', 'lt-ext') => 'foreground',
						),
						"type" => "dropdown"
					),										
				),
			),
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_parallax_slider' ) ) {

	function like_sc_parallax_slider($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_parallax_slider', $atts, array_merge( array(

			'items'	=>	'',
			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		$atts['items'] = json_decode ( urldecode( $atts['items'] ), true );

		return like_sc_output('parallax_slider', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_parallax_slider", "like_sc_parallax_slider");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_parallax_slider_add')) {

	function ltx_vc_parallax_slider_add() {
		
		vc_map( array(
			"base" => "like_sc_parallax_slider",
			"name" 	=> esc_html__("Parallax Slider", 'lt-ext'),
//			"description" => esc_html__("Background changing with Ken Burns effect", 'lt-ext'),
			"class" => "like_sc_parallax_slider",
//			"icon"	=>	ltxGetPluginUrl('/shortcodes/parallax_slider/parallax_slider.png'),
			"is_container" => true,
			"js_view" => 'VcColumnView',
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_parallax_slider_params(),
				ltx_vc_default_params()
			),
		) );

		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		    class WPBakeryShortCode_like_sc_parallax_slider extends WPBakeryShortCodesContainer {
		    }
		}
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_parallax_slider_add', 30);
}


