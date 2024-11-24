<?php get_header(); ?>
  <?php
    global $wp_query;
    $papj_data = [ 'route' => '/' . $wp_query->query_vars[ 'route' ] ];
  ?>
  <script id="papj-data" type="application/json"><?= json_encode( $papj_data, JSON_UNESCAPED_SLASHES ) ?></script>
  <div id="papj-vue"></div>
<?php get_footer(); ?>