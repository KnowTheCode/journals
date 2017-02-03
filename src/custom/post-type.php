<?php
/**
 * Custom Post Type functionality
 *
 * @package     KnowTheCode\Journals\Custom
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */
namespace KnowTheCode\Journals\Custom;

use WP_Query;

add_action( 'init', __NAMESPACE__ . '\register_custom_post_type' );
/**
 * Register the custom post type.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_custom_post_type() {

	$labels = array(
		'name'               => _x( 'Journals', 'post type general name', 'journals' ),
		'singular_name'      => _x( 'Journal', 'post type singular name', 'journals' ),
		'menu_name'          => _x( 'Journals', 'admin menu', 'journals' ),
		'name_admin_bar'     => _x( 'Journal', 'add new on admin bar', 'journals' ),
		'add_new'            => _x( 'Add New Journal', 'journals', 'journals' ),
		'add_new_item'       => __( 'Add New Journal', 'journals' ),
		'new_item'           => __( 'New Journal', 'journals' ),
		'edit_item'          => __( 'Edit Journal', 'journals' ),
		'view_item'          => __( 'View Journal', 'journals' ),
		'all_items'          => __( 'All Journals', 'journals' ),
		'search_items'       => __( 'Search Journals', 'journals' ),
		'parent_item_colon'  => __( 'Parent Journals:', 'journals' ),
		'not_found'          => __( 'No journals found.', 'journals' ),
		'not_found_in_trash' => __( 'No journals found in Trash.', 'journals' ),

		'featured_image'        => __( 'Journal Image', 'journals' ),
		'set_featured_image'    => __( 'Set Journal Image', 'journals' ),
		'remove_featured_image' => __( 'Remove Journal Image', 'journals' ),
		'use_featured_image'    => __( 'Use Journal Image', 'journals' ),
	);

	$features = get_all_post_type_features( 'post' );

	$args = array(
		'label'        => __( 'Journals', 'journals' ),
		'labels'       => $labels,
		'public'       => true,
		'supports'     => $features,
		'menu_icon'    => 'dashicons-admin-page',
		'hierarchical' => false,
		'has_archive'  => true,
		'taxonomies'   => array( 'category' ),
	);

	register_post_type( 'journal', $args );

	// If you want to bind this custom post type to
	// the built-in category taxonomy, then you do this:
	register_taxonomy_for_object_type( 'category', 'journal' );
}

/**
 * Get all the post type features for the given post type.
 *
 * @since 1.0.0
 *
 * @param string $post_type Given post type
 * @param array $exclude_features Array of features to exclude
 *
 * @return array
 */
function get_all_post_type_features( $post_type = 'post', $exclude_features = array() ) {
	$configured_features = get_all_post_type_supports( $post_type );

	if ( ! $exclude_features ) {
		return array_keys( $configured_features );
	}

	$features = array();

	foreach ( $configured_features as $feature => $value ) {
		if ( in_array( $feature, $exclude_features ) ) {
			continue;
		}

		$features[] = $feature;
	}

	return $features;
}

add_action( 'pre_get_posts', __NAMESPACE__ . '\add_journal_to_category_query' );
/**
 * Add Journal to the category query.
 *
 * @since 1.0.0
 *
 * @param WP_Query $query query object
 *
 * @return void
 */
function add_journal_to_category_query( WP_Query $query ) {
	if ( ! is_a_journal_category_archive_query( $query ) ) {
		return;
	}

	$query->set( 'post_type', get_journal_post_types_for_query_set() );
}


/**
 * Checks if this category archive is a
 * valid Journal term (category).
 *
 * Valid ones are "news" and "sports"
 *
 * @since 1.0.0
 *
 * @param WP_Query $query query object
 *
 * @return bool
 */
function is_a_journal_category_archive_query( WP_Query $query ) {
	if ( is_admin() ) {
		return false;
	}

	if ( ! $query->is_main_query() ) {
		return false;
	}

	if ( ! is_category() ) {
		return false;
	}

	$category_name = get_query_var( 'category_name' );

	return in_array( $category_name, array( 'news', 'sports' ) );
}

/**
 * Get the post types and add "journal" to it/them
 * for the query set.
 *
 * @since 1.0.0
 *
 * @return array
 */
function get_journal_post_types_for_query_set() {
	$post_types   = get_query_var( 'post_type' );
	if ( ! $post_types ) {
		return array( 'post', 'journal' );
	}

	$post_types = (array) $post_types;
	$post_types[] = 'journal';

	return $post_types;
}

/**
 * Checks if this category archive is a
 * valid Journal term (category).
 *
 * Valid ones are "news" and "sports"
 *
 * @since 1.0.0
 *
 * @return bool
 */
function is_a_journal_category_archive() {
	$category_name = get_query_var( 'category_name' );

	return in_array( $category_name, array( 'news', 'sports' ) );
}
