<?php

	/*

		Plugin Name: Custom Post Type Selector
		Plugin URI: http://wordpress.org/extend/plugins/custom-post-type-selector/
		Version: 1.0
		
		Author: Tom Lynch
		Author URI: http://tomlynch.co.uk
		
		Description: Custom Post Type Selector allows you to select which post types should be included in the main loop of your blog, including custom post types.
		
		License: GPLv3
		
		Copyright (C) 2011 Tom Lynch

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
	
	class CustomPostTypeSelector {
		var $admin_panel_hook;
		
		function __construct() {
			add_filter( 'parse_query', array( &$this, 'parse_query' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( &$this, 'filter_plugin_action_links' ), 10, 2 );
			add_action( 'admin_menu', array( &$this, 'register_admin_menu' ) );
		}
		
		function parse_query( $query ) {
			if( ! $query->is_main_query() ) return;
		    if( is_home() || is_search() || is_tax() || is_category() || is_tag() || is_archive() || is_feed() ) {
				$enabled_post_types = get_option( 'cpts-enabled-post-types' );
				if ( ! is_array( $enabled_post_types ) )
					$enabled_post_types = array( 'post' => 'true' );
		        $query->query_vars['post_type'] = $enabled_post_types;
		    }
		}
		
		function filter_plugin_action_links( $links ) {
			array_unshift( $links, '<a href="' . admin_url( 'options-general.php' ) . '?page=post-types">Post Types</a>' );
			return $links;
		}
				
		function register_admin_menu() {
			$this->admin_panel_hook = add_options_page('Post Types', 'Post Types', 'manage_options', 'post-types', array( &$this, 'register_options_page' ) );
			add_action( 'load-' . $this->admin_panel_hook, array( &$this, 'admin_panel_load' ) );
		}
		
		function admin_panel_load() {
			$screen = get_current_screen();
			$screen->add_help_tab( array(
			        'id'	=> 'overview',
			        'title'	=> 'Overview',
			        'content'	=> '<p>This screen lets you modify which post types are shown in the main loop of your blog, including the home page, search pages, RSS feed, and archive pages.</p>',
			    ) );

			    $screen->set_help_sidebar( '<p>
					<strong>For more information:</strong>
				</p>
				<p>
					<a href="http://wordpress.org/extend/plugins/custom-post-type-selector" target="_blank">Homepage</a>
				</p>
				<p>
					<a href="http://wordpress.org/tags/custom-post-type-selector" target="_blank">Discussions</a>
				</p>' );
		}
		
		function register_options_page() {
			if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'cpts' ) && current_user_can( 'manage_options' ) ) {
				if ( isset( $_POST['enabled-post-types'] ) ) {
					update_option( 'cpts-enabled-post-types', array_keys( $_POST['enabled-post-types'] ) );
				} else {
					delete_option( 'cpts-enabled-post-types' );
				}
				$done = true;
			}
			$enabled_post_types = get_option( 'cpts-enabled-post-types' );
			if ( ! is_array( $enabled_post_types ) )
				$enabled_post_types = array( 'post' => 'true' );
		?>
				<div class="wrap">
					<div id="icon-options-general" class="icon32"></div>
					<h2>Post Types</h2>
					<?php if ( current_user_can( 'manage_options' ) ): ?>
						
						<?php if ( isset( $done ) ): ?>
							<div id="message" class="updated"><p><strong>Setting saved.</strong></p></div>
						<?php endif ?>
						
						<form method="post" action="options-general.php?page=post-types">
							<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'cpts' ) ?>">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">Enabled Post Types:</th>
										<td>
											<?php foreach( get_post_types( array( 'public' => true ) ) as $post_type ): ?>
												<input type="checkbox" name="enabled-post-types[<?php echo $post_type ?>]" id="cpts_<?php echo $post_type ?>" <?php echo ( isset( $enabled_post_types ) && in_array( $post_type, $enabled_post_types ) ? 'checked="checked"' : null ) ?> />
												<label for="cpts_<?php echo $post_type ?>"><?php echo ucwords( $post_type ) ?></label><br />
											<?php endforeach ?>
										</td>
									</tr>
							
								</tbody>
							</table>
							<p class="submit">
								<input type="submit" class="button-primary" value="Save Changes">
							</p>
						</form>
					<?php else: ?>
						<p>You do not have permission to use Custom Post Type Selector.</p>
					<?php endif ?>
				</div>
			<?php
		}
	}
	
	$CustomPostTypeSelector = new CustomPostTypeSelector();
?>