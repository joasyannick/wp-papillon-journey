<?php
  namespace papj;

  require_once get_template_directory() . '/include/constants.php';

  function add_query_vars( $query_vars ) {
    $query_vars[] = 'route';
    return $query_vars;
  }

  add_filter( 'query_vars', 'papj\add_query_vars' );

  function add_rewrite_rules() {
    add_rewrite_rule( '^(updates/[^/]+)/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^.+/?$', 'index.php?route=404', 'top' );
  }

  add_action( 'init', 'papj\add_rewrite_rules' );

  function change_template_selection( $template ) {
    $route = get_query_var( 'route' );
    if ( $route ):
      if ( $route != '404' ):
        $matches = [];
        if ( preg_match( '@^updates/([^/]+)/?$@', $route, $matches ) ):
          if ( get_posts( [ 'name' => $matches[ 1 ], 'post_type' => UPDATE_POST_TYPE, 'post_status' => 'publish', 'posts_per_page' => 1 ] ) ):
            return locate_template( 'singular.php' );
          endif;
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

  function enqueue_styles() {
    $vue_css = '/assets/app/index.css';
    wp_enqueue_style( 'papj-vue', get_template_directory_uri() . $vue_css, [], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $vue_css ) ) );
  }

  function enqueue_scripts() {
    $vue_js = '/assets/app/index.js';
    wp_enqueue_script( 'papj-vue', get_template_directory_uri() . $vue_js, [], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $vue_js ) ), true );
  }

  add_action( 'wp_enqueue_scripts', 'papj\enqueue_styles' );
  add_action( 'wp_enqueue_scripts', 'papj\enqueue_scripts' );

  function register_post_types() {
    register_post_type(
        DEVOTIONAL_POST_TYPE, [
            'labels' => [
                'name' => __('Devotionals', DOMAIN ),
                'singular_name' => __( 'Devotional', DOMAIN ),
                'add_new' => __( 'Add New Devotional', DOMAIN ),
                'add_new_item' => __( 'Add New Devotional', DOMAIN ),
                'edit_item' => __( 'Edit Devotional', DOMAIN ),
                'new_item' => __( 'New Devotional', DOMAIN ),
                'view_item' => __( 'View Devotional', DOMAIN ),
                'view_items' => __( 'View Devotionals', DOMAIN ),
                'search_items' => __( 'Search Devotionals', DOMAIN ),
                'not_found' => __( 'No devotionals found', DOMAIN ),
                'not_found_in_trash' => __( 'No devotionals found in Trash', DOMAIN ),
                'all_items' => __( 'All Devotionals', DOMAIN ),
                'archives' => __( 'Devotional Archives', DOMAIN ),
                'attributes' => __( 'Devotional Attributes', DOMAIN ),
                'insert_into_item' => __( 'Insert into devotional', DOMAIN ),
                'uploaded_to_this_item' => __( 'Uploaded to this devotional', DOMAIN ),
                'filter_items_list' => __( 'Filter devotionals list', DOMAIN ),
                'items_list_navigation' => __( 'Devotionals list navigation', DOMAIN ),
                'items_list' => __( 'Devotionals list', DOMAIN ),
                'item_published' => __( 'Devotional published', DOMAIN ),
                'item_published_privately' => __( 'Devotional published privately', DOMAIN ),
                'item_reverted_to_draft' => __( 'Devotional reverted to draft', DOMAIN ),
                'item_trashed' => __( 'Devotional trashed', DOMAIN ),
                'item_scheduled' => __( 'Devotional scheduled', DOMAIN ),
                'item_updated' => __( 'Devotional updated', DOMAIN ),
                'item_link' => __( 'Devotional Link', DOMAIN ),
                'item_link_description' => __( 'A link to a devotional', DOMAIN ),
              ],
            'menu_icon' => 'dashicons-pressthis',
            'menu_position' => 20,
            'public' => true,
            'supports' => [ 'title', 'editor', 'thumbnail' ],
            'show_in_rest' => true,
            'rest_base' => DEVOTIONAL_IN_REST,
          ]
      );
    register_post_type(
        LANGUAGE_POST_TYPE, [
            'labels' => [
                'name' => __('Languages', DOMAIN ),
                'singular_name' => __( 'Language', DOMAIN ),
                'add_new' => __( 'Add New Language', DOMAIN ),
                'add_new_item' => __( 'Add New Language', DOMAIN ),
                'edit_item' => __( 'Edit Language', DOMAIN ),
                'new_item' => __( 'New Language', DOMAIN ),
                'view_item' => __( 'View Language', DOMAIN ),
                'view_items' => __( 'View Languages', DOMAIN ),
                'search_items' => __( 'Search Languages', DOMAIN ),
                'not_found' => __( 'No languages found', DOMAIN ),
                'not_found_in_trash' => __( 'No languages found in Trash', DOMAIN ),
                'all_items' => __( 'All Languages', DOMAIN ),
                'archives' => __( 'Language Archives', DOMAIN ),
                'attributes' => __( 'Language Attributes', DOMAIN ),
                'insert_into_item' => __( 'Insert into language', DOMAIN ),
                'uploaded_to_this_item' => __( 'Uploaded to this language', DOMAIN ),
                'filter_items_list' => __( 'Filter languages list', DOMAIN ),
                'items_list_navigation' => __( 'Languages list navigation', DOMAIN ),
                'items_list' => __( 'Languages list', DOMAIN ),
                'item_published' => __( 'Language published', DOMAIN ),
                'item_published_privately' => __( 'Language published privately', DOMAIN ),
                'item_reverted_to_draft' => __( 'Language reverted to draft', DOMAIN ),
                'item_trashed' => __( 'Language trashed', DOMAIN ),
                'item_scheduled' => __( 'Language scheduled', DOMAIN ),
                'item_updated' => __( 'Language updated', DOMAIN ),
                'item_link' => __( 'Language Link', DOMAIN ),
                'item_link_description' => __( 'A link to a language', DOMAIN ),
              ],
            'menu_icon' => 'dashicons-pressthis',
            'menu_position' => 20,
            'public' => true,
            'supports' => [ 'title', 'editor', 'thumbnail' ],
            'show_in_rest' => true,
            'rest_base' => LANGUAGE_IN_REST,
          ]
      );
    register_post_type(
        UPDATE_POST_TYPE, [
            'labels' => [
                'name' => __('Updates', DOMAIN ),
                'singular_name' => __( 'Update', DOMAIN ),
                'add_new' => __( 'Add New Update', DOMAIN ),
                'add_new_item' => __( 'Add New Update', DOMAIN ),
                'edit_item' => __( 'Edit Update', DOMAIN ),
                'new_item' => __( 'New Update', DOMAIN ),
                'view_item' => __( 'View Update', DOMAIN ),
                'view_items' => __( 'View Updates', DOMAIN ),
                'search_items' => __( 'Search Updates', DOMAIN ),
                'not_found' => __( 'No updates found', DOMAIN ),
                'not_found_in_trash' => __( 'No updates found in Trash', DOMAIN ),
                'all_items' => __( 'All Updates', DOMAIN ),
                'archives' => __( 'Update Archives', DOMAIN ),
                'attributes' => __( 'Update Attributes', DOMAIN ),
                'insert_into_item' => __( 'Insert into update', DOMAIN ),
                'uploaded_to_this_item' => __( 'Uploaded to this update', DOMAIN ),
                'filter_items_list' => __( 'Filter updates list', DOMAIN ),
                'items_list_navigation' => __( 'Updates list navigation', DOMAIN ),
                'items_list' => __( 'Updates list', DOMAIN ),
                'item_published' => __( 'Update published', DOMAIN ),
                'item_published_privately' => __( 'Update published privately', DOMAIN ),
                'item_reverted_to_draft' => __( 'Update reverted to draft', DOMAIN ),
                'item_trashed' => __( 'Update trashed', DOMAIN ),
                'item_scheduled' => __( 'Update scheduled', DOMAIN ),
                'item_updated' => __( 'Update updated', DOMAIN ),
                'item_link' => __( 'Update Link', DOMAIN ),
                'item_link_description' => __( 'A link to an update', DOMAIN ),
              ],
            'menu_icon' => 'dashicons-pressthis',
            'menu_position' => 20,
            'public' => true,
            'supports' => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
            'show_in_rest' => true,
            'rest_base' => UPDATE_IN_REST,
          ]
      );
  }
  
  add_action( 'init', 'papj\register_post_types' );
?>