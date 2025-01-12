<?php
  namespace papj;

  require_once get_template_directory() . '/inc/constants.php';



  //-----------
  // CSS AND JS
  //-----------


  // Enqueue theme styles
  function enqueue_styles() {
    $styles = [ '/assets/css/papillon-journey.css', '/assets/css/index.css' ];
    wp_enqueue_style( 'papj-css-1', get_template_directory_uri() . $styles[ 0 ], [], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $styles[ 0 ] ) ) );
    //wp_enqueue_style( 'papj-css-2', get_template_directory_uri() . $styles[ 1 ], [ 'papj-css-1' ], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $styles[ 1 ] ) ) );
  }

  // Enqueue theme scripts
  function enqueue_scripts() {
    $script = '/assets/js/index.js';
    wp_enqueue_script( 'papj-js', get_template_directory_uri() . $script, [], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $script ) ), true );
  }

  add_action( 'wp_enqueue_scripts', 'papj\enqueue_styles' );
  add_action( 'wp_enqueue_scripts', 'papj\enqueue_scripts' );

  // Add the type="module" attribute to the script whose handle is papj-js for compatibility with ES6 modules
  function add_vue_js_html_attributes( $tag, $handle, $src ) {
    $prefix = 'papj-js';
    if ( substr( $handle, 0, strlen( $prefix ) ) === $prefix ):
      return preg_replace( '/(type\s*=\s*["\']).*?(["\'])/', '$1module$2', $tag, 1 );
    endif;
    return $tag;
  }

  add_filter( 'script_loader_tag', 'papj\add_vue_js_html_attributes' , 10, 3 );



  //--------
  // ROUTING
  //--------


  // Add the route query var
  function add_query_vars( $query_vars ) {
    $query_vars[] = 'route';
    return $query_vars;
  }

  add_filter( 'query_vars', 'papj\add_query_vars' );

  // Custom rewrite rules
  function add_rewrite_rules() {
    add_rewrite_rule( '^(' . EN_LANGUAGE . ')/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^(' . EN_LANGUAGE . '/' . DEV_PATH . '/[^/]+)/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^(' . FR_LANGUAGE . ')/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^(' . FR_LANGUAGE . '/' . DEV_PATH . '/[^/]+)/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^.+/?$', 'index.php?route=' . ERROR_PATH, 'top' );
  }

  add_action( 'init', 'papj\add_rewrite_rules' );

  // Custom routing logic
  function change_template_selection( $template ) {
    $route = get_query_var( 'route' );
    if ( $route ):
      if ( ERROR_PATH !== $route ):
        $matches = [];
        if ( EN_LANGUAGE === $route || FR_LANGUAGE === $route ):
          return $template;
        endif;
        if ( ( preg_match( '@^' . EN_LANGUAGE . '/' . DEV_PATH . '/([^/]+)/?$@', $route, $matches ) ) &&
            get_posts( [ 'name' => $matches[ 1 ], 'post_type' => [ KNOW_HOW_POST_TYPE, RELEASE_POST_TYPE ], 'post_status' => 'publish', 'posts_per_page' => 1, 'meta_key' => LANGUAGE_KEY, 'meta_value' => EN_LANGUAGE ] ) ):
          return $template;
        endif;
        if ( ( preg_match( '@^' . FR_LANGUAGE . '/' . DEV_PATH . '/([^/]+)/?$@', $route, $matches ) ) &&
            get_posts( [ 'name' => $matches[ 1 ], 'post_type' => [ KNOW_HOW_POST_TYPE, RELEASE_POST_TYPE ], 'post_status' => 'publish', 'posts_per_page' => 1, 'meta_key' => LANGUAGE_KEY, 'meta_value' => FR_LANGUAGE ] ) ):
          return $template;
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


  // Define the Know-How and Release post types
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
            'item_link_description' => __( 'A link to a know-how', DOMAIN )
          ],
        'menu_icon' => 'dashicons-lightbulb',
        'menu_position' => 20,
        'public' => true,
        'supports' => [ 'title', 'editor', 'custom-fields' ],
        'show_in_rest' => true,
        'rest_base' => KNOW_HOW_IN_REST
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
            'item_link_description' => __( 'A link to a release', DOMAIN )
          ],
        'menu_icon' => 'dashicons-beer',
        'menu_position' => 20,
        'public' => true,
        'supports' => [ 'title', 'editor', 'custom-fields' ],
        'show_in_rest' => true,
        'rest_base' => RELEASE_IN_REST
      ] );
  }

  add_action( 'init', 'papj\register_post_types' );

  // Register the language meta field for the Know-How and Release post types
  function register_post_meta() {
    register_post_meta( KNOW_HOW_POST_TYPE, LANGUAGE_KEY, [
        'type' => 'string',
        'description' => __( 'Language of the know-How', DOMAIN ),
        'single' => true,
        'show_in_rest' => true
      ] );
    register_post_meta( KNOW_HOW_POST_TYPE, TRANSLATION_KEY, [
        'type' => 'string',
        'description' => __( 'Translation of the know-How', DOMAIN ),
        'single' => true,
        'show_in_rest' => true
      ] );
    register_post_meta( RELEASE_POST_TYPE, LANGUAGE_KEY, [
        'type' => 'string',
        'description' => __( 'Language of the release', DOMAIN ),
        'single' => true,
        'show_in_rest' => true
      ] );
    register_post_meta( RELEASE_POST_TYPE, TRANSLATION_KEY, [
        'type' => 'string',
        'description' => __( 'Translation of the release', DOMAIN ),
        'single' => true,
        'show_in_rest' => true
      ] );
  }

  // Add the language meta box to the Know-How and Release post types
  function add_language_meta_box() {
    add_meta_box( 'language-meta-box', __( 'Language', DOMAIN ), 'papj\render_language_meta_box', [ KNOW_HOW_POST_TYPE, RELEASE_POST_TYPE ], 'side' );
  }

  // Render the language meta box
  function render_language_meta_box( $post ) {
    $language = get_post_meta( $post->ID, LANGUAGE_KEY, true );
    $language_id = str_replace( '_', '-', LANGUAGE_KEY );
    $translation = get_post_meta( $post->ID, TRANSLATION_KEY, true );
    $translation_id = str_replace( '_', '-', TRANSLATION_KEY );
    ?>
      <div>
        <label for="<?= $language_id ?>"><?= __( 'Language', DOMAIN ) ?></label>
        <select id="<?= $language_id ?>" name="<?= LANGUAGE_KEY ?>">
          <option value="<?= EN_LANGUAGE ?>" <?php selected( $language, EN_LANGUAGE ); ?>><?= __( 'English', DOMAIN ) ?></option>
          <option value="<?= FR_LANGUAGE ?>" <?php selected( $language, FR_LANGUAGE ); ?>><?= __( 'Français', DOMAIN ) ?></option>
        </select>
      </div>
      <div>
        <label for="<?= $translation_id ?>"><?= __( 'Translation', DOMAIN ) ?></label>
        <input id="<?= $translation_id ?>" type="text" name="<?= TRANSLATION_KEY ?>" value="<?= $translation ?>" placeholder="<?= __( 'ID', DOMAIN ) ?>" />
      </div>
      <?php wp_nonce_field( NONCE_LANGUAGE_META_BOX[ 'action' ], NONCE_LANGUAGE_META_BOX[ 'name' ] ); ?>
    <?php
  }

  // Save the language meta box
  function save_language_meta_box( $post_id ) {
    if ( ! isset( $_POST[ NONCE_LANGUAGE_META_BOX[ 'name' ] ] ) || ! wp_verify_nonce( $_POST[ NONCE_LANGUAGE_META_BOX[ 'name' ] ], NONCE_LANGUAGE_META_BOX[ 'action' ] ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    if ( isset( $_POST[ LANGUAGE_KEY ] ) ):
      update_post_meta( $post_id, LANGUAGE_KEY, sanitize_text_field( $_POST[ LANGUAGE_KEY ] ) );
    endif;
    if ( isset( $_POST[ TRANSLATION_KEY ] ) && ctype_digit( $_POST[ TRANSLATION_KEY ] ) ):
      $post = get_post( $post_id );
      $translation = get_post( intval( $_POST[ TRANSLATION_KEY ] ) );
      if ( $translation && $translation->post_type === $post->post_type &&
          get_post_meta( $translation->ID, LANGUAGE_KEY, true ) !== get_post_meta( $post_id, LANGUAGE_KEY, true ) &&
          ! get_posts( [ 'post_type' => $post->post_type, 'posts_per_page' => 1, 'meta_key' => TRANSLATION_KEY, 'meta_value' => strval( $translation->ID ) ] ) ):
        update_post_meta( $post_id, TRANSLATION_KEY, sanitize_text_field( $_POST[ TRANSLATION_KEY ] ) );
      endif;
    endif;
  }

  add_action( 'add_meta_boxes', 'papj\add_language_meta_box' );
  add_action( 'save_post', 'papj\save_language_meta_box' );
?>