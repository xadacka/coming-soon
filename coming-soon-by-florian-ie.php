<?php
/**
 * Plugin Name:       Coming Soon by florian.ie
 * Plugin URI:        https://florian.ie
 * Description:       Displays a coming soon page for your website.
 * Version:           1.1.0
 * Author:            Florian
 * Author URI:        https://florian.ie
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       coming-soon-by-florian-ie
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'CSBF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once CSBF_PLUGIN_PATH . 'includes/class-coming-soon-by-florian-ie-options.php';
require_once CSBF_PLUGIN_PATH . 'includes/class-coming-soon-by-florian-ie.php';

function csbf_run_plugin() {
    $options = new Coming_Soon_By_Florian_IE_Options();
    $options->init();

    $plugin = new Coming_Soon_By_Florian_IE();
    $plugin->init();
}
csbf_run_plugin(); 