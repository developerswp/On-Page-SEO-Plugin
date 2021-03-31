<?php
/*
Plugin Name: OPS Robots.txt
Plugin URI:  https://profiles.wordpress.org/rishikeshsingh/
Description: On Page SEO plugin helps you boosting your website indexation and your ranking by adding specific instructions in your robots.txt and sitemap.xml file which added automatically in your website. No need to have coding (tech) skills to use OPS - Robots.txt Generator.
Version:     1.0
Author:      Rishikesh Singh
Author URI:  http://xolodevelopers.com
License:     GPL2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: on-page-seo
Domain Path: /i18n/

Wordpress On Page SEO is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 1 of the License, or
any later version.
 
On Page SEO is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with SEO. If not, see http://www.gnu.org/licenses/gpl-2.0.html.

@since     5.0.0
@author    Rishikesh Singh
@package   OPS\Plugin
@license   GPL-2.0+
@copyright Copyright (c) 2021, All in One SEO

*/

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) { 
    die("you do not have access to this page!");
}
   // if ( !defined('ABSPATH') )
   //  define('ABSPATH', dirname(__FILE__) . '/');
 $file = ABSPATH . 'robots.txt';
if(!file_exists($file)) {
	touch('robots.txt');
	header( 'Content-Type: text/plain; charset=utf-8' );
    $output = "User-agent: *\n";
    $output  .= "Allow: /\n\n";
    $site_url = parse_url( site_url() );
    $path     = ( ! empty( $site_url['path'] ) ) ? $site_url['path'] : '';
    $output  .= "Allow: $path/wp-admin/admin-ajax.php\n\n";
    $output  .= "User-agent: adbeat_bot\n";
    $output  .= "Disallow: /\n\n";
    $output  .= "User-agent: ScoutJet\n";
    $output  .= "Disallow: /\n\n";
    $output  .= "User-agent: Httrack\n";
    $output  .= "Disallow: /\n\n";
    $output  .= "Disallow: $path/wp-admin/\n";
    $output  .= "Disallow: $path/wp-includes/\n";
    $output  .= "Disallow: $path/readme.html\n";
    $output  .= "Disallow: $path/license.txt\n";
    $output  .= "Disallow: $path/xmlrpc.php\n";
    $output  .= "Disallow: $path/wp-login.php\n";
    $output  .= "Disallow: $path/wp-register.php\n";
    $output  .= "Disallow: $path/*/disclaimer/*\n";
    $output  .= "Disallow: $path/*?attachment_id=\n";
    $output  .= "Disallow: $path/cgi-bin/\n";
    $output  .= "Disallow: $path/feed/\n";
    $output  .= "Disallow: $path/*/feed/\n";
    $output  .= "Disallow: $path/plugins/*\n";
    $output  .= "Disallow: $path/*/comments/\n";
    $output  .= "Disallow: $path/*/trackback/\n";
    $output  .= "Disallow: $path/comments/feed/\n";
    $output  .= "Disallow: $path/wp-login.php?*\n";
    $output  .= "Disallow: $path/demo/\n\n\n";
    $output  .= "#robots.txt for {$site_url['scheme']}://{$site_url[ 'host' ]}\n";
	if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) ) {
	    $output  .= "Sitemap: {$site_url['scheme']}://{$site_url[ 'host' ]}/sitemap_index.xml //Yoast SEO \n";
	}else{
       $output  .= "Sitemap: {$site_url['scheme']}://{$site_url[ 'host' ]}/sitemap.xml //On Page SEO \n";
    }
        $file_open = fopen($file,"w+");
        fwrite($file_open, $output);
        fclose($file_open);
}

// if(file_exists($file)) {

// }

//require __DIR__.'/bootstrap/loaders.php';
define ( 'SRC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
require_once SRC_PLUGIN_PATH . 'settings.php';
require_once SRC_PLUGIN_PATH . 'functions.php';
//require_once SRC_PLUGIN_PATH . 'uninstall.php';
require_once SRC_PLUGIN_PATH . 'shortcode.php';


function on_page_seo_styles () 
{
	wp_enqueue_style( 'ops_bs_css', plugins_url('css/bootstrap.min.css', __FILE__) );
	wp_enqueue_style( 'ops_custom_css', plugins_url('css/custom.css', __FILE__) );  
	wp_enqueue_script( 'ops_bs_js', plugins_url( 'js/bootstrap.min.js', __FILE__ ) );
	//wp_enqueue_script( 'ops_bs_pr', plugins_url( 'js/popper.min.js', __FILE__ ));
	wp_enqueue_script( 'ops_bndl_pr', plugins_url( 'js/bootstrap.bundle.min.js', __FILE__ ));
	wp_enqueue_script( 'ops_cs_pr', plugins_url( 'js/custom.js', __FILE__ ));
}  
add_action( 'admin_enqueue_scripts', 'on_page_seo_styles' ); 


// addding a plugin action links to plugin list block.
add_filter( 'plugin_action_links', 'sbc_action_links',10,5);
  
function sbc_action_links( $actions, $plugin_file ) 
{
	static $plugin;
	
	if ( ! isset($plugin) ) {
		
	   $plugin = plugin_basename(__FILE__);

	  }
	if ( $plugin == $plugin_file ) {
		
	     $settings = array( 'settings' => '<a href="options-general.php?page=on_page_seo">Settings</a>' );
	      $site_link = array( 'support' => '<a style="font-weight: bold;" href="https://profiles.wordpress.org/rishikeshsingh/" target="_blank">Support</a>' );
	      $pro = array( 'Get Premium' => '<a href="https://wa.me/send?phone=919711425615&amp;text=Hi,%20I%20would%20like%20to%20buy%20pro%20On%20OPS%20SEO%20Plugin." style="color: #389e38;font-weight: bold;" target="_blank">Get Pro</a>' );
		
    	  $actions = array_merge($settings, $actions);
		  $actions = array_merge($site_link, $actions);
		  $actions = array_merge($pro, $actions);
			
		}
	return $actions;
}
?>