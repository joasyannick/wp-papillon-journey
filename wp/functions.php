<?php
    // Remove all default WP template redirects/lookups
    //remove_action( 'template_redirect', 'redirect_canonical' );
    // Server-side URL routes
    //function papj_server_side_url_routes()
    //{   add_rewrite_rule( '(.?.+?)(?:/([0-9]+))?/?$', 'index.php?error=404', 'top' );
    //}
    require_once get_template_directory() . '/inc/constants.php';
    require_once get_template_directory() . '/inc/map.php';

    function papj_theme_support() {
        add_theme_support( 'custom-logo' );
    }

    add_action( 'after_setup_theme', 'papj_theme_support' );

    add_action( 'customize_register', 'papj_customize_register' );
    add_filter( 'pre_set_theme_mod_' . PAPJ_MAP_ID_SETTING, 'papj_on_map_id_updated', 10, 2 );

    function papj_add_fonts() {
        wp_enqueue_style(
                'google-font-dm-serif-display',
                'https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap'
            );
        wp_enqueue_style(
                'google-font-quicksand',
                'https://fonts.googleapis.com/css2?family=Quicksand&display=swap'
            );
    }
    add_action( 'wp_enqueue_scripts', 'papj_add_fonts' );

    function papj_add_vue_css() {
        $css = '/assets/app/index.css';
        wp_enqueue_style(
                'pj-vue',
                get_template_directory_uri() . $css,
                array(),
                date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $css ) )
            );
    }

    add_action( 'wp_enqueue_scripts', 'papj_add_vue_css' );

    function papj_add_vue_js() {
        $js = '/assets/app/index.js';
        wp_enqueue_script(
                'pj-vue',
                get_template_directory_uri() . $js,
                array(),
                date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $js ) )
            );
    }

    function papj_add_vue_js_html_attributes( $tag, $handle, $src ) {
        $prefix = 'pj-vue';
        if ( substr($handle, 0, strlen( $prefix ) ) === $prefix ):
            return preg_replace( '/(type\s*=\s*["\']).*?(["\'])/', '$1module$2', $tag, 1 );
        endif;
        return $tag;
    }

    add_filter( 'script_loader_tag', 'papj_add_vue_js_html_attributes' , 10, 3 );
    add_action( 'wp_enqueue_scripts', 'papj_add_vue_js' );

    function papj_extend_rest_api() {
        register_rest_route( PAPJ_REST_ROUTE, PAPJ_WELCOME_IMAGE_ROUTE, array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => function( $request ) {
                    return rest_ensure_response( esc_url( get_template_directory_uri() ) . PAPJ_WELCOME_IMAGE_PATH );
                },
                'permission_callback' => '__return_true'
            ) );
        register_rest_route( PAPJ_REST_ROUTE, PAPJ_MAP_TILES_ROUTE, array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => function( $request ) {
                    if ( PAPJ_DEFAULT_MAP_ID === get_theme_mod( PAPJ_MAP_ID_SETTING, PAPJ_DEFAULT_MAP_ID ) ):
                        return rest_ensure_response( esc_url( get_template_directory_uri() ) . PAPJ_DEFAULT_MAP_TILE_PATH );
                    endif;
                    return rest_ensure_response( esc_url( get_template_directory_uri() ) . PAPJ_MAP_TILE_PATH );
                },
                'permission_callback' => '__return_true'
            ) );
    }

    add_action( 'rest_api_init', 'papj_extend_rest_api' );
?>