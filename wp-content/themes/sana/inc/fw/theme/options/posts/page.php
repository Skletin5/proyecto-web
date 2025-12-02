<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$sana_choices =  array();
$sana_choices['default'] = esc_html__( 'Default', 'sana' );

$sana_color_schemes = fw_get_db_settings_option( 'items' );
if ( !empty($sana_color_schemes) ) {

	foreach ($sana_color_schemes as $v) {

		$sana_choices[$v['slug']] = esc_html( $v['name'] );
	}
}

$sana_theme_config = sana_theme_config();
$sana_sections_list = sana_get_sections();


$options = array(
	'general' => array(
		'title'   => esc_html__( 'Page settings', 'sana' ),
		'type'    => 'box',
		'options' => array(		
			'general-box' => array(
				'title'   => __( 'General Settings', 'sana' ),
				'type'    => 'tab',
				'options' => array(

					'margin-layout'    => array(
						'label' => esc_html__( 'Content Margin', 'sana' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Margins control for content', 'sana' ),
						'choices' => array(
							'default'  => esc_html__( 'Top And Bottom', 'sana' ),
							'top'  => esc_html__( 'Top Only', 'sana' ),
							'bottom'  => esc_html__( 'Bottom Only', 'sana' ),
							'disabled' => esc_html__( 'Margin Removed', 'sana' ),
						),
						'value' => 'default',
					),			
					'topbar-layout'    => array(
						'label' => esc_html__( 'Topbar section', 'sana' ),
						'desc' => esc_html__( 'You can edit it in Sections menu of dashboard.', 'sana' ),
						'type'    => 'select',
						'choices' => array('default' => 'Default') + array('hidden' => 'Hidden') + $sana_sections_list['top_bar'],						
						'value'	=> 'default',
					),						
					'navbar-layout'    => array(
						'label' => esc_html__( 'Navbar', 'sana' ),
						'type'    => 'select',
						'choices' => $sana_theme_config['navbar'] + array( 'disabled'  	=> esc_html__( 'Hidden', 'sana' ) ),
						'value' => $sana_theme_config['navbar-default'],
					),								
					'header-layout'    => array(
						'label' => esc_html__( 'Page Header', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'default'  => esc_html__( 'Default', 'sana' ),
							'disabled' => esc_html__( 'Hidden', 'sana' ),
						),
						'value' => 'default',
					),						
					'subscribe-layout'    => array(
						'label' => esc_html__( 'Subscribe Block', 'sana' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Subscribe block before footer. Can be edited from Sections Menu.', 'sana' ),
						'choices' => array(
							'default'  => esc_html__( 'Default', 'sana' ),
							'disabled' => esc_html__( 'Hidden', 'sana' ),
						),
						'value' => 'default',
					),					
					'footer-layout'    => array(
						'label' => esc_html__( 'Footer', 'sana' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Footer block before footer. Edited in Widgets menu.', 'sana' ),
						'choices' => $sana_theme_config['footer'] + array( 'disabled'  	=> esc_html__( 'Hidden', 'sana' ) ),
						'value' => $sana_theme_config['footer-default'],
					),	
					'footer-parallax'    => array(
						'label' => esc_html__( 'Footer Parallax', 'sana' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Footer block parallax effect.', 'sana' ),
						'choices' => array(
							'default'  => esc_html__( 'Default', 'sana' ),
							'disabled' => esc_html__( 'Disabled', 'sana' ),
						),
						'value' => 'default',
					),																			
					'color-scheme'    => array(
						'label' => esc_html__( 'Color Scheme', 'sana' ),
						'type'    => 'select',
						'choices' => $sana_choices,
						'value' => 'default',
					),								
				),											
			),	
			'cpt' => array(
				'title'   => esc_html__( 'Blog / Gallery', 'sana' ),
				'type'    => 'tab',
				'options' => array(				
					'sidebar-layout'    => array(
						'label' => esc_html__( 'Blog Sidebar', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'hidden' => esc_html__( 'Hidden', 'sana' ),
							'left'  => esc_html__( 'Sidebar Left', 'sana' ),
							'right'  => esc_html__( 'Sidebar Right', 'sana' ),
						),
						'value' => 'hidden',
					),						
					'blog-layout'    => array(
						'label' => esc_html__( 'Blog Layout', 'sana' ),
						'description'   => esc_html__( 'Used only for blog pages.', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'default'  => esc_html__( 'Default', 'sana' ),
							'classic'  => esc_html__( 'One Column', 'sana' ),
							'two-cols' => esc_html__( 'Two Columns', 'sana' ),
							'three-cols' => esc_html__( 'Three Columns', 'sana' ),
						),
						'value' => 'default',
					),
					'gallery-layout'    => array(
						'label' => esc_html__( 'Gallery Layout', 'sana' ),
						'description'   => esc_html__( 'Used only for gallery pages.', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'default' => esc_html__( 'Default', 'sana' ),
							'col-2' => esc_html__( 'Two Columns', 'sana' ),
							'col-3' => esc_html__( 'Three Columns', 'sana' ),
							'col-4' => esc_html__( 'Four Columns', 'sana' ),
						),
						'value' => 'default',
					),					
				)
			)	
		)
	),
);

unset($options['general']['options']['general-box']['options']['topbar-layout']);
unset($options['general']['options']['general-box']['options']['before-footer-layout']);
unset($options['general']['options']['general-box']['options']['color-scheme']);

