<?php

if ( ! function_exists( 'lte_enqueue_frontend_styles' ) ) {
    function lte_enqueue_frontend_styles() {
        wp_enqueue_style(
            'lte-custom',
            plugin_dir_url( __FILE__ ) . 'assets/lt-custom.css',
            array(),
            '1.0.0'
        );
    }
    add_action( 'wp_enqueue_scripts', 'lte_enqueue_frontend_styles' );
}

