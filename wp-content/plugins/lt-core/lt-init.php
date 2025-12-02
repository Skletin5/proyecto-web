<?php

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}


if ( function_exists( 'is_plugin_active' ) AND is_plugin_active('lte-ext/lte-ext.php') ) {

	if (lte_is_hooked_lte_init_static_core()) add_action('wp_enqueue_scripts', 'lte_init_static', 5 );
	add_action('wp_enqueue_scripts', 'lte_init_custom_core', 5 );

	function lte_init_custom_core() {
		
		wp_deregister_style ('swiper');
		if ( file_exists(lteGetLocalPath('/assets/css/swiper.css')) ) wp_enqueue_style( 'swiper', lteGetPluginUrl('assets/css/swiper.css'), array(), '1.1.0' );
	}

}
	else {

	add_action('wp_enqueue_scripts', 'ltx_init_custom_core', 19 );
    if ( !function_exists('ltx_init_custom_core')) {

		function ltx_init_custom_core() {
			
			wp_enqueue_style( 'vc_font_awesome_6' );
			wp_deregister_script ('swiper');
		}
    }
}


if (!function_exists('lte_remove_old_unyson_plugins')) {
    function lte_remove_old_unyson_plugins() {
        $old_plugins = [
            'unyson/unyson.php',
            'unyson-fork/unyson-fork.php',
            'unyson/unyson-fork.php',
            'unyson-fork/unyson.php'
        ];

        foreach ($old_plugins as $plugin) {
            if (file_exists(WP_PLUGIN_DIR . '/' . $plugin)) {
                if (is_plugin_active($plugin)) {
                    deactivate_plugins($plugin);
                }
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
                delete_plugins([$plugin]);
            }
        }
    }

    register_activation_hook(__FILE__, 'lte_remove_old_unyson_plugins');
}


add_action( 'init', function() {

    if ( isset( $GLOBALS['tgmpa'] ) && ! empty( $GLOBALS['tgmpa']->plugins ) ) {

    	$found = false;

        foreach ( $GLOBALS['tgmpa']->plugins as $key => $plugin ) {
            if ( isset( $plugin['slug'] ) && 'unyson' === $plugin['slug'] ) {
                unset( $GLOBALS['tgmpa']->plugins[ $key ] );
                $found = true;
            }

            if ( isset( $plugin['slug'] ) && 'unyson-fork' === $plugin['slug'] ) {
                unset( $GLOBALS['tgmpa']->plugins[ $key ] );
                $found = true;
            }
        }

        if ( !empty($found) ) {

	        $GLOBALS['tgmpa']->plugins['lt-core'] = array(
	            'name'      => 'LT Core',
	            'slug'      => 'lt-core',
	            'source'    => 'http://updates.like-themes.com/plugins/lt-core/lt-core.zip',
	            'required'  => true,
	            'file_path'  => 'lt-core/lt-core.php',
	            'version'  => '',
	            'force_activation'  => '',
	            'source_type'  => '',
	        );        
	        
        }
    }
}, 100 );
	

// Plugin migration
add_action( 'shutdown', function() {
    $old_path = WP_PLUGIN_DIR . '/unyson';
    $new_path = WP_PLUGIN_DIR . '/lt-core';
    $old_plugin = 'unyson/lt-core.php';
    $new_plugin = 'lt-core/lt-core.php';

    if ( get_option( 'lte_plugin_migrated' ) ) {
//        return;
    }

    if ( ! is_dir( $old_path ) || is_dir( $new_path ) ) {
        return;
    }

    if ( is_plugin_active( $old_plugin ) ) {
        deactivate_plugins( $old_plugin );
    }

    if ( rename( $old_path, $new_path ) ) {
        wp_cache_flush();
        update_option( 'lte_plugin_migrated', 1 );
        activate_plugin( $new_plugin );
    }
});


add_action( 'init', function() {

	if ( !function_exists('lte_plugin_is_active') ) {

		function lte_plugin_is_active($plugin) {

			return ltx_plugin_is_active($plugin);
		}
	}
});

if ( !function_exists('lte_admin_css') ) {

	function lte_admin_css() {
		
		if ( is_admin() ) {

			wp_enqueue_style( 'lte-admin', plugin_dir_url( __FILE__ ) . 'framework/static/css/admin.css', array(), '1.0' );
		}
	}
	add_action( 'admin_enqueue_scripts', 'lte_admin_css' );
}



function lte_is_hooked_lte_init_static_core() {
    global $wp_filter;

    $hook = 'wp_enqueue_scripts';
    $target_function = 'lte_init_static';

    if (!isset($wp_filter[$hook])) {
        return false;
    }

    foreach ($wp_filter[$hook]->callbacks as $priority => $callbacks) {
        foreach ($callbacks as $key => $callback) {
            if ($callback['function'] === $target_function) {
                return true;
            }
        }
    }

    return false;
}
