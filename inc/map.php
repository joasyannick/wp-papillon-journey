<?php
	require_once get_template_directory() . '/inc/constants.php';

	function pj_customize_register( $wp_customize ) {
		$wp_customize->add_section( 'pj_map_section', array(
				'title' => __( 'Map', 'papillon-journey' ),
				'priority' => PJ_MAP_CUSTOMIZER_LOCATION
			) );
		$wp_customize->add_setting( 'pj_map_id', array(
				'default' => PJ_DEFAULT_MAP_ID,
				'sanitize_callback' => function ( $input ) {
					return wp_get_attachment_image_url( $input, 'full' )? $input: PJ_DEFAULT_MAP_ID;
				}
			) );
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'pj_map_id', array(
				'label' => __( 'Map Image', 'papillon-journey' ),
				'section' => 'pj_map_section',
				'mime_type' => 'image'
			) ) );
		//TODO Add zoom min, zoom max and fill color as options
		file_put_contents( get_template_directory() . '/log.txt', PHP_EOL . 'Init?', FILE_APPEND );
		if ( ! is_dir( get_template_directory() . PJ_MAP_TILES_PATH ) ) {
			pj_generate_tiles_from_map_image( get_template_directory() . PJ_DEFAULT_MAP_PATH );
			file_put_contents( get_template_directory() . '/log.txt', PHP_EOL . 'Init: done', FILE_APPEND );
		}
	}

	function pj_on_map_id_updated( $new_id, $old_id ) {
		file_put_contents( get_template_directory() . '/log.txt', PHP_EOL . 'Map ID: old value: ' . $old_id, FILE_APPEND );
		file_put_contents( get_template_directory() . '/log.txt', PHP_EOL . 'Map ID: new value: ' . $new_id, FILE_APPEND );
		if ( $old_id === $new_id ) {
			return $new_id;
		}
		try {
			if ( PJ_DEFAULT_MAP_ID === $new_id ) {
				pj_generate_tiles_from_map_image( get_template_directory() . PJ_DEFAULT_MAP_PATH );
			} else {
				$map_path = pj_download_map_image( wp_get_attachment_image_url( $new_id, 'full' ) );
				pj_generate_tiles_from_map_image( $map_path );
				unlink( $map_path );
			}
			return $new_id;
		} catch ( Exception $exception ) {
			return $old_id;
		}
	}

	function pj_download_map_image( $map_url ) {
		$map_path = get_template_directory() . PJ_MAP_PATH . '/' . PJ_DOWNLOADED_MAP_PREFIX . basename( parse_url( $map_url, PHP_URL_PATH ) );
		$map_file = fopen( $map_path, 'w' );
		$session = curl_init();
		curl_setopt( $session, CURLOPT_URL, $map_url );
		curl_setopt( $session, CURLOPT_FILE, $map_file );
		curl_exec( $session );
		curl_close( $session );
		fclose( $map_file );
		return $map_path;
	}

	function pj_generate_tiles_from_map_image( $map_path ) {
		$tiles_directory = get_template_directory() . PJ_MAP_TILES_PATH;
		if ( is_dir( $tiles_directory ) ) {
			pj_remove_directory( $tiles_directory );
		}
		mkdir( $tiles_directory );
		//TODO
	}

	function pj_remove_directory( $path ) {
		return preg_match( '/^\s*$/', $path ) ? false : (
				is_file( $path ) ? unlink( $path ) : array_map( __FUNCTION__, glob( $path.'/*' )) == rmdir( $path )
			);
	}
?>