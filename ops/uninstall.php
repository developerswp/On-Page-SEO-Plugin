<?php
// Prevent direct file access
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}
// plugin uninstall function. 
function on_page_seo_uninstaller()
{
	if ( ! defined( 'ABSPATH' ) ) { 
	    die("you do not have access to this page!");
	}
	$file = ABSPATH . 'robots.txt';
	if(file_exists($file)) {
       wp_delete_file( $file ); 
    }

// if ( shortcode_exists('on_page_seo')) {
//    remove_shortcode ('on_page_seo');
// }

}
// Calling function for uninstallation.
 on_page_seo_uninstaller();
?>
 