<?php
  namespace papj;

  require_once get_template_directory() . '/inc/constants.php';

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
              'supports' => [ 'title', 'editor' ],
              'show_in_rest' => true,
              'rest_base' => UPDATE_IN_REST,
          ]
        );
    }
  
  add_action( 'init', 'papj\register_post_types' );
?>