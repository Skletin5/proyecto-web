<?php
/**
 * Theme functions file
 */

/**
 * Enqueue parent theme styles first
 * Replaces previous method using @import
 * <http://codex.wordpress.org/Child_Themes>
 */

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style', 11 );

function enqueue_parent_theme_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
	
	wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' ),
        wp_get_theme()->get('Version')
    );
}

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_inline_style', 99 );
function enqueue_parent_theme_inline_style() {
	
	if ( function_exists( 'fw' ) ) {
		wp_add_inline_style( 'parent-style', sana_generate_css() );
	}
}

/**
 * Add your custom functions below
 */
