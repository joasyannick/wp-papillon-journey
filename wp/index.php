<?php get_header(); ?>
  <div id="papj-app" data-papj-route="<?php global $wp_query; echo '/' . ( array_key_exists( 'route', $wp_query->query_vars ) ? $wp_query->query_vars[ 'route' ] : '' ); ?>">
  </div>
<?php get_footer();