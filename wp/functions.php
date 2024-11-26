<?php
  namespace papj;

  require_once get_template_directory() . '/inc/constants.php';



  //-----------
  // CSS AND JS
  //-----------


  function enqueue_styles() {
    $styles = [ '/assets/css/papillon-journey.css', '/assets/css/index.css' ];
    wp_enqueue_style( 'papj-css-1', get_template_directory_uri() . $styles[ 0 ], [], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $styles[ 0 ] ) ) );
    //wp_enqueue_style( 'papj-css-2', get_template_directory_uri() . $styles[ 1 ], [ 'papj-css-1' ], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $styles[ 1 ] ) ) );
  }

  function enqueue_scripts() {
    $script = '/assets/js/index.js';
    wp_enqueue_script( 'papj-js', get_template_directory_uri() . $script, [], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $script ) ), true );
  }

  add_action( 'wp_enqueue_scripts', 'papj\enqueue_styles' );
  add_action( 'wp_enqueue_scripts', 'papj\enqueue_scripts' );

  function add_vue_js_html_attributes( $tag, $handle, $src ) {
    $prefix = 'papj-js';
    if ( substr($handle, 0, strlen( $prefix ) ) === $prefix ) {
      return preg_replace( '/(type\s*=\s*["\']).*?(["\'])/', '$1module$2', $tag, 1 );
    }
    return $tag;
  }

  add_filter( 'script_loader_tag', 'papj\add_vue_js_html_attributes' , 10, 3 );



  //--------
  // ROUTING
  //--------


  function add_query_vars( $query_vars ) {
    $query_vars[] = 'route';
    return $query_vars;
  }

  add_filter( 'query_vars', 'papj\add_query_vars' );

  function add_rewrite_rules() {
    add_rewrite_rule( '^(' . EN_LANGUAGE . ')/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^(' . EN_LANGUAGE . '/' . DEV_PATH . '/[^/]+)/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^(' . FR_LANGUAGE . ')/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^(' . FR_LANGUAGE . '/' . DEV_PATH . '/[^/]+)/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^.+/?$', 'index.php?route=' . ERROR_PATH, 'top' );
  }

  add_action( 'init', 'papj\add_rewrite_rules' );

  function change_template_selection( $template ) {
    $route = get_query_var( 'route' );
    if ( $route ):
      if ( ERROR_PATH !== $route ):
        $matches = [];
        if ( EN_LANGUAGE === $route || FR_LANGUAGE === $route ):
          return locate_template( 'index.php' );
        endif;
        if ( ( preg_match( '@^' . EN_LANGUAGE . '/' . DEV_PATH . '/([^/]+)/?$@', $route, $matches ) ) &&
            get_posts( [ 'name' => $matches[ 1 ], 'post_type' => [ KNOW_HOW_POST_TYPE, RELEASE_POST_TYPE ], 'post_status' => 'publish', 'posts_per_page' => 1, 'meta_query' => [ [ 'key' => LANGUAGE_KEY, 'value' => EN_LANGUAGE, 'compare' => '=' ] ] ] ) ):
          return locate_template( 'singular.php' );
        endif;
        if ( ( preg_match( '@^' . FR_LANGUAGE . '/' . DEV_PATH . '/([^/]+)/?$@', $route, $matches ) ) &&
            get_posts( [ 'name' => $matches[ 1 ], 'post_type' => [ KNOW_HOW_POST_TYPE, RELEASE_POST_TYPE ], 'post_status' => 'publish', 'posts_per_page' => 1, 'meta_query' => [ [ 'key' => LANGUAGE_KEY, 'value' => FR_LANGUAGE, 'compare' => '=' ] ] ] ) ):
          return locate_template( 'singular.php' );
        endif;
      endif;
      global $wp_query;
      $wp_query->set_404();
      status_header( 404 );
      $template = locate_template( '404.php' );
    endif;
    return $template;
  }

  add_filter( 'template_include', 'papj\change_template_selection' );



  //-----------
  // POST TYPES
  //-----------


  function register_post_types() {
    register_post_type( KNOW_HOW_POST_TYPE, [
        'labels' => [
            'name' => __('Know-Hows', DOMAIN ),
            'singular_name' => __( 'Know-How', DOMAIN ),
            'add_new' => __( 'Add New Know-How', DOMAIN ),
            'add_new_item' => __( 'Add New Know-How', DOMAIN ),
            'edit_item' => __( 'Edit Know-How', DOMAIN ),
            'new_item' => __( 'New Know-How', DOMAIN ),
            'view_item' => __( 'View Know-How', DOMAIN ),
            'view_items' => __( 'View Know-Hows', DOMAIN ),
            'search_items' => __( 'Search Know-Hows', DOMAIN ),
            'not_found' => __( 'No know-hows found', DOMAIN ),
            'not_found_in_trash' => __( 'No know-hows found in Trash', DOMAIN ),
            'all_items' => __( 'All Know-Hows', DOMAIN ),
            'archives' => __( 'Know-How Archives', DOMAIN ),
            'attributes' => __( 'Know-How Attributes', DOMAIN ),
            'insert_into_item' => __( 'Insert into know-how', DOMAIN ),
            'uploaded_to_this_item' => __( 'Uploaded to this know-how', DOMAIN ),
            'filter_items_list' => __( 'Filter know-hows list', DOMAIN ),
            'items_list_navigation' => __( 'Know-hows list navigation', DOMAIN ),
            'items_list' => __( 'Know-hows list', DOMAIN ),
            'item_published' => __( 'Know-how published', DOMAIN ),
            'item_published_privately' => __( 'Know-how published privately', DOMAIN ),
            'item_reverted_to_draft' => __( 'Know-how reverted to draft', DOMAIN ),
            'item_trashed' => __( 'Know-how trashed', DOMAIN ),
            'item_scheduled' => __( 'Know-how scheduled', DOMAIN ),
            'item_updated' => __( 'Know-how updated', DOMAIN ),
            'item_link' => __( 'Know-how Link', DOMAIN ),
            'item_link_description' => __( 'A link to a know-how', DOMAIN ),
          ],
        'menu_icon' => 'dashicons-testimonial',
        'menu_position' => 20,
        'public' => true,
        'supports' => [ 'title', 'editor' ],
        'show_in_rest' => true,
        'rest_base' => KNOW_HOW_IN_REST,
      ] );
    register_post_type( RELEASE_POST_TYPE, [
        'labels' => [
            'name' => __('Releases', DOMAIN ),
            'singular_name' => __( 'Release', DOMAIN ),
            'add_new' => __( 'Add New Release', DOMAIN ),
            'add_new_item' => __( 'Add New Release', DOMAIN ),
            'edit_item' => __( 'Edit Release', DOMAIN ),
            'new_item' => __( 'New Release', DOMAIN ),
            'view_item' => __( 'View Release', DOMAIN ),
            'view_items' => __( 'View Releases', DOMAIN ),
            'search_items' => __( 'Search Releases', DOMAIN ),
            'not_found' => __( 'No releases found', DOMAIN ),
            'not_found_in_trash' => __( 'No releases found in Trash', DOMAIN ),
            'all_items' => __( 'All Releases', DOMAIN ),
            'archives' => __( 'Releas Archives', DOMAIN ),
            'attributes' => __( 'Releas Attributes', DOMAIN ),
            'insert_into_item' => __( 'Insert into release', DOMAIN ),
            'uploaded_to_this_item' => __( 'Uploaded to this release', DOMAIN ),
            'filter_items_list' => __( 'Filter releases list', DOMAIN ),
            'items_list_navigation' => __( 'Releases list navigation', DOMAIN ),
            'items_list' => __( 'Releases list', DOMAIN ),
            'item_published' => __( 'Release published', DOMAIN ),
            'item_published_privately' => __( 'Release published privately', DOMAIN ),
            'item_reverted_to_draft' => __( 'Release reverted to draft', DOMAIN ),
            'item_trashed' => __( 'Release trashed', DOMAIN ),
            'item_scheduled' => __( 'Release scheduled', DOMAIN ),
            'item_updated' => __( 'Release updated', DOMAIN ),
            'item_link' => __( 'Release Link', DOMAIN ),
            'item_link_description' => __( 'A link to a release', DOMAIN ),
          ],
        'menu_icon' => 'dashicons-beer',
        'menu_position' => 20,
        'public' => true,
        'supports' => [ 'title', 'editor' ],
        'show_in_rest' => true,
        'rest_base' => RELEASE_IN_REST,
      ] );
  }

  add_action( 'init', 'papj\register_post_types' );
?>