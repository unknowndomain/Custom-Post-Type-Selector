<?php
/*
Plugin Name: Custom Post Type Selector
Plugin URI: http://wordpress.org/extend/plugins/custom-post-type-selector/
Version: 1.2
Author: Tom Lynch
Author URI: http://tomlynch.co.uk
Description: Custom Post Type Selector allows you to select which post types should be included in the main loop of your blog, including custom post types.	
License: GPLv3
    
    Copyright (C) 2012 Tom Lynch

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
	
define( 'TLCD_CPTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'TLCD_CPTS_NAME', plugin_basename( __FILE__ ) );

if ( is_admin() ) {
    require_once( TLCD_CPTS_PATH . 'inc/admin.php' );
} else {
    require_once( TLCD_CPTS_PATH . 'inc/front.php' );
}

register_activation_hook( __FILE__, 'tlcd_cpts_activation' );
/**
 * Activation hook
 */
function tlcd_cpts_activation() {
    add_option( 'cpts-enabled-post-types', array( 'post' ) );
}

register_deactivation_hook( __FILE__, 'tlcd_cpts_deactivation' );
/**
 * Deactivation hook
 */
function tlcd_cpts_deactivation() {
    delete_option( 'cpts-enabled-post-types' );
}
