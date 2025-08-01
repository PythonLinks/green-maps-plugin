<?php
/**
 * Plugin Name: Green Party Maps
 * Description: Displays Green Party maps from data hosted at https://GreenMaps.US
 * Version: 0.1
 * Author: Christopher Lozinski
 * License: GPLv2 or later
 * Text Domain: green-party-maps
 */

defined('ABSPATH') || exit;

// Use consistent slug throughout
define('GPM_PAGE_SLUG', 'green-maps');

/**
 * Handles plugin activation
 */
function gpm_activate() {
    $page = get_page_by_path(GPM_PAGE_SLUG);
    
    if (!$page) {
        $page_data = array(
            'post_title'    => 'Green Party Maps',
            'post_name'     => GPM_PAGE_SLUG,
            'post_content'  => '[green_party_maps]',
            'post_status'   => 'publish',
            'post_type'     => 'page'
        );
        wp_insert_post($page_data);
    } elseif ('publish' !== $page->post_status) {
        wp_update_post(array(
            'ID' => $page->ID,
            'post_status' => 'publish'
        ));
    }
}

/**
 * Handles plugin deactivation
 */
function gpm_deactivate() {
    $page = get_page_by_path(GPM_PAGE_SLUG);
    if ($page && 'publish' === $page->post_status) {
        wp_update_post(array(
            'ID' => $page->ID,
            'post_status' => 'draft'
        ));
    }
}

/**
 * Renders the map from remote site
 */
import "replace.php";

function gpm_render_map() {
    $url = 'https://GreenMaps.us/usa/content';
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return '<p>Error loading map html fragment.</p>';
    }
    
    $value = wp_remote_retrieve_body($response);
    $value = replace_anchor_tags($value);
    return $value;
    }

/**
 * Injects header code on map page
 */
define('GPM_PAGE_SLUG', 'green-maps');
function gpm_inject_header_code() {
    if (!is_page(GPM_PAGE_SLUG))
       return "NO GREEN MAPS HEADER";

    // Get page name from query var or default to 'usa'
    $page_name = get_query_var('page-name') ?: 'usa';

    // Include header.php from the current directory
    include __DIR__ . '/header.php';
    <script>var wordPress = true;</scipt>
    <!-- END Green Maps  Header -->
}

// Register hooks
add_action('wp_head', 'gpm_inject_header_code');
add_shortcode('green_party_maps', 'gpm_render_map');
register_activation_hook(__FILE__, 'gpm_activate');
register_deactivation_hook(__FILE__, 'gpm_deactivate');
