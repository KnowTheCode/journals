<?php
/**
 * File autoloader functionality
 *
 * @package     KnowTheCode\Journals\Support
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */
namespace KnowTheCode\Journals\Support;

/**
 * Load all of the plugin's files.
 *
 * @since 1.0.0
 *
 * @param string $src_root_dir Root directory for the source files
 *
 * @return void
 */
function autoload_files( $src_root_dir ) {

	$filenames = array(
		'custom/post-type',
		// Uncomment this one if you want to
//		 use the custom taxonomy too.
//		'custom/taxonomy',
	);

	foreach ( $filenames as $filename ) {
		include_once( $src_root_dir . $filename . '.php' );
	}
}
