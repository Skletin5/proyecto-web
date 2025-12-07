<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Theme Configuration and Custom CSS initializtion
 */

/**
 * Global theme config for header/footer/sections/colors/fonts
 */
if ( !function_exists('sana_theme_config') ) {

	add_filter( 'ltx_get_theme_config', 'sana_theme_config', 10, 1 );
	function sana_theme_config() {

	    return array(
	    	'navbar'	=>	array(
				'white'  	=> esc_html__( 'Default. White Background', 'sana' ),
				'transparent'  => esc_html__( 'Transparent for Dark Homepage Slider', 'sana' ),		
				'transparent-white'  => esc_html__( 'Transparent for White Homepage Slider', 'sana' ),		
				'desktop-center'  => esc_html__( 'Logo at the Center', 'sana' ),		
				'desktop-center-black'  => esc_html__( 'Logo at the Center Black', 'sana' ),		
				'hamburger'  => esc_html__( 'Desktop with Hamburger', 'sana' ),		
				'full-width'  => esc_html__( 'Full-Width with Hamburger', 'sana' ),		
			),
			'navbar-default' => 'white',

			'footer' => array(
				'default'  => esc_html__( 'Default', 'sana' ),		
				'copyright'  => esc_html__( 'Copyright Only', 'sana' ),		
				'copyright-transparent'  => esc_html__( 'Copyright Transparent', 'sana' ),		
			),
			'footer-default' => 'default',

			'color_main'	=>	'#DFBA9F',
			'color_black'	=>	'#141414',
			'color_gray'	=>	'#F9F1EC',
			'color_white'	=>	'#FFFFFF',
			'color_red'		=>	'#FF7366',
			'color_main_header'	=>	esc_html__( 'Coral', 'sana' ),


			'font_main'					=>	'Ubuntu',
			'font_main_var'				=>	'regular',
			'font_main_weights'			=>	'400,500,700,700i',
			'font_headers'				=>	'Prata',
			'font_headers_var'			=>	'regular',
			'font_headers_weights'		=>	'',
			'font_subheaders'			=>	'Mrs+Saint+Delafiel',
			'font_subheaders_var'		=>	'regular',
			'font_subheaders_weights'	=>	'',
		);
	}
}

/**
 *  Color Palette
 */
function sana_palette() {

	$cfg = sana_theme_config();

    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => esc_html__( 'Main', 'sana' ),
            'slug' => 'main-theme',
            'color' => $cfg['color_main'],
        ),
        array(
            'name' => esc_html__( 'Gray', 'sana' ),
            'slug' => 'gray',
            'color' => $cfg['color_gray'],
        ),
        array(
            'name' => esc_html__( 'Black', 'sana' ),
            'slug' => 'black',
            'color' => $cfg['color_black'],
        ),
        array(
            'name' => esc_html__( 'Red', 'sana' ),
            'slug' => 'red',
            'color' => $cfg['color_red'],
        ),        
    ) );
}
add_action( 'after_setup_theme', 'sana_palette', 10 );


/**
 * Get Google default font url
 */
if ( !function_exists('sana_font_url') ) {

	function sana_font_url() {

		$cfg = sana_theme_config();
		$q = array();
		foreach ( array('font_main', 'font_headers', 'font_subheaders') as $item ) {

			if ( !empty($cfg[$item]) ) {

				$w = '';
				if ( !empty($cfg[$item.'_weights']) ) {

					$w .= ':'.$cfg[$item.'_weights'];
				}
				$q[] = $cfg[$item].$w;
			}
		}

		$query_args = array( 'family' => implode('|', $q), 'subset' => 'latin' );
		$font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		return esc_url( $font_url );
	}
}

/**
 * Config used for lt-ext plugin to set Visual Composer configuration
 */
if ( !function_exists('sana_vc_config') ) {

	add_filter( 'ltx_get_vc_config', 'sana_vc_config', 10, 1 );
	function sana_vc_config( $value ) {

	    return array(
	    	'sections'	=>	array(
				esc_html__("Displaced floating section", 'sana') 		=> "displaced-top",				
				esc_html__("Collection", 'sana') 		=> "ltx-collection",				
				esc_html__("Services with Parallax", 'sana') 		=> "ltx-serv-parallax",
				esc_html__("Services Makeup", 'sana') 		=> "ltx-serv-makeup",
				esc_html__("Services Grid", 'sana') 		=> "ltx-serv-grid",
			),
			'background' => array(
				esc_html__( "Main Color", 'sana' ) => "theme_color",	
				esc_html__( "Gray", 'sana' ) => "gray",
				esc_html__( "White", 'sana' ) => "white",
				esc_html__( "Black", 'sana' ) => "black",			
			),
			'overlay'	=> array(
				esc_html__( "Black Overlay (60%)", 'sana' ) => "black",
				esc_html__( "Dark Overlay (75%)", 'sana' ) => "dark",
				esc_html__( "White Overlay", 'sana' ) => "white",
			),
		);
	}
}


/*
* Adding additional TinyMCE options
*/
if ( !function_exists('sana_mce_before_init_insert_formats') ) {

	add_filter('mce_buttons_2', 'sana_wpb_mce_buttons_2');
	function sana_wpb_mce_buttons_2( $buttons ) {

	    array_unshift($buttons, 'styleselect');
	    return $buttons;
	}

	add_filter( 'tiny_mce_before_init', 'sana_mce_before_init_insert_formats' );
	function sana_mce_before_init_insert_formats( $init_array ) {  

	    $style_formats = array(

	        array(  
	            'title' => esc_html__('Main Color', 'sana'),
	            'block' => 'span',  
	            'classes' => 'color-main',
	            'wrapper' => true,
	        ),  
	        array(  
	            'title' => esc_html__('White Color', 'sana'),
	            'block' => 'span',  
	            'classes' => 'color-white',
	            'wrapper' => true,   
	        ),
	        array(  
	            'title' => esc_html__('Large Text', 'sana'),
	            'block' => 'span',  
	            'classes' => 'text-lg',
	            'wrapper' => true,
	        ),    
	        array(  
	            'title' => 'List Checkbox',
	            'selector' => 'ul',
	            'classes' => 'check',
	        ),       
	        array(  
	            'title' => 'Read More Link',
	            'selector' => 'a',
	            'classes' => 'more-link',
	        ),    	           
	    );  
	    $init_array['style_formats'] = json_encode( $style_formats );  
	     
	    return $init_array;  
	} 
}


/**
 * Register widget areas.
 *
 */
if ( !function_exists('sana_action_theme_widgets_init') ) {

	add_action( 'widgets_init', 'sana_action_theme_widgets_init' );
	function sana_action_theme_widgets_init() {

		$span_class = 'widget-icon';

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar Default', 'sana' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Displayed in the right/left section of the site.', 'sana' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="header-widget">',
			'after_title'   => '<span class="'.esc_attr($span_class).'"></span></h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar WooCommerce', 'sana' ),
			'id'            => 'sidebar-wc',
			'description'   => esc_html__( 'Displayed in the right/left section of the site.', 'sana' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="header-widget">',
			'after_title'   => '<span class="'.esc_attr($span_class).'"></span></h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 1', 'sana' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Displayed in the footer section of the site.', 'sana' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="header-widget">',
			'after_title'   => '<span class="'.esc_attr($span_class).'"></span></h3>',
		) );			

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 2', 'sana' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Displayed in the footer section of the site.', 'sana' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="header-widget">',
			'after_title'   => '<span class="'.esc_attr($span_class).'"></span></h3>',
		) );			

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 3', 'sana' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Displayed in the footer section of the site.', 'sana' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="header-widget">',
			'after_title'   => '<span class="'.esc_attr($span_class).'"></span></h3>',
		) );			

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 4', 'sana' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Displayed in the footer section of the site.', 'sana' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="header-widget">',
			'after_title'   => '<span class="'.esc_attr($span_class).'"></span></h3>',
		) );			

	}
}



/**
 * Additional styles init
 */
if ( !function_exists('sana_css_style') ) {

	add_action( 'wp_enqueue_scripts', 'sana_css_style', 10 );
	function sana_css_style() {

		global $wp_query;

		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap-grid.css', array(), '1.0' );

		wp_enqueue_style( 'sana-plugins-css', get_template_directory_uri() . '/assets/css/plugins.css', array(), wp_get_theme()->get('Version') );

		wp_enqueue_style( 'sana-theme-style', get_stylesheet_uri(), array( 'bootstrap', 'sana-plugins-css' ), wp_get_theme()->get('Version') );
	}
}


/**
 * Wp-admin styles and scripts
 */
if ( !function_exists('sana_admin_init') ) {

	add_action( 'after_setup_theme', 'sana_admin_init' );
	function sana_admin_init() {

		add_action("admin_enqueue_scripts", 'sana_admin_scripts');
	}

	function sana_admin_scripts() {

		if ( function_exists('fw_get_db_settings_option') ) {

			if ( !empty($local_fonts ) ) {

				$fontello['css'] = fw_get_db_settings_option( 'fontello-css' );
				$fontello['eot'] = fw_get_db_settings_option( 'fontello-eot' );
				$fontello['ttf'] = fw_get_db_settings_option( 'fontello-ttf' );
				$fontello['woff'] = fw_get_db_settings_option( 'fontello-woff' );
				$fontello['woff2'] = fw_get_db_settings_option( 'fontello-woff2' );
				$fontello['svg'] = fw_get_db_settings_option( 'fontello-svg' );
			}
				else {

				$fontello['css']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-sana-codes.css';
				$fontello['eot']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-sana.eot';
				$fontello['ttf']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-sana.ttf';
				$fontello['woff']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-sana.woff';
				$fontello['woff2']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-sana.woff2';
				$fontello['svg']['url'] = get_template_directory_uri() . '/assets/fontello/ltx-sana.svg';			
			}

			if ( !empty($fontello['css']) AND !empty( $fontello['eot']) AND  !empty( $fontello['ttf']) AND  !empty( $fontello['woff']) AND  !empty( $fontello['woff2']) AND  !empty( $fontello['svg']) ) {

				wp_enqueue_style(  'sana-fontello',  $fontello['css']['url'], array(), wp_get_theme()->get('Version') );

				$randomver = wp_get_theme()->get('Version');
				$css_content = "@font-face {
				font-family: 'sana-fontello';
				  src: url('". esc_url ( $fontello['eot']['url']. "?" . $randomver )."');
				  src: url('". esc_url ( $fontello['eot']['url']. "?" . $randomver )."#iefix') format('embedded-opentype'),
				       url('". esc_url ( $fontello['woff2']['url']. "?" . $randomver )."') format('woff2'),
				       url('". esc_url ( $fontello['woff']['url']. "?" . $randomver )."') format('woff'),
				       url('". esc_url ( $fontello['ttf']['url']. "?" . $randomver )."') format('truetype'),
				       url('". esc_url ( $fontello['svg']['url']. "?" . $randomver )."#" . pathinfo(wp_basename( $fontello['svg']['url'] ), PATHINFO_FILENAME)  . "') format('svg');
				  font-weight: normal;
				  font-style: normal;
				}";

				wp_add_inline_style( 'sana-fontello', $css_content );
			}

			wp_enqueue_script( 'sana-theme-admin', get_template_directory_uri() . '/assets/js/scripts-admin.js', array( 'jquery' ) );
		}
	}
}




