<?php
    // Remove all default WP template redirects/lookups
    //remove_action( 'template_redirect', 'redirect_canonical' );
    // Server-side URL routes
    //function pj_server_side_url_routes()
    //{   add_rewrite_rule( '(.?.+?)(?:/([0-9]+))?/?$', 'index.php?error=404', 'top' );
    //}
    require_once get_template_directory() . '/inc/constants.php';
    require_once get_template_directory() . '/inc/map.php';

    function pj_theme_support() {
        add_theme_support( 'custom-logo' );
    }
    add_action( 'after_setup_theme', 'pj_theme_support' );

    add_action( 'customize_register', 'pj_customize_register' );
    add_filter( 'pre_set_theme_mod_pj_map_id', 'pj_on_map_id_updated', 10, 2 );

    function pj_add_fonts() {
        wp_enqueue_style(
                'google-font-roboto-condensed',
                'https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,400;0,700;1,400;1,700&display=swap'
            );
    }
    add_action( 'wp_enqueue_scripts', 'pj_add_fonts' );

    function pj_add_vue_css() {
        $css = '/assets/app/index.css';
        wp_enqueue_style(
                'pj-vue',
                get_template_directory_uri() . $css,
                array(),
                date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $css ) )
            );
    }
    add_action( 'wp_enqueue_scripts', 'pj_add_vue_css' );

    function pj_add_vue_js() {
        $js = '/assets/app/index.js';
        wp_enqueue_script(
                'pj-vue',
                get_template_directory_uri() . $js,
                array(),
                date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $js ) )
            );
    }
    function pj_add_vue_js_html_attributes( $tag, $handle, $src ) {
        $prefix = 'pj-vue';
        if ( substr($handle, 0, strlen( $prefix ) ) === $prefix ) {
            return preg_replace( '/(type\s*=\s*["\']).*?(["\'])/', '$1module$2', $tag, 1 );
        }
        return $tag;
    }
    add_filter( 'script_loader_tag', 'pj_add_vue_js_html_attributes' , 10, 3 );
    add_action( 'wp_enqueue_scripts', 'pj_add_vue_js' );

    function pj_extend_rest_api() {
        register_rest_route( PJ_REST_ROUTE, PJ_LOGO_ROUTE, array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => function( $request ) {
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    if ( has_custom_logo() ) {
                        return rest_ensure_response( esc_url( wp_get_attachment_image_url( $custom_logo_id, 'full' ) ) );
                    } else {
                        return rest_ensure_response( esc_url( get_template_directory_uri() . PJ_DEFAULT_LOGO_PATH ) );
                    }
                },
                'permission_callback' => '__return_true'
            ) );
        register_rest_route( PJ_REST_ROUTE, PJ_MAP_TILES_ROUTE, array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => function( $request ) {
                    return rest_ensure_response( esc_url( get_template_directory_uri() ) . PJ_MAP_TILE_PATH );
                },
                'permission_callback' => '__return_true'
            ) );
    }
    add_action( 'rest_api_init', 'pj_extend_rest_api' );
?>