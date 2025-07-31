<?php
/**
 * Plugin Name: Green Party Maps
 * Description: Displays Green Party maps from data hosted at
 * https://GreenMaps.US
 * Version: 0.1
 * Author: Christopher Lozinski
 * License: GPL
 *
 */


/**
 * Handles plugin activation
 */
function gpm_activate() {

    // Ensure the page exists and is published
    $page_slug = 'green-maps';
    $page = get_page_by_path($page_slug);
    
    if (!$page) {
        // Create the page if it doesn't exist
        $page_data = array(
            'post_title'    => 'Green Party Maps',
            'post_name'     => $page_slug,
            'post_content'  => '[green_party_maps]',
            'post_status'   => 'publish',
            'post_type'     => 'page'
        );
        wp_insert_post($page_data);
    } else {
        // Ensure existing page is published
        if ($page->post_status !== 'publish') {
            wp_update_post(array(
                'ID' => $page->ID,
                'post_status' => 'publish'
            ));
        }
    }
}

/**
 * Handles plugin deactivation
 */
function gpm_deactivate() {
    // Remove shortcode
    //remove_shortcode('green_party_maps');

    $page_slug = 'green-maps';
    $page = get_page_by_path($page_slug);
    
    if ($page) {
        // Change page status to draft
        wp_update_post(array(
            'ID' => $page->ID,
            'post_status' => 'draft'
        ));
    }
}

/**
 * Renders the map from remote data
 */
function gpm_render_map() {
    $url = 'https://GreenMaps.us/usa/geojson';
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return '<p>Error loading map data.</p>';
    }
    
    $data = wp_remote_retrieve_body($response);
    
    // Return data in preformatted tag
    return '<pre>' . esc_html($data) . '</pre>';
}

/**
 * Injects header code on map page
 */
function gpm_inject_header_code() {
    if (is_page('green-party-maps')) {
       include "header.html";
    }
}

// Add header injection

if (! has_action ('wp_head', 'gpm_inject_header_code')){
      add_action ('wp_head', 'gpm_inject_header_code');
}      
    
// Register shortcode
if (! has_shortcode ('green_party_maps', 'gpm_render_map')){
      add_shortcode ('green_party_maps', 'gpm_render_map');
}
//NEED TO CONDITIONALLY DO THIS
// Register activation hook
register_activation_hook(__FILE__, 'gpm_activate');

// Register deactivation hook
register_deactivation_hook(__FILE__, 'gpm_deactivate');

