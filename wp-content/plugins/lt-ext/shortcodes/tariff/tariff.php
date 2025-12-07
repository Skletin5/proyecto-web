<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_tariff_params' ) ) {

	function ltx_vc_tariff_params() {

		$fields = array(
/*
			array(
				"param_name" => "layout",
				"heading" => esc_html__("Layout", 'lt-ext'),
				"admin_label" => true,
				"value" => array(
					esc_html__('3 blocks', 'lt-ext') 	=> 'default',
					esc_html__('4 blocks', 'lt-ext') 	=> 'black',
				),
				"type" => "dropdown"
			),
*/			
		
			array(
				"param_name" => "icon",
				"heading" => esc_html__("Icon", 'lt-ext'),
				"type" => "iconpicker"
			),		
			array(
				"param_name" => "image",
				"heading" => esc_html__("or Image", 'lt-ext'),
				"type" => "attach_image"
			),
	
			array(
				"param_name" => "header",
				"heading" => esc_html__("Header", 'lt-ext'),
				"description"	=>	esc_html__("Use brackets to highlight word", 'lt-ext'),				
				"admin_label" => true,
				"type" => "textfield"
			),
			array(
				"param_name" => "descr",
				"heading" => esc_html__("Description", 'lt-ext'),
				"type" => "textarea"

			),			
			array(
				"param_name" => "text",
				"heading" => esc_html__("List", 'lt-ext'),
				"description"	=>	esc_html__("To set yes prefix use {+}, to set no prefix use {-}", 'lt-ext'),				
		
				"type" => "exploded_textarea"

			),
			array(
				"param_name" => "price",
				"heading" => esc_html__("Price", 'lt-ext'),
				"description"	=>	esc_html__("Use brackets to set units as postfix (for ex: {{ /unit }} )", 'lt-ext'),
				"type" => "textfield"
			),			
			array(
				"param_name" => "btn_href",
				"heading" => esc_html__("Button Link", 'lt-ext'),
				"value"	=>	'#',
				"type" => "textfield"
			),				
			array(
				"param_name" => "btn_header",
				"heading" => esc_html__("Button Header", 'lt-ext'),
				"type" => "textfield"
			),				
								
			array(
				"param_name" => "vip",
				"heading" => esc_html__("Vip", 'lt-ext'),
				"description"	=>	esc_html__("Will be marked", 'lt-ext'),
				"admin_label" => true,						
				"type" => "checkbox"
			),	
			array(
				"param_name" => "vip_text",
				"heading" => esc_html__("Vip Label", 'lt-ext'),
				"type" => "textfield"
			),				
		
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_tariff' ) ) {

	function like_sc_tariff($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_tariff', $atts, array_merge( array(

			'layout'		=> 'default',
			'icon'			=> '',
			'image'			=> '',
			'header' 		=> '',
			'descr' 			=> '',
			'text' 			=> '',
			'highlight' 		=> '',
			'price' 		=> '',
			'btn_header' 	=> '',
			'btn_href' 		=> '',
			'vip' 			=> '',
			'vip_text' 	=> '',

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		if (!empty($atts['header']) || !empty($atts['image'])) {

			return like_sc_output('tariff', $atts, $content);
		}
			else {

			return false;
		}
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_tariff", "like_sc_tariff");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_tariff_add')) {

	function ltx_vc_tariff_add() {
		
		vc_map( array(
			"base" => "like_sc_tariff",
			"name" 	=> esc_html__("Tariff", 'lt-ext'),
			"description" => esc_html__("Tariff Single Block", 'lt-ext'),
			"class" => "like_sc_tariff",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/tariff/tariff.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_tariff_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_tariff_add', 30);
}


