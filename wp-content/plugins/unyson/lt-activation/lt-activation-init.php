<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'LT_ACTIVATION_DIR' ) ) {
	define( 'LT_ACTIVATION_DIR', __DIR__ . '/' );
}

spl_autoload_register( function ( $class ) {
	if ( strpos( $class, 'LT_Activation_' ) !== 0 ) {
		return;
	}
	$path = LT_ACTIVATION_DIR . 'includes/' . 'class-' . strtolower( str_replace( '_', '-', $class ) ) . '.php';
	if ( file_exists( $path ) ) {
		require_once $path;
	}
} );

add_action( 'plugins_loaded', function () {
	// Admin UI
	if ( is_admin() ) {
		new LT_Activation_Admin();
	}
} );