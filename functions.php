<?php
    // Remove all default WP template redirects/lookups
    //remove_action( 'template_redirect', 'redirect_canonical' );
    // Server-side URL routes
    function pj_server_side_url_routes()
    {   add_rewrite_rule( '(.?.+?)(?:/([0-9]+))?/?$', 'index.php?error=404', 'top' );
    }
    // Fonts
    function pj_fonts()
    {   wp_enqueue_style
        (   'google-font-alegreya',
            'https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        );
        wp_enqueue_style
        (   'google-font-alegreya-sans',
            'https://fonts.googleapis.com/css2?family=Alegreya+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        );
        wp_enqueue_style
        (   'google-font-courier-prime',
            'https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        );
        wp_enqueue_style
        (   'google-font-lato',
            'https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        );
        wp_enqueue_style
        (   'google-font-work-sans',
            'https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap',
        );
    }
    add_action( 'wp_enqueue_scripts', 'pj_fonts' );
    // CSS
    function pj_css()
    {   wp_enqueue_style
        (   'pj-css',
            get_template_directory_uri() . '/dist/style.css',
            array(),
            strval( filemtime( get_template_directory_uri() . '/dist/styles.css' ) )
        );
    }
    add_action( 'wp_enqueue_scripts', 'pj_css' );
    // JS
    function pj_js()
    {   wp_enqueue_script
        (   'pj-js',
            get_template_directory_uri() . '/dist/scripts/index.js',
            array(),
            strval( filemtime( get_template_directory_uri() . '/dist/scripts/index.js' ) ),
            true
        );
    }
    add_action( 'wp_enqueue_scripts', 'pj_js' );
?>