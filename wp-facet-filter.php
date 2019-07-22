<?php
/*
Plugin Name: WP Facet Filter
*/
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