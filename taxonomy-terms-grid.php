<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://businessupwebsite.com
 * @since             1.0.0
 * @package           Taxonomy_Terms_Grid
 *
 * @wordpress-plugin
 * Plugin Name:       Taxonomy Terms Grid
 * Plugin URI:        https://wordpress.org/plugins/taxonomy-terms-grid
 * Description:       Create grid list from your taxonomy terms (e.g. post categories).
 * Version:           1.0.1
 * Author:            Ivan Chernyakov
 * Author URI:        https://businessupwebsite.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       taxonomy-terms-grid
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TAXONOMY_TERMS_GRID_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-taxonomy-terms-grid-activator.php
 */
function activate_taxonomy_terms_grid() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-taxonomy-terms-grid-activator.php';
	Taxonomy_Terms_Grid_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-taxonomy-terms-grid-deactivator.php
 */
function deactivate_taxonomy_terms_grid() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-taxonomy-terms-grid-deactivator.php';
	Taxonomy_Terms_Grid_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_taxonomy_terms_grid' );
register_deactivation_hook( __FILE__, 'deactivate_taxonomy_terms_grid' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-taxonomy-terms-grid.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_taxonomy_terms_grid() {

	$plugin = new Taxonomy_Terms_Grid();
	$plugin->run();

}
run_taxonomy_terms_grid();
