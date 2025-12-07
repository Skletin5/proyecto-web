<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * TGM Plugin Activation
 */

require_once get_template_directory() . '/tgm-plugin-activation/class-tgm-plugin-activation.php';

if ( !function_exists('sana_action_theme_register_required_plugins') ) {

	function sana_action_theme_register_required_plugins() {

		$config = array(

			'id'           => 'sana',
			'menu'         => 'sana-install-plugins',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'dismissable'  => true,
			'is_automatic' => false,
		);

		tgmpa( array(

			array(
				'name'      => esc_html__('Unyson', 'sana'),
				'slug'      => 'unyson',
				'source'   	=> 'http://updates.like-themes.com/plugins/unyson/unyson-fork.zip',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('LT Extension', 'sana'),
				'slug'      => 'lt-ext',
				'source'   	=> get_template_directory() . '/inc/plugins/lt-ext.zip',
				'version'   => '2.1.6',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('WPBakery Page Builder', 'sana'),
				'slug'      => 'js_composer',
				'source'   	=> 'http://updates.like-themes.com/plugins/js_composer/js_composer.zip',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('Slider Revolution', 'sana'),
				'slug'      => 'revslider',
				'source'   	=> 'http://updates.like-themes.com/plugins/revslider/revslider.zip',
				'required'  => false,
			),							
			array(
				'name'      => esc_html__('Envato Market', 'sana'),
				'slug'      => 'envato-market',
				'source'   	=> get_template_directory() . '/inc/plugins/envato-market.zip',
				'required'  => false,
			),													
			array(
				'name'      => esc_html__('Breadcrumb-navxt', 'sana'),
				'slug'      => 'breadcrumb-navxt',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('Contact Form 7', 'sana'),
				'slug'      => 'contact-form-7',
				'required'  => true,
			),
			array(
				'name'       => esc_html__('MailChimp for WordPress', 'sana'),
				'slug'       => 'mailchimp-for-wp',
				'required'   => false,
			),		
			array(
				'name'       => esc_html__('WooCommerce', 'sana'),
				'slug'       => 'woocommerce',
				'required'   => false,
			),
			array(
				'name'      => esc_html__('Post-views-counter', 'sana'),
				'slug'      => 'post-views-counter',
				'required'  => false,
			),			
			array(
				'name'      => esc_html__('User Profile Picture', 'sana'),
				'slug'      => 'metronet-profile-picture',
				'required'  => false,
			),		
/*		
			array(
				'name'      => esc_html__('Instagram Widget by WPZOOM', 'sana'),
				'slug'      => 'instagram-widget-by-wpzoom',
				'required'  => false,
			),
*/
		), $config);
	}
}

add_action( 'tgmpa_register', 'sana_action_theme_register_required_plugins' );

