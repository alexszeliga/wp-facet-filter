<?php
/*
Plugin Name: WP Facet Filter
*/

// Build settings page

// generate a settings option in the submenu of the settings admin menu item and limit it to admins
function wp_facet_filter_register_settings_page() {
    add_options_page( 
        'WP Facet Filter',
        'WP Facet Filter',
        'manage_options',
        'wp-facet-filter-page',
        'wp_facet_filter_page'
    );
}
// Add settings for facet filter to the admin menu [note: in the submenu of the settings admin menu item]
add_action( 'admin_menu', 'wp_facet_filter_register_settings_page' );

// Add a setting section to the setting page generated in 'wp_facet_filter_register_settings_page'
function wp_facet_filter_add_settings_section() {
    add_settings_section(
        'wp_facet_filters_target',
        'Post Type',
        'wp_facet_filter_add_settings_section_markup_callback',
        'wp_facet_filter_page'
    );
}
add_action('admin_init', 'wp_facet_filter_add_settings_section');

// Register settings to store the post type and page for the plugin.
function wp_facet_filter_register_settings() {
    $settings_args = array(
        'type' => 'string'
    );
    register_setting(
        'wp_facet_filter_options',
        'wp_facet_filters_faceted_post_type',
        $settings_args
    );
    register_setting(
        'wp_facet_filter_options',
        'wp_facet_filter_miniblog_page_id',
        $settings_args
    );
}
// Fire on all admin pages; BP? TODO: research.
add_action( 'admin_init', 'wp_facet_filter_register_settings' );

// Define field for our settings page.
function wp_facet_filter_add_settings_field() {
    $faceted_post_type = get_option('wp_facet_filters_faceted_post_type');
    add_settings_field(
        'wp_facet_filters_faceted_post_type',
        'Post Type',
        'wp_facet_filter_add_post_type_setting_field_markup_callback',
        'wp_facet_filter_page',
        'wp_facet_filters_target',
        array( 'label_for' => 'myprefix_setting-id' )
    );  
    $miniblog_page = get_option('wp_facet_filter_miniblog_page_id');
    add_settings_field(
        'wp_facet_filter_miniblog_page_id',
        'Miniblog Page',
        'wp_facet_filter_add_miniblog_page_id_setting_field_markup_callback',
        'wp_facet_filter_page',
        'wp_facet_filters_target',
        array( 'label_for' => 'myprefix_setting-id' )
    );  
}
add_action('admin_init', 'wp_facet_filter_add_settings_field');

// Define markup for settings page
function wp_facet_filter_page() {
    ?>
        <div>
            <h2>WP Facet Filter Options</h2>
            <form action="options.php" method="post">
                <?php settings_fields('wp_facet_filter_options'); ?>
                <?php do_settings_sections('wp_facet_filter_page'); ?>
        
                <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
            </form>
        </div>
    <?php
}
function wp_facet_filter_add_settings_section_markup_callback() {
    // I could probably use this to add classes or something to the section; but I'm cool for now.
    }
// define markup for settings field
function wp_facet_filter_add_post_type_setting_field_markup_callback() {
    $post_type_args = array(
        'public' => true
    );
    $options = get_option( 'wp_facet_filters_faceted_post_type' );
    $post_types = get_post_types( $post_type_args );
    ?>
        <select id="wp_facet_filters_faceted_post_type" name="wp_facet_filters_faceted_post_type" >
            <?php
                foreach ( $post_types as $post_type ) {
                    $pt_obj = get_post_type_object( $post_type );
                    if ($options == $post_type) {
                        echo "<option selected value='" . $post_type . "'>" . $pt_obj->label . "</option>";
                    } else {
                        echo "<option value='" . $post_type . "'>" . $pt_obj->label . "</option>";
                    }
                } 
            ?>
        </select>
    <?php
}

function wp_facet_filter_add_miniblog_page_id_setting_field_markup_callback() {
    global $pages;
    $option = get_option( 'wp_facet_filter_miniblog_page_id' );
    ?>
        <select id="wp_facet_filter_miniblog_page_id" name="wp_facet_filter_miniblog_page_id" >
            <?php
                foreach ( $$pages as $page ) {

                    echo "<option>BLECH</option>";
                } 
            ?>
        </select>
    <?php
}


// CORE PLUGIN FUNCTIONALITY.

function filterPost () {
    // get post type from options
    $post_type = get_option( 'wp_facet_filters_faceted_post_type' ); //string post type slug
    // get post type taxonomies
    $post_taxonomies = getPostTypeTaxonomies( $post_type );
    // get filter terms

    // associate terms to taxs

    // get tax filter strategy

    // build query

    // return 

}
function getPostTypeTaxonomies (string $post_type = 'post') {
    $tax_args = array(
        'post_type' => $post_type
    );
    return get_object_taxonomies( $tax_args );
}


    // on post save (w/ new terms?)
    // get new terms
    // get term taxonomy

function generateFacetSet (int $termId, string $post_type = NULL) {
    // for each term for a post of a given type, generate an array
    if (isset($post_type)) {
        $the_query = array(
            'post_type' => $post_type,
            'fields'    => 'ids',
            'tax_query' => array( 
                    array(
                    'taxonomy' => 'resources',
                    'terms'    => array($termId)
                )
            )
        );
    }
    else {
        $the_query = array(
            'fields'    => 'ids',
            'tax_query' => array( 
                    array(
                    'taxonomy' => 'resources',
                    'terms'    => array($termId)
                )
            )
        );
    }
    $the_query = new WP_Query( $the_query );
    
    return ($the_query->posts);

    /* Restore original Post Data */
    wp_reset_postdata();
} 

function wp_facet_filter_register_block() {
    wp_register_script(
        'wp-facet-filter-01',
        plugins_url( 'block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-editor', 'wp-element' )
    );

    wp_register_style(
        'wp-facet-filter-01-editor',
        plugins_url( 'editor.css', __FILE__ ),
        array( 'wp-edit-blocks' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' )
    );
 
    wp_register_style(
        'wp-facet-filter-01',
        plugins_url( 'style.css', __FILE__ ),
        array( ),
        filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
    );
 
    register_block_type( 'wp-facet-filter/filter-01', array(
        'style' => 'wp-facet-filter-01',
        'editor_style' => 'wp-facet-filter-01-editor',
        'editor_script' => 'wp-facet-filter-01',
    ) );
 
}
add_action( 'init', 'wp_facet_filter_register_block' );