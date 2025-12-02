<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$sana_theme_config = sana_theme_config();
$sana_sections_list = sana_get_sections();

$navbar_custom_assign = array();

if ( !empty( $sana_theme_config['navbar'] ) AND is_array($sana_theme_config['navbar']) AND sizeof( $sana_theme_config['navbar']) > 1 ) {

	$menus = get_terms('nav_menu');
	if ( !empty($menus) ) {

		$list = array();
		foreach ( $menus as $item ) {

			$list[$item->term_id] = $item->name;
		}

		foreach ( $sana_theme_config['navbar'] as $key => $val) {

			$navbar_custom_assign['navbar-'.$key.'-assign'] = array(
				'label' => sprintf( esc_html__( 'Navbar %s Assign', 'sana' ), ucwords($key) ),
				'type'    => 'select',
				'desc' => esc_html__( 'You can assign additional menus for inner navbar.', 'sana' ),
				'value' => 'default',
				'choices' => array('default' => esc_html__( 'Default', 'sana' )) + $list,
			);
		}

		$navbar_custom_assign = array();
	}
}

$options = array(
	'general' => array(
		'title'   => esc_html__( 'General', 'sana' ),
		'type'    => 'tab',
		'options' => array(
			'general-box' => array(
				'title'   => esc_html__( 'General Settings', 'sana' ),
				'type'    => 'tab',
				'options' => array(						
					'page-loader'    => array(
						'type'    => 'multi-picker',
						'picker'       => array(
							'loader' => array(
								'label'   => esc_html__( 'Page Loader', 'sana' ),
								'type'    => 'select',
								'choices' => array(
									'disabled' => esc_html__( 'Disabled', 'sana' ),
									'image' => esc_html__( 'Image', 'sana' ),
									'enabled' => esc_html__( 'Theme Loader', 'sana' ),
								),
								'value' => 'enabled'
							)
						),						
						'choices' => array(
							'image' => array(
								'loader_img'    => array(
									'label' => esc_html__( 'Page Loader Image', 'sana' ),
									'type'  => 'upload',
								),
							),
						),
						'value' => 'enabled',
					),	
					'google_api'    => array(
						'label' => esc_html__( 'Google Maps API Key', 'sana' ),
						'desc'  => esc_html__( 'Required for contacts page, also used in widget', 'sana' ),
						'type'  => 'text',
					),								
				),
			),
			'logo' => array(
				'title'   => esc_html__( 'Logo and Media', 'sana' ),
				'type'    => 'tab',
				'options' => array(	
					'logo-box' => array(
						'title'   => esc_html__( 'Logo', 'sana' ),
						'type'    => 'box',
						'options' => array(			
							'favicon'    => array(
								'html' => esc_html__( 'To change Favicon go to Appearance -> Customize -> Site Identity', 'sana' ),
								'type'  => 'html',
							),							
							'logo'    => array(
								'label' => esc_html__( 'Logo Black', 'sana' ),
								'type'  => 'upload',
							),
							'logo_2x'    => array(
								'label' => esc_html__( 'Logo Black 2x', 'sana' ),
								'type'  => 'upload',
							),	
							'logo_white'    => array(
								'label' => esc_html__( 'Logo White', 'sana' ),
								'type'  => 'upload',
							),
							'logo_white_2x'    => array(
								'label' => esc_html__( 'Logo White 2x', 'sana' ),
								'type'  => 'upload',
							),		
							'404_bg'    => array(
								'label' => esc_html__( '404 Background', 'sana' ),
								'type'  => 'upload',
							),						
						),
					),
				),
			),				
		),
	),
	'header' => array(
		'title'   => esc_html__( 'Header', 'sana' ),
		'type'    => 'tab',
		'options' => array(
			'header-box-2' => array(
				'title'   => esc_html__( 'Navbar', 'sana' ),
				'type'    => 'tab',
				'options' => array(
					'navbar-default'    => array(
						'label' => esc_html__( 'Navbar Default', 'sana' ),
						'type'    => 'select',
						'value' => $sana_theme_config['navbar-default'],
						'choices' => $sana_theme_config['navbar'],
					),	
					'navbar-default-force'    => array(
						'label' => esc_html__( 'Navbar Default Override', 'sana' ),
						'desc'   => esc_html__( 'By default every page can have unqiue navbar setting. You can override them here.', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'disabled' => esc_html__( 'Disabled. Every page uses its own settings', 'sana' ),
							'force'  => esc_html__( 'Enabled. Override all site pages and use Navbar Default', 'sana' ),
						),
						'value' => 'disabled',
					),						
					'navbar-affix'    => array(
						'label' => esc_html__( 'Navbar Sticked', 'sana' ),
						'desc'   => esc_html__( 'May not work with all navbar types', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'' => esc_html__( 'Allways Static', 'sana' ),
							'affix'  => esc_html__( 'Sticked', 'sana' ),
						),
						'value' => '',
					),
/*
					'navbar-affix-scroll'    => array(
						'label' => esc_html__( 'Navbar Sticked Option', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'' => esc_html__( 'Allways Visible', 'sana' ),
							'scroll-hide'  => esc_html__( 'Hidden on scroll down', 'sana' ),
						),
						'value' => '',
					),					
*/					
					'navbar-breakpoint'    => array(
						'label' => esc_html__( 'Navbar Mobile Breakpoint, px', 'sana' ),
						'desc'   => esc_html__( 'Mobile menu will be displayed in viewports below this value', 'sana' ),
						'type'    => 'text',
						'value' => '1600',
					),						
					$navbar_custom_assign,
				)
			),
			'header-box-topbar' => array(
				'title'   => esc_html__( 'Topbar', 'sana' ),
				'type'    => 'tab',
				'options' => array(
					'topbar-info'    => array(
						'label' => ' ',
						'type'    => 'html',
						'html' => esc_html__( 'You can edit topbar in sections menu of dashboard', 'sana' ),
					),					
					'topbar'    => array(
						'label' => esc_html__( 'Topbar visibility', 'sana' ),
						'desc'   => esc_html__( 'You can edit topbar layout in Sections menu', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'visible'  => esc_html__( 'Always Visible', 'sana' ),
							'desktop'  => esc_html__( 'Desktop Visible', 'sana' ),
							'desktop-tablet'  => esc_html__( 'Desktop and Tablet Visible', 'sana' ),
							'mobile'  => esc_html__( 'Mobile only Visible', 'sana' ),
							'hidden' => esc_html__( 'Hidden', 'sana' ),
						),
						'value' => 'hidden',
					),					
					'topbar-section'    => array(
						'label' => esc_html__( 'Topbar section', 'sana' ),
						'desc' => esc_html__( 'You can edit it in Sections menu of dashboard.', 'sana' ),
						'type'    => 'select',
						'choices' => array('' => 'None / Hidden') + $sana_sections_list['top_bar'],						
						'value'	=> '',
					),						
				)
			),			
			'header-box-icons' => array(
				'title'   => esc_html__( 'Icons and Elements', 'sana' ),
				'type'    => 'tab',
				'options' => array(		
					'icons-info'    => array(
						'label' => ' ',
						'type'    => 'html',
						'html' => esc_html__( 'Icons can be displayed in topbar using shortcode: [ltx-navbar-icons]', 'sana' ),
					),																
					'navbar-icons' => array(
		                'label' => esc_html__( 'Navbar / Topbar Icons', 'sana' ),
		                'desc' => esc_html__( 'Depends on theme style', 'sana' ),
		                'type' => 'addable-box',
		                'value' => array(),
		                'box-options' => array(
							'type'        => array(
								'type'         => 'multi-picker',
								'label'        => false,
								'desc'         => false,
								'picker'       => array(
									'type_radio' => array(
										'label'   => esc_html__( 'Type', 'sana' ),
										'type'    => 'radio',
										'choices' => array(
											'search' => esc_html__( 'Search', 'sana' ),
											'basket'  => esc_html__( 'WooCommerce Cart', 'sana' ),
											'profile'  => esc_html__( 'User Profile', 'sana' ),
											'social'  => esc_html__( 'Social Icon', 'sana' ),
										),
									)
								),
								'choices'      => array(
									'basket'  => array(
										'count'    => array(
											'label' => esc_html__( 'Count', 'sana' ),
											'type'    => 'select',
											'choices' => array(
												'show' => esc_html__( 'Show count label', 'sana' ),
												'hide'  => esc_html__( 'Hide count label', 'sana' ),
											),
											'value' => 'show',
										),											
									),
									'profile'  => array(
					                    'header' => array(
					                        'label' => esc_html__( 'Non-logged header', 'sana' ),
					                        'type' => 'text',
					                        'value' => '',
					                    ),										
									),
									'social'  => array(
					                    'text' => array(
					                        'label' => esc_html__( 'Label', 'sana' ),
					                        'type' => 'text',
					                    ),
					                    'href' => array(
					                        'label' => esc_html__( 'External Link', 'sana' ),
					                        'type' => 'text',
					                        'value' => '#',
					                    ),											
									),		
								),
								'show_borders' => false,
							),	  														                	
							'icon-type'        => array(
								'type'         => 'multi-picker',
								'label'        => false,
								'desc'         => false,
								'value'        => array(
									'icon_radio' => 'default',
								),
								'picker'       => array(
									'icon_radio' => array(
										'label'   => esc_html__( 'Icon', 'sana' ),
										'type'    => 'radio',
										'choices' => array(
											'default'  => esc_html__( 'Default', 'sana' ),
											'fa' => esc_html__( 'FontAwesome', 'sana' )
										),
										'desc'    => esc_html__( 'For social icons you need to use FontAwesome in any case.',
											'sana' ),
									)
								),
								'choices'      => array(
									'default'  => array(
									),
									'fa' => array(
										'icon_v2'  => array(
											'type'  => 'icon-v2',
											'label' => esc_html__( 'Select Icon', 'sana' ),
										),										
									),
								),
								'show_borders' => false,
							),
							'icon-visible'        => array(
								'label'   => esc_html__( 'Visibility', 'sana' ),
								'type'    => 'radio',
								'value'    => 'hidden-mob',								
								'choices' => array(
									'hidden-mob'  => esc_html__( 'Hidden on mobile', 'sana' ),
									'visible-mob' => esc_html__( 'Visible on mobile', 'sana' )
								),
							),							
							'profile-name'        => array(
								'label'   => esc_html__( 'Profile Name', 'sana' ),
								'type'    => 'radio',
								'value'    => 'hidden',								
								'choices' => array(
									'hidden'  => esc_html__( 'Hidden', 'sana' ),
									'visible' => esc_html__( 'Visible', 'sana' )
								),
							),								
		                ),
                		'template' => '{{- type.type_radio }}',		                
                    ),
					'basket-icon'    => array(
						'label' => esc_html__( 'Basket icon in navbar', 'sana' ),
						'desc'   => esc_html__( 'As replacement for basket in topbar in mobile view', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'disabled' => esc_html__( 'Hidden', 'sana' ),
							'mobile'  => esc_html__( 'Visible on Mobile', 'sana' ),
						),
						'value' => 'disabled',
					),	
/*
					'navbar_btn'    => array(
						'label' => esc_html__( 'Navbar Button Header', 'sana' ),
						'desc'  => esc_html__( 'Displayed after default white navbar', 'sana' ),
						'type'  => 'text',
					),	
					'navbar_btn_href'    => array(
						'label' => esc_html__( 'Navbar Button Href', 'sana' ),
						'value'	=> '#',
						'type'  => 'text',
					),	
*/					
					'navbar-search'    => array(
						'label' => esc_html__( 'Navbar Search', 'sana' ),
						'desc'   => esc_html__( 'Display after navbar with bottom border', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'disabled' => esc_html__( 'Hidden', 'sana' ),
							'visible'  => esc_html__( 'Visible on Desktop', 'sana' ),
						),
						'value' => 'disabled',
					),						
				),
			),
			'header-box-1' => array(
				'title'   => esc_html__( 'Page Header H1', 'sana' ),
				'type'    => 'tab',
				'options' => array(
					'pageheader-display'    => array(
						'label' => esc_html__( 'Page Header Visibility', 'sana' ),
						'desc'   => esc_html__( 'Status of Page Header with H1 and Breadcrumbs', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'default' => esc_html__( 'Default', 'sana' ),
							'disabled'  => esc_html__( 'Force Hidden on all Pages', 'sana' ),
						),
						'value' => 'fixed',
					),		
					'pageheader-overlay'    => array(
						'label' => esc_html__( 'Page Header Overlay', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'enabled' => esc_html__( 'Enabled', 'sana' ),
							'disabled'  => esc_html__( 'Disabled', 'sana' ),
						),
						'value' => 'enabled',
					),										
					'header_bg'    => array(
						'label' => esc_html__( 'Inner Pages Header Background', 'sana' ),
						'desc'  => esc_html__( 'By default header is gray, you can replace it with background image', 'sana' ),
						'type'  => 'upload',
					),  				
					'wc_bg'    => array(
						'label' => esc_html__( 'WooCommerce Header Background', 'sana' ),
						'desc'  => esc_html__( 'Used only for WooCommerce pages', 'sana' ),
						'type'  => 'upload',
					),  					
					'header_fixed'    => array(
						'label' => esc_html__( 'Background parallax', 'sana' ),
						'desc'   => esc_html__( 'Parallax effect requires large images', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'disabled' => esc_html__( 'Disabled', 'sana' ),
							'fixed'  => esc_html__( 'Enabled', 'sana' ),
						),
						'value' => 'fixed',
					),
					'featured_bg'    => array(
						'label' => esc_html__( 'Featured Images as Background', 'sana' ),
						'desc'  => esc_html__( 'Use Featured Image for Page as Header Background for all the pages', 'sana' ),
						'type'    => 'select',						
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'sana' ),
							'enabled' => esc_html__( 'Enabled', 'sana' ),
						),
						'value' => 'disabled',
					),	
					'tagline'    => array(
						'label' => esc_html__( 'Header Tagline', 'sana' ),
						'desc'  => esc_html__( 'Visible on left side of inner page header', 'sana' ),
						'type'  => 'text',
					),
					'header-social'    => array(
						'label' => esc_html__( 'Social icons in page header', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'sana' ),
							'enabled' => esc_html__( 'Enabled', 'sana' ),
						),
						'value' => 'enabled',
					),	

				),
			),
		),
	),	
	'footer' => array(
		'title'   => esc_html__( 'Footer', 'sana' ),
		'type'    => 'tab',
		'options' => array(

			'footer-box-1' => array(
				'title'   => esc_html__( 'Widgets', 'sana' ),
				'type'    => 'tab',
				'options' => array(
					'footer-layout-default'    => array(
						'label' => esc_html__( 'Footer Default Style', 'sana' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Footer block before copyright. Edited in Widgets menu.', 'sana' ),
						'choices' => $sana_theme_config['footer'],
						'value' => $sana_theme_config['footer-default'],
					),						
					'footer_widgets'    => array(
						'label' => esc_html__( 'Enable Footer Widgets', 'sana' ),
						'desc'   => esc_html__( 'Widgets controled in Appearance -> Widgets. Column will be hidden, then no active widgets exists', 'sana' ),	
						'type'  => 'checkbox',
						'value'	=> 'true',
					),					
					'footer-parallax'    => array(
						'label' => esc_html__( 'Footer Parallax', 'sana' ),
						'type'    => 'select',							
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'sana' ),
							'enabled' => esc_html__( 'Enabled', 'sana' ),
						),
						'value' => 'enabled',
					),						
					'footer_bg'    => array(
						'label' => esc_html__( 'Footer Background', 'sana' ),
						'type'  => 'upload',
					),		
					'footer-box-1-1' => array(
						'title'   => esc_html__( 'Desktop widgets visibility', 'sana' ),
						'type'    => 'box',
						'options' => array(

							'footer_1_hide'    => array(
								'label' => esc_html__( 'Footer 1', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),						
							),
							'footer_2_hide'    => array(
								'label' => esc_html__( 'Footer 2', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),	
							),
							'footer_3_hide'    => array(
								'label' => esc_html__( 'Footer 3', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),	
							),
							'footer_4_hide'    => array(
								'label' => esc_html__( 'Footer 4', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),	
							),
						)
					),
					'footer-box-1-2' => array(
						'title'   => esc_html__( 'Notebook widgets visibility', 'sana' ),
						'type'    => 'box',
						'options' => array(

							'footer_1__hide_md'    => array(
								'label' => esc_html__( 'Footer 1', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),						
							),
							'footer_2_hide_md'    => array(
								'label' => esc_html__( 'Footer 2', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),	
							),
							'footer_3_hide_md'    => array(
								'label' => esc_html__( 'Footer 3', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),	
							),
							'footer_4_hide_md'    => array(
								'label' => esc_html__( 'Footer 4', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),	
							),
						)
					),					
					'footer-box-1-3' => array(
						'title'   => esc_html__( 'Mobile widgets visibility', 'sana' ),
						'type'    => 'box',
						'options' => array(
							'footer_1_hide_mobile'    => array(
								'label' => esc_html__( 'Footer 1', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),
							),
							'footer_2_hide_mobile'    => array(
								'label' => esc_html__( 'Footer 2', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),
							),
							'footer_3_hide_mobile'    => array(
								'label' => esc_html__( 'Footer 3', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),
							),
							'footer_4_hide_mobile'    => array(
								'label' => esc_html__( 'Footer 4', 'sana' ),
								'type'  => 'switch',
								'value'	=> 'show',
								'left-choice' => array(
									'value' => 'hide',
									'label' => esc_html__('Hide', 'sana'),
								),
								'right-choice' => array(
									'value' => 'show',
									'label' => esc_html__('Show', 'sana'),
								),
							),														
						)
					)
				),
			),
			'footer-box-subscribe' => array(
				'title'   => esc_html__( 'Subscribe and Other', 'sana' ),
				'type'    => 'tab',
				'options' => array(
					'footer-sections'    => array(
						'html' => esc_html__( 'You can edit all items in Sections menu of dashboard.', 'sana' ),
						'type'  => 'html',
					),							
					'subscribe-section'    => array(
						'label' => esc_html__( 'Subscribe block', 'sana' ),
						'desc' => esc_html__( 'Section displayed before widgets on every page. You can hide in on certain page in page settings.', 'sana' ),
						'type'    => 'select',
						'choices' => array('' => 'None / Hidden') + $sana_sections_list['subscribe'],						
						'value'	=> '',
					),
					'before-footer-section'    => array(
						'label' => esc_html__( 'Before Footer section', 'sana' ),
						'desc' => esc_html__( 'Section displayed under all content before subscribe/widgets.', 'sana' ),
						'type'    => 'select',
						'choices' => array('' => 'None / Hidden') + $sana_sections_list['before_footer'],
						'value'	=> '',
					),					
				),
			),	
			'footer-box-2' => array(
				'title'   => esc_html__( 'Go Top', 'sana' ),
				'type'    => 'tab',
				'options' => array(															
					'go_top_visibility'    => array(
						'label' => esc_html__( 'Go Top Visibility', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'visible'  => esc_html__( 'Always visible', 'sana' ),
							'desktop' => esc_html__( 'Desktop Only', 'sana' ),
							'mobile' => esc_html__( 'Mobile Only', 'sana' ),
							'hidden' => esc_html__( 'Hidden', 'sana' ),
						),						
						'value'	=> 'visible',
					),		
					'go_top_pos'    => array(
						'label' => esc_html__( 'Go Top Position', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'floating'  => esc_html__( 'Floating', 'sana' ),
							'static' => esc_html__( 'Static at the footer', 'sana' ),
						),						
						'value'	=> 'floating',
					),		
					'go_top_img'    => array(
						'label' => esc_html__( 'Go Top Image', 'sana' ),
						'type'  => 'upload',
					),		
					'go_top_text'    => array(
						'label' => esc_html__( 'Go Top Text', 'sana' ),
						'type'  => 'text',
					),														
				),
			),
			'footer-box-3' => array(
				'title'   => esc_html__( 'Copyrights', 'sana' ),
				'type'    => 'tab',
				'options' => array(																							
					'copyrights'    => array(
						'label' => esc_html__( 'Copyrights', 'sana' ),
						'type'  => 'wp-editor',
					),									
				),
			),					
		),
	),	
	'layout' => array(
		'title'   => esc_html__( 'Posts Layout', 'sana' ),
		'type'    => 'tab',
		'options' => array(

			'layout-box-1' => array(
				'title'   => esc_html__( 'Blog Posts', 'sana' ),
				'type'    => 'tab',
				'options' => array(

					'blog_layout'    => array(
						'label' => esc_html__( 'Blog Layout', 'sana' ),
						'desc'   => esc_html__( 'Default blog page layout.', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'classic'  => esc_html__( 'One Column', 'sana' ),
							'two-cols' => esc_html__( 'Two Columns', 'sana' ),
							'three-cols' => esc_html__( 'Three Columns', 'sana' ),
						),
						'value' => 'classic',
					),				
					'blog_list_sidebar'    => array(
						'label' => esc_html__( 'Blog List Sidebar', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'sana' ),
							'left' => esc_html__( 'Left', 'sana' ),
							'right' => esc_html__( 'Right', 'sana' ),
						),
						'value' => 'right',
					),				
					'blog_post_sidebar'    => array(
						'label' => esc_html__( 'Blog Post Sidebar', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'sana' ),
							'left' => esc_html__( 'Left', 'sana' ),
							'right' => esc_html__( 'Right', 'sana' ),
						),
						'value' => 'right',
					),																				
					'excerpt_auto'    => array(
						'label' => esc_html__( 'Excerpt Classic Blog Size', 'sana' ),
						'desc'  => esc_html__( 'Automaticly cuts content for blogs', 'sana' ),
						'value'	=> 350,
						'type'  => 'short-text',
					),
					'excerpt_masonry_auto'    => array(
						'label' => esc_html__( 'Excerpt Masonry Blog Size', 'sana' ),
						'desc'  => esc_html__( 'Automaticly cuts content for blogs', 'sana' ),
						'value'	=> 150,
						'type'  => 'short-text',
					),
					'blog_gallery_autoplay'    => array(
						'label' => esc_html__( 'Gallery post type autoplay, ms', 'sana' ),
						'desc'  => esc_html__( 'Set 0 to disable autoplay', 'sana' ),
						'type'  => 'text',
						'value' => '4000',
					),						
				)
			),
			'layout-box-2' => array(
				'title'   => esc_html__( 'Services', 'sana' ),
				'type'    => 'tab',
				'options' => array(	
					'services_list_layout'    => array(
						'label' => esc_html__( 'Services List Layout', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'classic'  => esc_html__( 'One Column', 'sana' ),
							'two-cols' => esc_html__( 'Two Columns', 'sana' ),
							'three-cols' => esc_html__( 'Three Columns', 'sana' ),
						),
						'value' => 'two-cols',
					),						
					'services_list_sidebar'    => array(
						'label' => esc_html__( 'Services List Sidebar', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'sana' ),
							'left' => esc_html__( 'Left', 'sana' ),
							'right' => esc_html__( 'Right', 'sana' ),
						),
						'value' => 'hidden',
					),				
					'services_post_sidebar'    => array(
						'label' => esc_html__( 'Services Post Sidebar', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'sana' ),
							'left' => esc_html__( 'Left', 'sana' ),
							'right' => esc_html__( 'Right', 'sana' ),
						),
						'value' => 'hidden',
					),					
				)
			),
			'layout-box-3' => array(
				'title'   => esc_html__( 'WooCommerce', 'sana' ),
				'type'    => 'tab',
				'options' => array(
					'shop_list_sidebar'    => array(
						'label' => esc_html__( 'WooCommerce List Sidebar', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'sana' ),
							'left' => esc_html__( 'Left', 'sana' ),
							'right' => esc_html__( 'Right', 'sana' ),
						),
						'value' => 'left',
					),				
					'shop_post_sidebar'    => array(
						'label' => esc_html__( 'WooCommerce Product Sidebar', 'sana' ),
						'desc'   => esc_html__( 'Blog Post Sidebar', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'hidden'  => esc_html__( 'Hidden', 'sana' ),
							'left' => esc_html__( 'Left', 'sana' ),
							'right' => esc_html__( 'Right', 'sana' ),
						),
						'value' => 'hidden',
					),											
					'excerpt_wc_auto'    => array(
						'label' => esc_html__( 'Excerpt WooCommerce Size', 'sana' ),
						'desc'  => esc_html__( 'Automaticly cuts description for products', 'sana' ),
						'value'	=> 50,
						'type'  => 'short-text',
					),		
					'wc_zoom'    => array(
						'label' => esc_html__( 'WooCommerce Product Hover Zoom', 'sana' ),
						'type'    => 'select',
						'desc'   => esc_html__( 'Enables mouse hover zoom in single product page', 'sana' ),
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'sana' ),
							'enabled' => esc_html__( 'Enabled', 'sana' ),
						),
						'value' => 'disabled',
					),
					'wc_columns'    => array(
						'label' => esc_html__( 'Columns number', 'sana' ),
						'desc'  => esc_html__( 'Overrides default WooCommerce settings', 'sana' ),
						'type'  => 'text',
						'value' => '3',
					),
					'wc_per_page'    => array(
						'label' => esc_html__( 'Products per Page', 'sana' ),
						'type'  => 'text',
						'value' => '6',
					),
					'wc_show_list_excerpt'    => array(
						'label' => esc_html__( 'Display Excerpt in Shop List', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'sana' ),
							'enabled' => esc_html__( 'Enabled', 'sana' ),
						),
						'value' => 'disabled',
					),					
					'wc_show_list_rate'    => array(
						'label' => esc_html__( 'Display Rate in Shop List', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'sana' ),
							'enabled' => esc_html__( 'Enabled', 'sana' ),
						),
						'value' => 'disabled',
					),
					'wc_show_list_attr'    => array(
						'label' => esc_html__( 'Display Attributes in Shop List', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'disabled'  => esc_html__( 'Disabled', 'sana' ),
							'enabled' => esc_html__( 'Enabled', 'sana' ),
						),
						'value' => 'enabled',
					),															
				)
			),
			'layout-box-4' => array(
				'title'   => esc_html__( 'Gallery', 'sana' ),
				'type'    => 'tab',
				'options' => array(													
					'gallery_layout'    => array(
						'label' => esc_html__( 'Default Gallery Layout', 'sana' ),
						'desc'   => esc_html__( 'Default galley page layout.', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'col-2' => esc_html__( 'Two Columns', 'sana' ),
							'col-3' => esc_html__( 'Three Columns', 'sana' ),
							'col-4' => esc_html__( 'Four Columns', 'sana' ),
						),
						'value' => 'col-2',
					),						
				)
			)
		)
	),
	'fonts' => array(
		'title'   => esc_html__( 'Fonts', 'sana' ),
		'type'    => 'tab',
		'options' => array(

			'fonts-box' => array(
				'title'   => esc_html__( 'Fonts Settings', 'sana' ),
				'type'    => 'tab',
				'options' => array(
					'font-main'                => array(
						'label' => __( 'Main Font', 'sana' ),
						'type'  => 'typography-v2',
						'desc'	=>	esc_html__( 'Use https://fonts.google.com/ to find font you need', 'sana' ),
						'value'      => array(
							'family'    => $sana_theme_config['font_main'],
							'subset'    => 'latin-ext',
							'variation' => $sana_theme_config['font_main_var'],
							'size'      => 0,
							'line-height' => 0,
							'letter-spacing' => 0,
							'color'     => '#000'
						),
						'components' => array(
							'family'         => true,
							'size'           => false,
							'line-height'    => false,
							'letter-spacing' => false,
							'color'          => false
						),
					),
					'font-main-weights'    => array(
						'label' => esc_html__( 'Additonal weights', 'sana' ),
						'desc'  => esc_html__( 'Coma separates weights, for example: "800,900"', 'sana' ),
						'type'  => 'text',
						'value'  => $sana_theme_config['font_main_weights'],							
					),											
					'font-headers'                => array(
						'label' => __( 'Headers Font', 'sana' ),
						'type'  => 'typography-v2',
						'value'      => array(
							'family'    => $sana_theme_config['font_headers'],
							'subset'    => 'latin-ext',
							'variation' => $sana_theme_config['font_headers_var'],
							'size'      => 0,
							'line-height' => 0,
							'letter-spacing' => 0,
							'color'     => '#000'
						),
						'components' => array(
							'family'         => true,
							'size'           => false,
							'line-height'    => false,
							'letter-spacing' => false,
							'color'          => false
						),
					),
					'font-headers-weights'    => array(
						'label' => esc_html__( 'Additonal weights', 'sana' ),
						'desc'  => esc_html__( 'Coma separates weights, for example: "600,800"', 'sana' ),
						'type'  => 'text',
						'value'  => $sana_theme_config['font_headers_weights'],						
					),
					'font-subheaders'                => array(
						'label' => __( 'SubHeaders Font', 'sana' ),
						'type'  => 'typography-v2',
						'value'      => array(
							'family'    => $sana_theme_config['font_subheaders'],
							'subset'    => 'latin-ext',
							'variation' => $sana_theme_config['font_subheaders_var'],
							'size'      => 0,
							'line-height' => 0,
							'letter-spacing' => 0,
							'color'     => '#000'
						),
						'components' => array(
							'family'         => true,
							'size'           => false,
							'line-height'    => false,
							'letter-spacing' => false,
							'color'          => false
						),
					),
					'font-subheaders-weights'    => array(
						'label' => esc_html__( 'Additonal weights', 'sana' ),
						'desc'  => esc_html__( 'Coma separates weights, for example: "600,800"', 'sana' ),
						'type'  => 'text',
						'value'  => $sana_theme_config['font_subheaders_weights'],						
					),							
				),
			),
			'fontello-box' => array(
				'title'   => esc_html__( 'Fontello', 'sana' ),
				'type'    => 'tab',
				'options' => array(
					'fontello-css'    => array(
						'label' => esc_html__( 'Fontello Codes CSS', 'sana' ),
						'desc'  => esc_html__( 'Upload *-codes.css postfix file here', 'sana' ),
						'type'  => 'upload',
						'images_only' => false,
					),		
					'fontello-ttf'    => array(
						'label' => esc_html__( 'Fontello TTF', 'sana' ),
						'type'  => 'upload',
						'images_only' => false,
					),							
					'fontello-eot'    => array(
						'label' => esc_html__( 'Fontello EOT', 'sana' ),
						'type'  => 'upload',
						'images_only' => false,
					),							
					'fontello-woff'    => array(
						'label' => esc_html__( 'Fontello WOFF', 'sana' ),
						'type'  => 'upload',
						'images_only' => false,
					),							
					'fontello-woff2'    => array(
						'label' => esc_html__( 'Fontello WOFF2', 'sana' ),
						'type'  => 'upload',
						'images_only' => false,
					),							
					'fontello-svg'    => array(
						'label' => esc_html__( 'Fontello SVG', 'sana' ),
						'type'  => 'upload',
						'images_only' => false,
					),												
				),
			),

		),
	),	
	'social' => array(
		'title'   => esc_html__( 'Social', 'sana' ),
		'type'    => 'tab',
		'options' => array(
			'social-box' => array(
				'title'   => esc_html__( 'Social', 'sana' ),
				'type'    => 'tab',
				'options' => array(
					'target-social'    => array(
						'label' => esc_html__( 'Open social links in', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'self'  => esc_html__( 'Same window', 'sana' ),
							'blank' => esc_html__( 'New window', 'sana' ),
						),
						'value' => 'self',
					),															
		            'social-icons' => array(
		                'label' => esc_html__( 'Social Icons', 'sana' ),
		                'type' => 'addable-box',
		                'value' => array(),
		                'desc' => esc_html__( 'Visible in inner page header', 'sana' ),
		                'box-options' => array(
		                    'icon_v2' => array(
		                        'label' => esc_html__( 'Icon', 'sana' ),
		                        'type'  => 'icon-v2',
		                    ),
		                    'text' => array(
		                        'label' => esc_html__( 'Text', 'sana' ),
		                        'desc' => esc_html__( 'If needed', 'sana' ),
		                        'type' => 'text',
		                    ),
		                    'href' => array(
		                        'label' => esc_html__( 'Link', 'sana' ),
		                        'type' => 'text',
		                        'value' => '#',
		                    ),		                    
		                ),
                		'template' => '{{- text }}',		                
                    ),								
				),
			),
		),
	),	
	'colors' => array(
		'title'   => esc_html__( 'Colors Schemes', 'sana' ),
		'type'    => 'tab',
		'options' => array(			
			'schemes-box' => array(
				'title'   => esc_html__( 'Additional Color Schemes Settings', 'sana' ),
				'type'    => 'box',
				'options' => array(
					'advice'    => array(
						'html' => esc_html__( 'You also need to change the global settings in Appearance -> Customize -> Sana settings', 'sana' ),
						'type'  => 'html',
					),	
					'items' => array(
						'label' => esc_html__( 'Theme Color Schemes', 'sana' ),
						'type' => 'addable-box',
						'value' => array(),
						'desc' => esc_html__( 'Can be selected in page settings', 'sana' ),
						'box-options' => array(
							'slug' => array(
								'label' => esc_html__( 'Scheme ID', 'sana' ),
								'type' => 'text',
								'desc' => esc_html__( 'Required Field', 'sana' ),
								'value' => '',
							),							
							'name' => array(
								'label' => esc_html__( 'Scheme Name', 'sana' ),
								'desc' => esc_html__( 'Required Field', 'sana' ),
								'type' => 'text',
								'value' => '',
							),
							'logo'    => array(
								'label' => esc_html__( 'Logo Black Background', 'sana' ),
								'type'  => 'upload',
							),
							'logo_white'    => array(
								'label' => esc_html__( 'Logo White Background', 'sana' ),
								'type'  => 'upload',
							),		
							'logo_2x'    => array(
								'label' => esc_html__( 'Logo Black Background 2x', 'sana' ),
								'type'  => 'upload',
							),
							'logo_white_2x'    => array(
								'label' => esc_html__( 'Logo White Background 2x', 'sana' ),
								'type'  => 'upload',
							),		
							'main-color'  => array(
								'label' => esc_html__( 'Main Color', 'sana' ),
								'type'  => 'color-picker',
							),
							'second-color' => array(
								'label' => esc_html__( 'Second Color', 'sana' ),
								'type'  => 'color-picker',
							),
							'gray-color' => array(
								'label' => esc_html__( 'Gray Color', 'sana' ),
								'type'  => 'color-picker',
							),								
							'black-color' => array(
								'label' => esc_html__( 'Black Color', 'sana' ),
								'type'  => 'color-picker',
							),	
							'white-color' => array(
								'label' => esc_html__( 'White Color', 'sana' ),
								'type'  => 'color-picker',
							),								
						),
						'template' => '{{- name }}',
					),
				),
			),
		),
	),	
	'popup' => array(
		'title'   => esc_html__( 'Popup', 'sana' ),
		'type'    => 'tab',
		'options' => array(
			'popup-box' => array(
				'title'   => esc_html__( 'Popup settings', 'sana' ),
				'type'    => 'box',
				'options' => array(						
					'popup-status'    => array(
						'label'   => esc_html__( 'Status', 'sana' ),
						'type'    => 'select',
						'choices' => array(
							'disabled' => esc_html__( 'Disabled', 'sana' ),
							'enabled'  => esc_html__( 'Enabled', 'sana' ),
						),
						'value' => 'disabled'
					),						
					'popup-hours'    => array(
						'label' => esc_html__( 'Period hidden, days', 'sana' ),
						'type'  => 'text',
						'value'	=>	'24',
					),						
					'popup-text'    => array(
						'label' => esc_html__( 'Popup text', 'sana' ),
						'type'  => 'wp-editor',
					),
					'popup-bg'    => array(
						'label' => esc_html__( 'Popup Background', 'sana' ),
						'type'  => 'upload',
					),					
					'popup-yes'    => array(
						'label' => esc_html__( 'Yes button', 'sana' ),
						'type'  => 'text',
						'value'	=>	'Yes',
					),	
					'popup-no'    => array(
						'label' => esc_html__( 'No button', 'sana' ),
						'type'  => 'text',
						'value'	=>	'No',
					),																
					'popup-no-link'    => array(
						'label' => esc_html__( 'No link', 'sana' ),
						'type'  => 'text',
						'value'	=>	'https://google.com',
					),																
				),	
			),
		),
	),
);

unset($options['colors']);
unset($options['popup']);
unset($options['header']['header-box-topbar']);
//unset($options['header']['options']['header-box-2']['options']['navbar-affix']);

if ( function_exists('ltx_share_buttons_conf') ) {

	$share_links = ltx_share_buttons_conf();

	$share_links_options = array();
	if ( !empty($share_links) ) {

		$share_links_options = array(

			'share_icons_hide' => array(
                'label' => esc_html__( 'Hide all share icons block', 'sana' ),
                'type'  => 'checkbox',
                'value'	=>	false,
            ),
		);
		foreach ( $share_links as $key => $item ) {

			$state = fw_get_db_settings_option( 'share_icon_' . $key );

			$value = false;
			if ( is_null($state) AND $item['active'] == 1 ) {

				$value = true;
			}

			$share_links_options[] =
			array(
				'share_icon_'.$key => array(
	                'label' => $item['header'],
	                'type'  => 'checkbox',
	                'value'	=>	$value,
	            ),
			);
		}
	}

	$share_links_options['share-add'] = array(

        'label' => esc_html__( 'Custom Share Buttons', 'sana' ),
        'type' => 'addable-box',
        'value' => array(),
        'desc' => esc_html__( 'You can use {link} and {title} variables to set url. E.g. "http://www.facebook.com/sharer.php?u={link}"', 'sana' ),
        'box-options' => array(
            'icon' => array(
                'label' => esc_html__( 'Icon', 'sana' ),
                'type'  => 'icon-v2',
            ),
            'header' => array(
                'label' => esc_html__( 'Header', 'sana' ),
                'type' => 'text',
            ),
            'link' => array(
                'label' => esc_html__( 'Link', 'sana' ),
                'type' => 'text',
                'value' => '',
            ),		  
            'color' => array(
                'label' => esc_html__( 'Color', 'sana' ),
                'type' => 'color-picker',
                'value' => '',
            ),		              
        ),
		'template' => '{{- header }}',		                
    );

	$options['social']['options']['share-box'] = array(
		'title'   => esc_html__( 'Share Buttons', 'sana' ),
		'type'    => 'tab',
		'options' => $share_links_options,
	);
}

