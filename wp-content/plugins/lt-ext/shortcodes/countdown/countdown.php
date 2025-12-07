<?php if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * Shortcode Countdown
 */

// Shortcode fields configuration
if ( !function_exists( 'ltx_vc_countdown_params' ) ) {

	function ltx_vc_countdown_params() {

		$default_date = date('Y/m/d', strtotime("+3 months") );

		// Template can be edited in VC and doesn't need to be translated
		$template = '<span>%D <span>days</span></span>
<span class="divider">:</span>						
<span>%H <span>hours</span></span>
<span class="divider">:</span>
<span>%M <span>minutes</span></span>
<span class="divider">:</span>
<span>%S <span>seconds</span></span>';

		$fields = array(

			array(
				"param_name" => "type",
				"heading" => esc_html__("Section Style", 'lt-ext'),
				"std" => "default",
				"value" => array(
					esc_html__('Plain text', 'lt-ext') 		=> 'default',
					esc_html__('Circles', 'lt-ext') 		=> 'circles',
				),
				"type" => "dropdown"
			),
			array(
				"param_name" => "date",
				"heading" => esc_html__("Date in format (YYYY/MM/DD)", 'lt-ext'),
				"type" => "textfield",
				"std"	=>	$default_date,
			),	
			array(
				"param_name" => "template",
				"heading" => esc_html__("Html Template", 'lt-ext'),
				"type" => "textarea_raw_html",
				"std"	=>	$template,
			),						
		);

		return $fields;
	}
}

// Add Wp Shortcode
if ( !function_exists( 'like_sc_countdown' ) ) {

	function like_sc_countdown($atts, $content = null) {	

		$default_date = date('Y/m/d', strtotime("+3 months") );

		$template = urlencode(base64_encode('<span>%D <span>days</span></span>
		<span class="divider">:</span>						
		<span>%H <span>hours</span></span>
		<span class="divider">:</span>
		<span>%M <span>minutes</span></span>
		<span class="divider">:</span>
		<span>%S <span>seconds</span></span>'));

		$atts = like_sc_atts_parse('like_sc_countdown', $atts, array_merge( array(

			'type'		=> 'default',
			'date'		=> $default_date,
			'weeks'		=> '',
			'template'	=> $template,			

			), array_fill_keys(array_keys(ltx_vc_default_params(true)), null) )
		);

		return like_sc_output('countdown', $atts, $content);
	}

	if (ltx_vc_inited()) add_shortcode("like_sc_countdown", "like_sc_countdown");
}


// Adding shortcode to VC
if (!function_exists('ltx_vc_countdown_add')) {

	function ltx_vc_countdown_add() {
		
		vc_map( array(
			"base" => "like_sc_countdown",
			"name" 	=> esc_html__("CountDown", 'lt-ext'),
			"description" => esc_html__("Section with CountDown Numbers", 'lt-ext'),
			"class" => "like_sc_icons",
			"icon"	=>	ltxGetPluginUrl('/shortcodes/countdown/countdown.png'),
			"show_settings_on_create" => true,
			"category" => esc_html__('LTX-Themes', 'lt-ext'),
			'content_element' => true,
			"params" => array_merge(
				ltx_vc_countdown_params(),
				ltx_vc_default_params()
			)
		) );
	}

	if (ltx_vc_inited()) add_action('vc_before_init', 'ltx_vc_countdown_add', 30);
}


