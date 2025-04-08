<?php
/*
Plugin Name: Finance Calculators Plugin
Description: A sleek and SEO-friendly plugin offering 12 categories of finance calculators.
Version: 1.0
Author: Your Name
*/

define('FCP_DIR', plugin_dir_path(__FILE__));
define('FCP_URL', plugin_dir_url(__FILE__));

// Enqueue styles and scripts
function fcp_enqueue_assets() {
    wp_enqueue_style('fcp-style', FCP_URL . 'css/style.css');
    wp_enqueue_script('fcp-script', FCP_URL . 'js/script.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'fcp_enqueue_assets');

// Include Functions
include_once FCP_DIR . 'includes/functions.php';

// Register shortcode for homepage
function fcp_homepage_grid() {
    ob_start();
    include FCP_DIR . 'templates/homepage.php';
    return ob_get_clean();
}
add_shortcode('finance_calculators_home', 'fcp_homepage_grid');

