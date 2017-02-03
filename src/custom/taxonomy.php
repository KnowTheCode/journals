<?php
/**
 * Custom Taxonomy functionality
 *
 * @package     KnowTheCode\Journals\Custom
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */
namespace KnowTheCode\Journals\Custom;

add_action( 'init', __NAMESPACE__ . '\register_custom_taxonomy' );
/**
 * Register the taxonomy.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_custom_taxonomy() {

	$menu_label = __( 'Journal Categories', 'journals' );

	$labels = array(
		'name'                       => _x( 'Journal Categories', 'taxonomy general name', 'journals' ),
		'singular_name'              => _x( 'Journal Category', 'taxonomy singular name', 'journals' ),
		'search_items'               => __( 'Search Journal Categories', 'journals' ),
		'popular_items'              => __( 'Popular Journal Categories', 'journals' ),
		'all_items'                  => __( 'All Journal Categories', 'journals' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Journal Category', 'journals' ),
		'view_item'                  => __( 'View Journal Category', 'journals' ),
		'update_item'                => __( 'Update Journal Category', 'journals' ),
		'add_new_item'               => __( 'Add New Journal Category', 'journals' ),
		'new_item_name'              => __( 'New Journal Category Name', 'journals' ),
		'separate_items_with_commas' => __( 'Separate departments with commas', 'journals' ),
		'add_or_remove_items'        => __( 'Add or remove departments', 'journals' ),
		'choose_from_most_used'      => __( 'Choose from the most used departments', 'journals' ),
		'not_found'                  => __( 'No departments found.', 'journals' ),
		'menu_name'                  => $menu_label,
	);

	$args = array(
		'label'             => $menu_label,
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
	);

	register_taxonomy( 'department', array( 'team-bios', 'post' ), $args );
}

add_filter( 'genesis_post_meta', __NAMESPACE__ . '\filter_genesis_footer_post_meta' );
/**
 * Filter the Genesis Footer Entry Post Meta
 * to add the post terms for our custom taxonomy to it.
 *
 * @since 1.0.0
 *
 * @param string $post_meta
 *
 * @return string
 */
function filter_genesis_footer_post_meta( $post_meta ) {

	$post_meta .= sprintf(
		' [post_terms taxonomy="department" before="%s"]',
		__( 'Journal Category: ', 'journals' )
	);

	return $post_meta;
}
