<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode ltx_tabs
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_ltx_tabs_params' ) ) {

	function ltx_vc_ltx_tabs_params() {

		$fields = array(

			array(
				'type' => 'param_group',
				'param_name' => 'items',
				'heading' => esc_html__( 'Tabs', 'lt-ext' ),
				"description" => wp_kses_data( __("We recomend to add up to 3 boxes", 'lt-ext') ),
				'value' => urlencode( json_encode( array(
					array(
						'header' => '',
					),
				) ) ),
				'params' => array(
					array(
						'param_name' => 'header',
						'heading' => esc_html__( 'Header', 'lt-ext' ),
						'type' => 'textarea',
						'admin_label' => true,
					),
					array(
						'param_name' => 'descr',
						'heading' => esc_html__( 'Description', 'lt-ext' ),
						'type' => 'textarea',
						'admin_label' => false,
					),					
					array(
						"param_name" => "image",
						"heading" => esc_html__("Background Image", 'lt-ext'),
						"type" => "attach_image"
					),							
					array(
						'param_name' => 'btn_header',
						'heading' => esc_html__( 'Button Header', 'lt-ext' ),
						'type' => 'textfield',
						"std" => 'Get started',
					),											
					array(
						'param_name' => 'btn_href',
						'heading' => esc_html__( 'Button URL', 'lt-ext' ),
						'type' => 'textfield',
						"std" => '#',
					),
				),
			),								
		);

		return $fields;

	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_ltx_tabs' ) ) {

	function like_sc_ltx_tabs($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_ltx_tabs', $atts, array_merge( array(

				'items'	=>	'',
			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		$atts['items'] = json_decode ( urldecode( $atts['items'] ), true );		

		return like_sc_output('ltx_tabs', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_ltx_tabs", "like_sc_ltx_tabs");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_ltx_tabs_add')) {

	function ltx_vc_ltx_tabs_add() {
		
		vc_map( array(
			"base" => "like_sc_ltx_tabs",
			"name" 	=> esc_html__("LTX Horizontal Tabs", 'lt-ext'),
			"description" => esc_html__("3 Items Tabs Block", 'lt-ext'),
			"class" => "like_sc_ltx_tabs",
			"icon"	=>	"",
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			"params" => array_merge(
				ltx_vc_ltx_tabs_params(),
				ltx_vc_default_params()
			),
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_ltx_tabs_add', 30);
}


