<?php get_header(); ?>
  <?php $papj_data = [ 'route' => '/404' ]; ?>
  <script id="papj-data" type="application/json"><?= json_encode( $papj_data, JSON_UNESCAPED_SLASHES ) ?></script>
  <div id="papj-vue"></div>
<?php get_footer(); ?>