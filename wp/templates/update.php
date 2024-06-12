<?php get_header(); ?>
  <div id="papj-app" data-papj-route="<?php global $wp_query; echo '/' . $wp_query->query_vars[ 'route' ]; ?>">
  </div>
<?php get_footer();