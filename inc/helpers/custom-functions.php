<?php
/**
 * Project_Name features custom functions.
 *
 * @package wp-menu-custom-fields
 */

/**
 * Generate cache key.
 *
 * @param string|array $unique base on that cache key will generate.
 *
 * @return string Cache key.
 */
function project_name_get_cache_key( $unique = '' ) {

	$cache_key = 'project_name_cache_';

	if ( is_array( $unique ) ) {
		ksort( $unique );
		$unique = wp_json_encode( $unique );
	}

	$md5 = md5( $unique );
	$key = $cache_key . $md5;

	return $key;
}

/**
 * To get cached version of result of WP_Query
 *
 * @param array $args Args of WP_Query.
 *
 * @return array List of posts.
 */
function project_name_get_cached_posts( $args ) {

	if ( empty( $args ) || ! is_array( $args ) ) {
		return [];
	}

	$args['suppress_filters'] = false;

	$expires_in = MINUTE_IN_SECONDS * 15;

	$cache_key = project_name_get_cache_key( $args );

	$cache  = new \WP_Menu_Custom_Fields\Inc\Cache( $cache_key );
	$result = $cache->expires_in( $expires_in )->updates_with( 'get_posts', [ $args ] )->get();

	return ( ! empty( $result ) && is_array( $result ) ) ? $result : [];
}

/**
 * An extension to get_template_part function to allow variables to be passed to the template.
 *
 * @param  string $slug file slug like you use in get_template_part without php extension.
 * @param  array  $variables pass an array of variables you want to use in array keys.
 *
 * @return void
 */
function project_name_get_template_part( $slug, $variables = [] ) {

	$template         = sprintf( '%s.php', $slug );
	$located_template = locate_template( $template, false, false );

	if ( '' === $located_template ) {
		return;
	}

	if ( ! empty( $variables ) && is_array( $variables ) ) {
		extract( $variables, EXTR_SKIP ); // phpcs:ignore -- Used as an exception as there is no better alternative.
	}

	include $located_template; // phpcs:ignore

}
/**
 * Render template.
 *
 * @param string $slug Template path.
 * @param array  $vars Variables to be used in the template.
 *
 * @return string Template markup.
 */
function project_name_render_template( $slug, $vars = [] ) {

	ob_start();
	project_name_get_template_part( $slug, $vars );
	$markup = ob_get_clean();
	return $markup;

}
