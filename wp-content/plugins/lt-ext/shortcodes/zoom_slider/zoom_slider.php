<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Header
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_zoom_slider_params' ) ) {

	function ltx_vc_zoom_slider_params() {

		$cats = ltxGetSlidersCats();
		$cat = array();
		foreach ($cats as $catId => $item) {

			$cat[$item['name']] = $catId;
		}


		$fields = array(

			array(
				"param_name" => "category_filter",
				"heading" => esc_html__("Categories Filter", 'lt-ext'),
				"value" => array_merge(array(esc_html__('All Parent', 'lt-ext') => 0), $cat),
				"admin_label" => true,				
				"type" => "dropdown"
			),
/*			
			array(
				"param_name" => "images",
				"heading" => esc_html__("Background Images", 'lt-ext'),
				"admin_label" => true,
				"type" => "attach_images"
			),		

			array(
				"param_name" => "style",
				"heading" => esc_html__("Content Style", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Default', 'lt-ext') 			=> 'default',
					esc_html__('Rounded', 'lt-ext') 	=> 'rounded',
				),
				"type" => "dropdown"
			),	
*/

/*			
			array(
				"param_name" => "color",
				"heading" => esc_html__("Content Color", 'lt-ext'),
				"std" => "white",
				"value" => array(
					esc_html__('White', 'lt-ext') 	=> 'white',
					esc_html__('Black', 'lt-ext') 	=> 'black',
				),
				"type" => "dropdown"
			),					
*/			
/*			
			array(
				"param_name" => "align",
				"heading" => esc_html__("Content Align", 'lt-ext'),
				"std" => "center",
				"value" => array(
					esc_html__('Center', 'lt-ext') 	=> 'center',
					esc_html__('Left', 'lt-ext') 		=> 'left',
					esc_html__('Right', 'lt-ext') 	=> 'right',
				),
				"type" => "dropdown"
			),	
*/			

			array(
				"param_name" => "margin",
				"heading" => esc_html__("Default top navbar margin", 'lt-ext'),
				"std" => "true",
				"value" => array(
					esc_html__('Enabled', 'lt-ext') 	=> 'true',
					esc_html__('Disabled', 'lt-ext') 		=> 'false',
				),
				"type" => "dropdown"
			),	

			array(
				"param_name" => "overlay",
				"heading" => esc_html__("Overlay", 'lt-ext'),
				"std" => "plain",
				"value" => array(
//					esc_html__('Gradient overlay', 'lt-ext') 	=> 'plain',
//					esc_html__('Black overlay', 'lt-ext') 	=> 'gray',
					esc_html__('Black overlay', 'lt-ext') 	=> 'dots',
					esc_html__('Disabled', 'lt-ext') 		=> 'false',
				),
				"type" => "dropdown"
			),	
	
			array(
				"param_name" => "zoom",
				"heading" => esc_html__("Zoom Effect", 'lt-ext'),
				"std" => "default",
				"admin_label" => true,
				"value" => array(
					esc_html__('Zoom In', 'lt-ext') 	=> 'default',
					esc_html__('Zoom Out', 'lt-ext') 	=> 'out',
					esc_html__('Fade Only', 'lt-ext') 	=> 'fade',
				),
				"type" => "dropdown"
			),	
			array(
				"param_name" => "zs_speed",
				"heading" => esc_html__("Zoom Effect Speed, ms", 'lt-ext'),
				"std" => 20000,
				"admin_label" => true,
				"type" => "textfield"
			),			
			array(
				"param_name" => "zs_interval",
				"heading" => esc_html__("Interval between slides, ms", 'lt-ext'),
				"std" => 4500,
				"admin_label" => true,
				"type" => "textfield"
			),			
			array(
				"param_name" => "zs_content_effect",
				"heading" => esc_html__("Content Effect", 'lt-ext'),
				"std" => 'fade-top',
				"type" => "dropdown",
				"value"	=>	array(
					esc_html__( "Fade In", 'lt-ext' ) => "fade-in",
					esc_html__( "Fade from Top", 'lt-ext' ) => "fade-top",
					esc_html__( "Fade from Left", 'lt-ext' ) => "fade-left",
					esc_html__( "Fade from Right", 'lt-ext' ) => "static",
				),
			),				
			array(
				"param_name" => "zs_origin",
				"heading" => esc_html__("Zoom origin", 'lt-ext'),
				"std" => 'center-center',
				"admin_label" => true,
				"type" => "dropdown",
				"value"	=>	array(
					esc_html__( "Top Left", 'lt-ext' ) => "top-left",
					esc_html__( "Top Center", 'lt-ext' ) => "top-center",
					esc_html__( "Top-Right", 'lt-ext' ) => "top-right",						

					esc_html__( "Center Left", 'lt-ext' ) => "center-left",
					esc_html__( "Center", 'lt-ext' ) => "center-center",
					esc_html__( "Center Right", 'lt-ext' ) => "center-right",

					esc_html__( "Bottom Left", 'lt-ext' ) => "bottom-left",
					esc_html__( "Bottom Center", 'lt-ext' ) => "bottom-center",
					esc_html__( "Bottom Right", 'lt-ext' ) => "bottom-right",
				),
			),	
			array(
				"param_name" => "arrows",
				"heading" => esc_html__("Navigations arrows", 'lt-ext'),
				"std" => "true",
				"group"	=>	esc_html__('Navigation', 'lt-ext'),
				"value" => array(
					esc_html__('Hidden', 'lt-ext') 	=> 'false',
					esc_html__('Visible', 'lt-ext') 	=> 'true',
				),
				"type" => "dropdown"
			),				
/*			
			array(
				"param_name" => "arrow_left",
				"heading" => esc_html__("Arrow left", 'lt-ext'),
				"std" => "prev",
				"group"	=>	esc_html__('Navigation', 'lt-ext'),
				"type" => "textfield"
			),	
			array(
				"param_name" => "arrow_right",
				"heading" => esc_html__("Arrow right", 'lt-ext'),
				"std" => "next",
				"group"	=>	esc_html__('Navigation', 'lt-ext'),
				"type" => "textfield"
			),				
*/
/*			
			array(
				"param_name" => "bullets",
				"heading" => esc_html__("Navigations Bullets", 'lt-ext'),
				"std" => "false",
				"group"	=>	esc_html__('Navigation', 'lt-ext'),				
				"value" => array(
					esc_html__('Hidden', 'lt-ext') 	=> 'false',
					esc_html__('Visible', 'lt-ext') 	=> 'true',
//					esc_html__('Right', 'lt-ext') 	=> 'right',
				),
				"type" => "dropdown"
			),			
			array(
				"param_name" => "social",
				"heading" => esc_html__("Social Icons", 'lt-ext'),
				"std" => "false",
				"group"	=>	esc_html__('Navigation', 'lt-ext'),				
				"value" => array(
					esc_html__('Hidden', 'lt-ext') 	=> 'false',
					esc_html__('Visible', 'lt-ext') 	=> 'true',
				),
				"type" => "dropdown"
			),		
*/
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_zoom_slider' ) ) {

	function like_sc_zoom_slider($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_zoom_slider', $atts, array_merge( array(

			'category_filter'		=> '',
			'zoom'		=> '',
			'style'		=> 'default',
			'color'		=> 'white',
			'align'		=> '',
			'arrows' 	=> 'false',
			'arrow_left' 	=> '',
			'arrow_right' 	=> '',
			'bullets' 	=> 'false',
			'overlay' 	=> 'plain',			
			'images' 	=> '',
			'margin' 	=> 'true',
			'shadow' 	=> 'disabled',
			'images2' 	=> '',
			'social' 	=> '',
			'zs_speed' 	=> '20000',
			'zs_interval' 	=> '4500',
			'zs_origin' 	=> 'center-center',
			'zs_content_effect' => 'fade-top',
			

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('zoom_slider', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_zoom_slider", "like_sc_zoom_slider");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_zoom_slider_add')) {

	function ltx_vc_zoom_slider_add() {
		
		vc_map( array(
			"base" => "like_sc_zoom_slider",
			"name" 	=> esc_html__("LTX Zoom Slider", 'lt-ext'),
			"description" => esc_html__("Background changing with Ken Burns effect", 'lt-ext'),
			"class" => "like_sc_zoom_slider",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/zoom_slider/zoom_slider.png'),
			//"is_container" => true,
			//"js_view" => 'VcColumnView',
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			//'content_element' => true,
			"params" => array_merge(
				ltx_vc_zoom_slider_params(),
				ltx_vc_default_params()
			),
		) );
/*
		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		    class WPBakeryShortCode_like_sc_zoom_slider extends WPBakeryShortCodesContainer {
		    }
		}
*/		
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_zoom_slider_add', 30);
}


