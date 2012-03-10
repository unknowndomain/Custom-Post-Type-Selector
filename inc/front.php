<?php
add_filter( 'parse_query', 'tlcd_cpts_parse_query' );
/**
 * Modifies the main query to include additional post types
 */
function tlcd_cpts_parse_query( $query ) {
    if( ! $query->is_main_query() ) return;
    if( is_home() || is_search() || is_tax() || is_category() || is_tag() || is_archive() || is_feed() ) {
        $enabled_post_types = get_option( 'cpts-enabled-post-types', array( 'post' ) );
        $query->query_vars['post_type'] = $enabled_post_types;
    }
}
