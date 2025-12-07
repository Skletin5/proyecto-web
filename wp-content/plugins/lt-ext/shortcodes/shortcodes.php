<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcodes Init
 * https://codex.wordpress.org/Shortcode_API 
 */

if ( !function_exists('ltxthemes_sc_init') ) {

	function ltxthemes_sc_init() {

		if (function_exists('FW')) {

			/**
			 * Not all shortcodes can used in the theme
			 */
			$shortcodes_array = array(

				'alert'			=>	true,
				'block-icon'	=>	true,			
				'blog'			=>	true,
//				'bubbles'		=>	true,
				'button'		=>	true,
//				'cards'			=>	true,				
//				'calc'			=>	true,				
				'contact_form_7'=>	true,				
//				'countdown'		=>	true,
				'countup'		=>	true,
				'content_width'	=>	true,
//				'events_calendar'	=>	true,
				'empty_space'	=>	true,
				'gallery'	=>	true,
				'google_maps'	=>	true,
//				'gym_calculator'	=>	true,
				'header'		=>	true,
				'image-header'	=>	true,
//				'ltx_tabs'		=>	true,
//				'navmenu'			=>	true,
//				'portfolio'		=>	true,
				'partners'		=>	true,
//				'parallax_image'	=>	true,			
//				'parallax_slider'	=>	true,			
				'products'				=>	true,
//				'ripples'		=>	true,
				'products_categories'	=>	true,
//				'schedule'		=>	true,
//				'sliders'		=>	true,
				'slider_full'		=>	true,							
				'services'		=>	true,			
				'social-icons'	=>	true,
				'tariff'		=>	true,
//				'topbar-icons'		=>	true,
				'team_slider'		=>	true,
				'testimonials'	=>	true,				
//				'zoom_slider'	=>	true,			
//				'sliders'		=>	true,
			);

			foreach ($shortcodes_array as $item => $enabled) {

				$sc_include = ltxGetLocalPath( '/shortcodes/' . $item . '/' . $item . '.php' );
				if ( $enabled AND file_exists( $sc_include ) ) {

					include_once $sc_include;
				}
			}
		}
	}
}
add_action( 'after_setup_theme', 'ltxthemes_sc_init', 100 );

/**
 * Default fields for all shortcodes
 */
if ( !function_exists( 'ltx_vc_default_params' ) ) {

	function ltx_vc_default_params($ids = false) {

		$group = esc_html__('Attributes', 'lt-ext');

		// quickfix for wpbakery 5.6
		if ( $ids === true ) {

			$fields = array(

				'id' => array(
					'type'			=> 'textfield',
					'heading' 		=> esc_html__("Element ID", 'lt-ext'),
					'param_name' 	=> "id",
					'admin_label' 	=> true,
					'group'			=> $group,
				),
				'class' => array(
					'type'			=> 'textfield',
					'heading' 		=> esc_html__("Extra class name", 'lt-ext'),
					'param_name' 	=> "class",
					'admin_label'	=> true,
					'group'			=> $group,
				),
				'css' => array(
					'param_name' 	=> 'css',
					'heading' 		=> esc_html__( 'CSS box', 'lt-ext' ),
					'group' 		=> esc_html__( 'Design Options', 'lt-ext' ),
					'type' 			=> 'css_editor'
				)
			);			
		}
			else {

			$fields = array(

				array(
					'type'			=> 'textfield',
					'heading' 		=> esc_html__("Element ID", 'lt-ext'),
					'param_name' 	=> "id",
					'admin_label' 	=> true,
					'group'			=> $group,
				),
				array(
					'type'			=> 'textfield',
					'heading' 		=> esc_html__("Extra class name", 'lt-ext'),
					'param_name' 	=> "class",
					'admin_label'	=> true,
					'group'			=> $group,
				),
				array(
					'param_name' 	=> 'css',
					'heading' 		=> esc_html__( 'CSS box', 'lt-ext' ),
					'group' 		=> esc_html__( 'Design Options', 'lt-ext' ),
					'type' 			=> 'css_editor'
				)
			);
		}

		apply_filters( 'ltx_vc_default_params', $fields );

		return $fields;

	}
}

/**
 * Adding VC params
 */
if ( !function_exists( 'ltx_vc_add_params' ) ) {

	function ltx_vc_add_params() {

		global $ltx_cfg;

		if ( !isset($ltx_cfg['sections']) ) $ltx_cfg['sections'] = array();
		if ( empty($ltx_cfg['background']) ) $ltx_cfg['background'] = array();
		if ( empty($ltx_cfg['overlay']) ) $ltx_cfg['overlay'] = array();

		$colors = array (

			array(
				"type" => "dropdown",
				"heading" => esc_html__("Background Color", 'lt-ext'),
				"description" => esc_html__("Set Background Color from Theme Default Colors", 'lt-ext'),
				"param_name" => "bg_color_select",
				"std"	=>	"transparent",
				"group" => esc_html__('Background', 'lt-ext'),
				"value" => array_merge(
					array(
						esc_html__( "Transparent" , 'lt-ext') => "transparent",
					),
					$ltx_cfg['background']
				),				
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Background Overlay", 'lt-ext'),
				"description" => esc_html__("Background overlay effect", 'lt-ext'),
				"param_name" => "bg_overlay",
				"std"	=>	"none",
				"group" => esc_html__('Background', 'lt-ext'),
				"value" => array_merge(
					array(
						esc_html__( "None", 'lt-ext' ) => "none"
					),
					$ltx_cfg['overlay']
				),				
			),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Background Overlay Mode", 'lt-ext'),
				"description" => esc_html__("Background repeat will be disabled", 'lt-ext'),
				"param_name" => "bg_overlay_mode",
				"std"	=>	"always",
				"group" => esc_html__('Background', 'lt-ext'),
				"value" => 
					array(
						esc_html__( "Always", 'lt-ext' ) => "always",
						esc_html__( "Desktop Only", 'lt-ext' ) => "desktop",
						esc_html__( "Mobile Only", 'lt-ext' ) => "mobile",
					),
			),					
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Background Repeat", 'lt-ext'),
				"description" => esc_html__("Background repeat will be disabled", 'lt-ext'),
				"param_name" => "bg_repeat",
				"std"	=>	"none",
				"group" => esc_html__('Background', 'lt-ext'),
				"value" => 
					array(
						esc_html__( "No repeat", 'lt-ext' ) => "none",
						esc_html__( "Repeat-X", 'lt-ext' ) => "repeat-x",
						esc_html__( "Repeat-Y", 'lt-ext' ) => "repeat-y",
					),
			),				
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Background Position", 'lt-ext'),
				"description" => esc_html__("Background repeat will be disabled", 'lt-ext'),
				"param_name" => "bg_pos",
				"std"	=>	"default",
				"group" => esc_html__('Background', 'lt-ext'),
				"value" => 
					array(
						esc_html__( "Default", 'lt-ext' ) => "default",

						esc_html__( "Top-left", 'lt-ext' ) => "left-top",
						esc_html__( "Top-center", 'lt-ext' ) => "center-top",
						esc_html__( "Top-right", 'lt-ext' ) => "right-top",						

						esc_html__( "Center-left", 'lt-ext' ) => "left-center",
						esc_html__( "Center-center", 'lt-ext' ) => "center-center",
						esc_html__( "Center-right", 'lt-ext' ) => "right-center",						

						esc_html__( "Bottom-left", 'lt-ext' ) => "left-bottom",
						esc_html__( "Bottom-center", 'lt-ext' ) => "center-bottom",
						esc_html__( "Bottom-right", 'lt-ext' ) => "right-bottom",
					),
			),			
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Box Shadow", 'lt-ext'),
				"description" => esc_html__("Section with Shadow border", 'lt-ext'),
				"param_name" => "border_shadow",
				"std"	=>	"none",
				"group" => esc_html__('Background', 'lt-ext'),
				"value" => array(
					esc_html__( "None", 'lt-ext' ) => "none",
					esc_html__( "Shadowed", 'lt-ext' ) => "shadow",
					esc_html__( "Bottom shadow", 'lt-ext' ) => "bottom-shadow",
				),
			),
			array(
				'type'			=> 'dropdown',
				'heading' 		=> esc_html__("Background Parallax", 'lt-ext'),
				"description" => esc_html__("Alternative Parallax", 'lt-ext'),
				'std' 			=> "disabled",
				'param_name' 	=> "bg_parallax",
				"group" => esc_html__('Background', 'lt-ext'),
				"value" => array(
					esc_html__( "Disabled", 'lt-ext' ) => "disabled",
					esc_html__( "Static Background", 'lt-ext' ) => "static",
					esc_html__( "Parallax", 'lt-ext' ) => "parallax",
				),				
			),			
			array(
				'type'			=> 'textfield',
				'heading' 		=> esc_html__("Parallax Strength", 'lt-ext'),
				"description" => esc_html__("Float number (0.0 - fixed, 1.0 - scroll)", 'lt-ext'),
				'std' 			=> "0.2",
				'param_name' 	=> "bg_parallax_value",
				"group" => esc_html__('Background', 'lt-ext'),
				'dependency' => array(
					'element' => 'bg_parallax',
					'value' => array('parallax'),
				),	
			),			
		
		);

		foreach ($colors as $param) {

			vc_add_param("vc_section", $param);
			vc_add_param("vc_row", $param);
			vc_add_param("vc_row_inner", $param);
			vc_add_param("vc_column", $param);
			vc_add_param("vc_column_inner", $param);
		}

		$section_class = array( 
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Text Align", 'lt-ext'),
				"description" => esc_html__("Row Text Align", 'lt-ext'),
				"param_name" => "text_align",
				"std"	=>	"default",
				"group" => esc_html__('Settings', 'lt-ext'),
				"value" => array(
					esc_html__( "Default", 'lt-ext' ) => "default",
					esc_html__( "Center", 'lt-ext' ) => "center",
					esc_html__( "Center Only Mobile", 'lt-ext' ) => "center-ms",
					esc_html__( "Center Only Tablet and Mobile", 'lt-ext' ) => "center-sm-ms",
					esc_html__( "Center on 1200px and less ", 'lt-ext' ) => "center-md-sm-ms",
					esc_html__( "Right", 'lt-ext' ) => "right",
					esc_html__( "Right Only Desktop", 'lt-ext' ) => "right-lg",
				),
			),			
			array(
				"type" => "dropdown",
				"heading" => esc_html__("ltx Theme Section Class", 'lt-ext'),
				"description" => esc_html__("Used to style unique theme blocks", 'lt-ext'),
				"param_name" => "theme_section",
				"group" => esc_html__('Settings', 'lt-ext'),				
				"std"	=>	"none",
				"value" => array_merge(
					array(
						esc_html__( "None", 'lt-ext' ) => "none"
					),
					$ltx_cfg['sections']
				),
			),
		);

		foreach ($section_class as $param) {

			vc_add_param("vc_section", $param);
			vc_add_param("vc_row", $param);
			vc_add_param("vc_row_inner", $param);
			vc_add_param("vc_column", $param);
			vc_add_param("vc_column_inner", $param);		
		}	
	
		$img_class = array( 
/*			
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Shadow", 'lt-ext'),
				"description" => esc_html__("Used to style unique theme blocks", 'lt-ext'),
				"param_name" => "img_shadow",				
				"std"	=>	"plain",
				"value" => 
					array(
						esc_html__( "None", 'lt-ext' ) => "none",
						esc_html__( "Bottom Plain Border", 'lt-ext' ) => "plain",
					),
			),
*/			
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Inline", 'lt-ext'),
				"description" => esc_html__("Use to set inline images", 'lt-ext'),
				"param_name" => "inline",
				"std"	=>	"none",
				"value" => 
					array(
						esc_html__( "Default (One in row)", 'lt-ext' ) => "none",
						esc_html__( "Inline", 'lt-ext' ) => "inline",
					),
			),			
		);

		foreach ($img_class as $param) {	

			vc_add_param("vc_single_image", $param);
		}

	}

}

if ( !function_exists( 'ltx_vc_scrollreveal_params' ) ) {
	function ltx_vc_scrollreveal_params() {

		$fields = array(
			array(
				"param_name" => "scrollreveal_type",
				"heading" => esc_html__("Animation", 'lt-ext'),
				"group" => esc_html__('ScrollReveal', 'lt-ext'),					
				"std" => "disabled",
				"value" => array(
					esc_html__('Disabled', 'lt-ext') 			=> 'disabled',
					esc_html__('Zoom In', 'lt-ext') 			=> 'zoom_in',
					esc_html__('Fade In', 'lt-ext') 			=> 'fade_in',
					esc_html__('Slide From Left', 'lt-ext') 	=> 'slide_from_left',
					esc_html__('Slide From Right', 'lt-ext') 	=> 'slide_from_right',
					esc_html__('Slide From Top', 'lt-ext') 		=> 'slide_from_top',
					esc_html__('Slide From Bottom', 'lt-ext') 	=> 'slide_from_bottom',
					esc_html__('Rotate 360 deg', 'lt-ext') 		=> 'slide_rotate',
				),
				"type" => "dropdown"
			),
			array(
				"param_name" => "scrollreveal_elements",
				"heading" => esc_html__("Elements", 'lt-ext'),
				"description" => esc_html__("Select elemets to animate", 'lt-ext'),
				"group" => esc_html__('ScrollReveal', 'lt-ext'),					
				"std" => "block",
				"value" => array(
					esc_html__('Single Block', 'lt-ext') 			=> 'block',
					esc_html__('Every Article/Item', 'lt-ext') 		=> 'items',
					esc_html__('Every Paragraph/Image/Button', 'lt-ext') 	=> 'text_el',
					esc_html__('Every List Element', 'lt-ext') 		=> 'list_el',
				),
				"type" => "dropdown"
			),		
			array(
				"param_name" => "scrollreveal_delay",
				"heading" => esc_html__("Delay", 'lt-ext'),
				"description" => esc_html__("Start Delay", 'lt-ext'),
				"group" => esc_html__('ScrollReveal', 'lt-ext'),					
				"std" => "200",
				"value" => array(
					esc_html__('No Delay', 'lt-ext') 		=> '0',
					esc_html__('Quick Delay (200ms)', 'lt-ext') 			=> '200',
					esc_html__('Long Delay (500ms)', 'lt-ext') 		=> '500',
					esc_html__('Extra Long Delay (1000ms)', 'lt-ext') 		=> '1000',
				),
				"type" => "dropdown"
			),		
			array(
				"param_name" => "scrollreveal_duration",
				"heading" => esc_html__("Duration", 'lt-ext'),
				"description" => esc_html__("How long one element animation goes", 'lt-ext'),
				"group" => esc_html__('ScrollReveal', 'lt-ext'),					
				"std" => "300",
				"value" => array(
					esc_html__('Very Fast (150ms)', 'lt-ext') 		=> '150',
					esc_html__('Fast (300ms)', 'lt-ext') 			=> '300',
					esc_html__('Moderate (500ms)', 'lt-ext') 		=> '500',
					esc_html__('Long (800ms)', 'lt-ext') 			=> '800',
					esc_html__('Extra Long (1200ms)', 'lt-ext') 	=> '1200',
				),
				"type" => "dropdown"
			),		
			array(
				"param_name" => "scrollreveal_sequences_delay",
				"heading" => esc_html__("Sequences Delay", 'lt-ext'),
				"description" => esc_html__("Delay between elements in one section", 'lt-ext'),
				"group" => esc_html__('ScrollReveal', 'lt-ext'),					
				"std" => "100",
				"value" => array(
					esc_html__('No Delay (all at once)', 'lt-ext') 		=> '0',
					esc_html__('Quick  (100ms)', 'lt-ext') 			=> '100',
					esc_html__('Moderate (200ms)', 'lt-ext') 			=> '200',
					esc_html__('Long  (300ms)', 'lt-ext') 		=> '300',
					esc_html__('Extra Long (500ms)', 'lt-ext') 		=> '500',
				),
				"type" => "dropdown"
			),		
			/*
			array(
				"param_name" => "scrollreveal_easing",
				"heading" => esc_html__("Easing", 'lt-ext'),
				"description" => esc_html__("CSS Easing", 'lt-ext'),
				"group" => esc_html__('ScrollReveal', 'lt-ext'),					
				"std" => "ease-in-out",
				"value" => array(
					esc_html__('Ease-in-Out', 'lt-ext') 	=> 'ease-in-out',
					esc_html__('Ease-Out-Bounce', 'lt-ext') 	=> 'ease-out-bounce',
					esc_html__('Linear', 'lt-ext') 			=> 'linear',
				),
				"type" => "dropdown"
			),				
			*/
		);

		return $fields;
	}
}

if ( !function_exists( 'ltx_vc_add_scrollreveal' ) ) {
	function ltx_vc_add_scrollreveal() {

		$params = ltx_vc_scrollreveal_params();

		foreach ($params as $param) {

			vc_add_param("vc_single_image", $param);
			vc_add_param("vc_section", $param);
			vc_add_param("vc_row", $param);
			vc_add_param("vc_row_inner", $param);
			vc_add_param("vc_column", $param);
			vc_add_param("vc_column_inner", $param);		
		}	
	}
}

/**
 * Adding new class names to existing VC Shortcodes
 */
if ( !function_exists( 'ltx_vc_add_element_class' ) ) {

	function ltx_vc_add_element_class($class = '', $tag, $atts) {

		if ( in_array( $tag, array('vc_section', 'vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_single_image') ) ) {

			if ( !empty($atts['bg_tone']) AND $atts['bg_tone'] != 'default' ) $class .= esc_attr( ' bg-tone-'.$atts['bg_tone'] );
			if ( !empty($atts['bg_color_select']) AND $atts['bg_color_select'] != 'transparent' ) {

				$class .= esc_attr( ' bg-color-'.$atts['bg_color_select'] );

				if ( $atts['bg_color_select'] == 'gradient') $class .= esc_attr( ' bg-color-black' );
			}

			if ( !empty($atts['bg_repeat']) AND $atts['bg_repeat'] != 'none' ) $class .= esc_attr( ' bg-'.$atts['bg_repeat'] );
			
			if ( !empty($atts['bg_pos']) AND $atts['bg_pos'] != 'default' ) $class .= esc_attr( ' bg-pos-'.$atts['bg_pos'] );			
			if ( !empty($atts['bg_overlay']) AND $atts['bg_overlay'] != 'none' ) $class .= esc_attr( ' ltx-overlay bg-overlay-'.$atts['bg_overlay'] );

			if ( !empty($atts['bg_overlay_mode']) AND $atts['bg_overlay_mode'] != 'always' ) $class .= esc_attr( ' bg-overlay-mode-'.$atts['bg_overlay_mode'] );

			if ( !empty($atts['border_shadow']) AND $atts['border_shadow'] == 'shadow' ) $class .= esc_attr( ' border_shadow ' );
				else
			if ( !empty($atts['border_shadow']) AND $atts['border_shadow'] == 'bottom-shadow' ) $class .= esc_attr( ' bottom-shadow ' );

			if ( !empty($atts['theme_section']) AND $atts['theme_section'] != 'none' ) $class .= esc_attr( ' '.$atts['theme_section'] );
			if ( !empty($atts['text_align']) AND $atts['text_align'] != 'default' ) $class .= esc_attr( ' text-align-'.$atts['text_align'] );

			if ( !empty($atts['bg_parallax']) AND $atts['bg_parallax'] != 'disabled' AND $atts['bg_parallax'] != 'disbled' ) {

				if ( empty($atts['bg_parallax_value']) ) {

					$atts['bg_parallax_value'] = 0.2;
				}

				$class .= esc_attr( ' bg-parallax ltx-bg-parallax-enabled' );
				$class .= esc_attr( ' ltx-bg-parallax-value-'.esc_attr( $atts['bg_parallax_value'] ) );
			}

			/* Scroll Reveal */
			if ( !empty($atts['scrollreveal_type']) AND $atts['scrollreveal_type'] != 'disabled' ) {

				$class .= esc_attr( ' ltx-sr ltx-sr-effect-'.$atts['scrollreveal_type'] ).' '.
						  esc_attr( ' ltx-sr-id-'.mt_rand().' ').
						  esc_attr( ' ltx-sr-el-'.$atts['scrollreveal_elements'] ).' '.
						  esc_attr( ' ltx-sr-delay-'.$atts['scrollreveal_delay'] ).' '.
						  esc_attr( ' ltx-sr-duration-'.$atts['scrollreveal_duration'] ).' '.
						  esc_attr( ' ltx-sr-sequences-'.$atts['scrollreveal_sequences_delay'] );
			}
		}

		if ( in_array( $tag, array('vc_single_image') ) ) {

//			if ( !empty($atts['img_shadow']) AND $atts['img_shadow'] != 'none' ) $class .= esc_attr( ' img-shadow-'.$atts['img_shadow'] );
			if ( !empty($atts['inline']) AND $atts['inline'] != 'none' ) $class .=  ' inline';
		}

		if ( in_array( $tag, array('contact-form-7') ) ) {

			if ( !empty($atts['form_style']) ) $class .= esc_attr( ' form-style-'.$atts['form_style'] );			
			if ( !empty($atts['form_padding']) ) $class .= esc_attr( ' form-padding-'.$atts['form_padding'] );

		}

		return $class;
	}
}

if ( ltx_vc_inited() ) {

	vc_set_default_editor_post_types(

		array('page', 'sections', 'sliders', 'services', 'portfolio', 'team')
	);

	add_action( 'after_setup_theme', 'ltx_vc_add_params', 5 );
	add_action( 'after_setup_theme', 'ltx_vc_add_scrollreveal', 5 );
	add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,	'ltx_vc_add_element_class', 10, 3 );	
}

/**
 * Parsing shortcodes attributing
 */
if (!function_exists('like_sc_atts_parse')) {

	function like_sc_atts_parse($sc, $atts, $default = array()) {


		if (!empty($atts)) {		

			$atts_default = vc_map_get_attributes( $sc, $atts );
			$is_empty = true;
			foreach ($atts_default as $k => $v) {

				if ( empty($atts[$k]) AND !empty($atts_default[$k]) ) {

					$atts[$k] = $v;
				}
			}


			foreach ($atts as &$item) {

				$item = ltx_header_parse($item);
			}
		}
			else {

			$atts = array();
		}

		if ( empty($atts['class']) ) $atts['class'] = '';


		if ( !empty($atts['css']) ) {

			$atts['class'] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $atts['class'] . ' ' . vc_shortcode_custom_css_class( $atts['css'], ' ' ), $sc, $atts);
			$atts['css'] = '';
		}

		if ( empty($atts['id']) ) {

			$atts['id'] = $sc . '_' . mt_rand();
		}
	
		$atts = ltx_html_decode(shortcode_atts(apply_filters('like_sc_atts', $default, $sc), $atts));

 		return apply_filters('like_sc_atts', $atts, $sc);
	}
}

if (!function_exists('ltx_header_parse')) {

	function ltx_header_parse($item) {

		$item = str_replace(array('{{', '}}'), array('<span>', '</span>'), $item);
		$item = str_replace(array('{+}'), array('<span class="ul-yes fa fa-check"></span>'), $item);
		$item = str_replace(array('{-}'), array('<span class="ul-no fa fa-close"></span>'), $item);

		return $item;
	}
}

/**
 * Adding shortcode output
 */
if ( !function_exists( 'like_sc_output' ) ) {

	function like_sc_output($sc, $atts, $content = null) {	

		if ( !empty($content) ) $atts['content'] = do_shortcode($content);

		set_query_var('like_sc_' . $sc, $atts);

		$path = ltxGetLocalPath('/shortcodes/'.$sc.'/view.php');
		ob_start();
		if (file_exists($path)) include $path;
		$out = ob_get_contents();
		ob_end_clean();

		return $out;
	}
}

if (!function_exists('ltx_html_decode')) {
	function ltx_html_decode($string) {
		if ( is_array($string) && count($string) > 0 ) {
			foreach ($string as $key => &$value) {
				if (is_string($value)) {

					$value = htmlspecialchars_decode($value, ENT_QUOTES);
				}
			}
		}
		return $string;
	}
}


/**
 * Shortcode to display site logo
 */
function ltx_sc_logo( ) {

	sana_the_logo('white');
}
add_shortcode( 'ltx-logo', 'ltx_sc_logo' );

/**
 * Page header social icons
 */
function ltx_nav_social_shortcode( $atts ) {

	$atts = shortcode_atts(
		array(
			'color' => 'second',
			'type' => '',
			'text' => '',
			'text-before' => '',
		), $atts, 'sana-social'
	);

	$out = '';

	if ( function_exists( 'fw' ) ) {

		$sana_social_icons = fw_get_db_settings_option( 'social-icons' );
		$sana_social_target = fw_get_db_settings_option( 'target-social' );

		if ( $sana_social_target == 'self') {

			$target = "_self";
		}
			else {

			$target = "_blank";
		}



		if ( !empty($sana_social_icons) ) {

			$out .= '<div class="ltx-social ltx-nav-'.esc_attr($atts['color']).' ltx-type-'.esc_attr($atts['type']).'">';

			if ( !empty($atts['text-before']) ) {

				$out .= '<span class="header"><span>'.esc_html($atts['text-before']).'</span></span>';
			}

			$out .= '<ul>';
				foreach ($sana_social_icons as $item ) {

					$out .= '<li><a href="'. esc_url( $item['href'] ) .'" target="'.esc_attr( $target ).'"><span class="'. esc_attr( $item['icon_v2']['icon-class'] ) .'"></span></a></li>';
				}
			$out .= '</ul>';

			if ( !empty($atts['text']) ) {

				$out .= '<span class="header"><span>'.esc_html($atts['text']).'</span></span>';
			}

			$out .= '</div>';
		}
	}

	return $out;
}
add_shortcode( 'ltx-social', 'ltx_nav_social_shortcode' );

add_shortcode( 'ltx-navbar-icons', 'sana_the_navbar_icons' );


if ( !function_exists( 'ltx_share_buttons_conf' ) ) {

	/**
	 * Sharing buttons configuration
	 */
	function ltx_share_buttons_conf() {

		$links = array(

			'facebook'	=>	array(
				'header' => 'Facebook',
				'link' => 'http://www.facebook.com/sharer.php?u={link}',
				'icon' => 'fa-facebook',
				'active'	=>	1,
			),
			'twitter'	=>	array(
				'header' => 'Twitter',
				'link' => 'https://twitter.com/intent/tweet?link={link}&text={title}',
				'icon' => 'fa-twitter',
				'active'	=>	1,
			),
			'gplus'	=>	array(
				'header' => 'Google+',
				'link' => 'https://plus.google.com/share?url={link}',
				'icon' => 'fa-google-plus',
				'active'	=>	1,
			),
			'linkedin'	=>	array(
				'header' => 'Linkedin',
				'link' => 'http://www.linkedin.com/shareArticle?mini=true&amp;url={link}',
				'icon' => 'fa-linkedin',
				'active'	=>	1,
			),
			'email'	=>	array(
				'header' => 'E-mail',
				'link' => 'mailto:?subject={title}&body={link}',
				'icon' => 'fa-envelope',
				'active'	=>	0,
			),						
		);

		if ( function_exists('FW') ) {

			foreach ( $links as $key => &$item ){

				$state = fw_get_db_settings_option( 'share_icon_' . $key );

				if ( !is_null($state) ) {

					if ( $state === true ) {

						$item['active'] = 1;
					}
						else {

						$item['active'] = 0;
					}
				}			
			}
		}

		return $links;
	}

	/**
	 * Displays sharing buttons
	 */
	function ltx_the_share_buttons( $args ) {

		if ( function_exists('FW') ) {

			$hide = fw_get_db_settings_option( 'share_icons_hide' );
			$custom = fw_get_db_settings_option( 'share-add' );

			if ( !empty($hide) ) {

				return false;
			}
		}

		$links = ltx_share_buttons_conf();

		$out = '';
		$out .= '<ul class="ltx-sharing">';

		if ( !empty($args['header']) ) {

			$out .= '<li class="sharing-header">' . esc_html($args['header']) .'</li>';
		}

		if ( !empty($links) ) {

			foreach ( $links as $header => $item ) {

				if ( $item['active'] == 1 ) {

					$link = str_replace(
						array('{title}', '{link}'),
						array(get_the_title(), get_permalink()),
						$item['link']
					);

					$out .= '<li><a href="'.esc_url($link).'"><span class="ltx-social-color fa '.esc_attr($item['icon']).'"></span></a></li>';
				}
			}
		}

		if ( !empty($custom) ) {

			foreach ( $custom as $item ) {

				$link = str_replace(
					array('{title}', '{link}'),
					array(get_the_title(), get_permalink()),
					$item['link']
				);

				$color_style = '';
				if ( !empty($item['color']) ) {

					$color_style = ' style="background-color: '.esc_attr($item['color']).'" ';
				}	

				$out .= '<li><a href="'.esc_url($link).'"><span class="ltx-social-color '.esc_attr($item['icon']['icon-class']).'"'.$color_style.'></span></a></li>';
			}

		}

		$out .= '</ul>';
		
		return $out;
	}	


	add_shortcode( 'ltx-share-icons', 'ltx_the_share_buttons' );	
}

if ( !function_exists( 'ltx_team_image' ) ) {

	/**
	 * Display current team image for single page
	 */
	function ltx_team_image() {

		global $wp_query;

		return wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'full', false  );
	}
}
add_shortcode( 'ltx-team-image', 'ltx_team_image' );


if ( !function_exists( 'ltx_header_tagline' ) ) {

	/**
	 * Display header tagline
	 */
	function ltx_header_tagline( $args ) {

		if ( function_exists( 'FW' ) ) {
			
			$tagline = fw_get_db_settings_option( 'tagline' );
			if ( !empty($tagline) ) {

				$type = '';
				if ( !empty($args['type']) ) {

					$type = $args['type'];
				}

				return '<span class="ltx-tagline '.esc_attr($type).'"><span>'.esc_html($tagline).'</span></span>';
			}
		}
	}
}
add_shortcode( 'ltx-header-tagline', 'ltx_header_tagline' );


if ( !function_exists( 'ltx_overlay_lines' ) ) {

	/**
	 * Display overlay
	 */
	function ltx_overlay_lines() {

		return '<span class="ltx-overlay-lines"></span>';
	}
}
add_shortcode( 'ltx-overlay-lines', 'ltx_overlay_lines' );


if ( !function_exists( 'ltx_overlay_border' ) ) {

	/**
	 * Display overlay
	 */
	function ltx_overlay_border() {

		return '<span class="ltx-overlay-border"><span class="ltx-border-top"></span><span class="ltx-border-bottom"></span></span>';
	}
}
add_shortcode( 'ltx-overlay-border', 'ltx_overlay_border' );


