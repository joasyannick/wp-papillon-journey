<?php
    // Remove all default WP template redirects/lookups
    //remove_action( 'template_redirect', 'redirect_canonical' );
    // Server-side URL routes
    //function pj_server_side_url_routes()
    //{   add_rewrite_rule( '(.?.+?)(?:/([0-9]+))?/?$', 'index.php?error=404', 'top' );
    //}

    function pj_add_fonts()
    {   wp_enqueue_style
        (   'google-font-roboto-condensed',
            'https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        );
    }
    add_action( 'wp_enqueue_scripts', 'pj_add_fonts' );

    function pj_add_vue_css()
    {   wp_enqueue_style
        (   'pj-vue',
            get_template_directory_uri() . '/dist/assets/index-eb320d53.css',
            array(),
            date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . '/dist/assets/index-eb320d53.css' ) )
        );
    }
    add_action( 'wp_enqueue_scripts', 'pj_add_vue_css' );

    function pj_add_vue_js()
    {   wp_enqueue_script
        (   'pj-vue',
            get_template_directory_uri() . '/dist/assets/index-fb58434f.js',
            array(),
            date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . '/dist/assets/index-fb58434f.js' ) )
        );
    }
    function pj_add_vue_js_html_attributes( $tag, $handle, $src )
    {   if ( 'pj-vue' !== $handle ) {
            return $tag;
        }
        return preg_replace( '/(type\s*=\s*["\']).*?(["\'])/', '$1module$2', $tag, 1 );
    }
    add_filter( 'script_loader_tag', 'pj_add_vue_js_html_attributes' , 10, 3 );
    add_action( 'wp_enqueue_scripts', 'pj_add_vue_js' );
?>