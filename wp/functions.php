<?php
    namespace papj;

    require_once get_template_directory() . '/inc/constants.php';

    function enqueue_styles() {
        $vue_css = '/assets/app/index.css';
        wp_enqueue_style( 'snrg-vue', get_template_directory_uri() . $vue_css, [], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $vue_css ) ) );
    }

    function enqueue_scripts() {
        $vue_js = '/assets/app/index.js';
        wp_enqueue_script( 'snrg-vue', get_template_directory_uri() . $vue_js, [], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $vue_js ) ), true );
    }

    add_action( 'wp_enqueue_scripts', 'snrg\enqueue_styles' );
    add_action( 'wp_enqueue_scripts', 'snrg\enqueue_scripts' );
?>