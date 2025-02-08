<?php get_header(); ?>
  <?php $papj_data = [ 'route' => '/' . get_query_var( 'route' ) ]; ?>
  <script id="papj-data" type="application/json"><?= json_encode( $papj_data, JSON_UNESCAPED_SLASHES ) ?></script>
  <div id="papj-app"></div>
<?php get_footer(); ?>