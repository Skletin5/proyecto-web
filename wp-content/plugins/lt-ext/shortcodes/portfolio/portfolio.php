<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Portfolio
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_portfolio_params' ) ) {

	function ltx_vc_portfolio_params() {
/*
		$cats = ltxGetPortfolioCats();
		$cat = array();
		foreach ($cats as $catId => $item) {

			$cat[$item['name']] = $catId;
		}
*/
		$fields = array(
/**			
			array(
				"param_name" => "cat",
				"heading" => esc_html__("Category", 'lt-ext'),
				"value" => array_merge(array(esc_html__('--', 'lt-ext') => 0), $cat),
				"type" => "dropdown"
			),
*/
			array(
				"param_name" => "layout",
				"heading" => esc_html__("Layout", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('6 Icons Row', 'lt-ext') => 'icon-row',
					esc_html__('Images with Icons (Materials)', 'lt-ext') => 'images',
					esc_html__('Photos (Houses)', 'lt-ext') => 'photos',
//					esc_html__('Single Service', 'lt-ext') => 'single',
				),
				"type" => "dropdown"
			),		
			array(
				"param_name" => "ids",
				"heading" => esc_html__("Filter IDs", 'lt-ext'),
				"description" => __("Enter IDs to show, separated by comma", 'lt-ext'),
				"admin_label" => true,
				"type" => "textfield"
			),						
			array(
				"param_name" => "limit",
				"heading" => esc_html__("Total Portfolio", 'lt-ext'),
				"description" => esc_html__("Number of portfolio to show", 'lt-ext'),
				"std"	=>	"6",				
				"admin_label" => true,
				"type" => "textfield"
			),
/*
			array(
				"param_name" => "style",
				"heading" => esc_html__("Style", 'lt-ext'),
				"std" => "bg-black",
				"value" => array(
					esc_html__('White Background', 'lt-ext') => 'bg-white',
					esc_html__('Black background', 'lt-ext') => 'bg-black',
				),
				"type" => "dropdown"
			),				
			array(
				"param_name" => "per_slide",
				"heading" => esc_html__("Portfolio per Slide", 'lt-ext'),
				"description" => esc_html__("If empty or null - no slider will be active", 'lt-ext'),
				"std"	=>	"3",
				"admin_label" => true,
				"type" => "textfield"
			),
			array(
				"param_name" => "autoplay",
				"heading" => esc_html__("Slider Autoplay, ms", 'lt-ext'),
				"description" => esc_html__("If empty or null - disabled", 'lt-ext'),
				"std"	=>	"0",
				"admin_label" => true,
				"type" => "textfield"
			),								
*/			
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_portfolio' ) ) {

	function like_sc_portfolio($atts, $content = null) {	

		$atts = like_sc_atts_parse('like_sc_portfolio', $atts, array_merge( array(

			'layout' 		=> 'posts',
			'ids' 			=> '',
			'limit' 		=> '',
			'highlight' 		=> '',
			'style' 		=> 'bg-gray',
			'per_slide' 	=> '',
			'cat' 			=> '',
			'autoplay' 		=> '0',


			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('portfolio', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_portfolio", "like_sc_portfolio");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_portfolio_add')) {

	function ltx_vc_portfolio_add() {
		
		vc_map( array(
			"base" => "like_sc_portfolio",
			"name" 	=> esc_html__("Portfolio", 'lt-ext'),
			"description" => esc_html__("Portfolio Posts slider", 'lt-ext'),
			"class" => "like_sc_portfolio",
//			"icon"	=>	ltxGetPluginUrl('/shortcodes/portfolio/portfolio.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_portfolio_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_portfolio_add', 30);
}


