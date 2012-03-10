<?php
class CustomPostTypeSelector {
    var $admin_panel_hook;
    protected $setting = 'cpts-enabled-post-types';
    
    function __construct() {
        add_filter( 'plugin_action_links_' . TLCD_CPTS_NAME, array( &$this, 'filter_plugin_action_links' ), 10, 2 );
        add_action( 'admin_menu', array( &$this, 'register_admin_menu' ) );
        add_action( 'admin_init', array( &$this, 'register_setting' ) );
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
        $enabled = get_option( $this->setting, array( 'post' ) );
        ?>
            <div class="wrap">
                <?php screen_icon(); ?>
                <h2><?php _e( 'Post Types', 'cpt-selector' ); ?></h2>
                <?php settings_errors( $this->setting ); ?>
                <form method="post" action="<?php echo admin_url( 'options.php' ); ?>">
                    <?php settings_fields( $this->setting ); ?>
                    <table class="form-table">
                        <tbody>
                            <tr valign="top">
                                <th scope="row"><?php _e( 'Enabled Post Types:', 'cpt-selector' ); ?></th>
                                <td>
                                    <?php 
                                        foreach( get_post_types( array( 'public' => true ) ) as $post_type ):
                                        /**
                                         * attachments never have the a "publish" status, so they'll never show up
                                         * on the front end, So we shouldn't include them here.
                                         * used in array so we can (possibly exclude other post types 
                                         */
                                        if ( in_array( $post_type, array( 'attachment' ) ) ) continue;
                                        $checked = in_array( $post_type, $enabled ) ? 'checked="checked"' : '';
                                        $typeobj = get_post_type_object( $post_type );
                                        $label = isset( $typeobj->labels->name ) ? $typeobj->labels->name : $typeobj->name;
                                    ?>
                                        <input type="checkbox" name="<?php echo $this->setting; ?>[<?php echo esc_attr( $post_type ); ?>]" id="cpts_<?php echo $post_type ?>" <?php echo $checked; ?> />
                                        <label for="cpts_<?php echo $post_type ?>"><?php echo ucwords( esc_html( $label ) ); ?></label><br />
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                
                        </tbody>
                    </table>
                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'cpt-selector' ); ?>">
                    </p>
                </form>
            </div>
        <?php
    }

    function register_setting() {
        register_setting(
            $this->setting,
            $this->setting,
            array( &$this, 'clean_setting' )
        );
    }

    function clean_setting( $in ) {
        $out = array();
        foreach( get_post_types( array( 'public' => true ) ) as $pt ) {
            if ( isset( $in[$pt] ) && $in[$pt] ) $out[] = $pt;
        }
        return $out;
    }
} // end class

$CustomPostTypeSelector = new CustomPostTypeSelector();
