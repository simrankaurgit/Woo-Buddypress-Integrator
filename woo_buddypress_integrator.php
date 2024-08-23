<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://woo.com
 * @since             1.0.0
 * @package           Woo_buddypress_integrator
 *
 * @wordpress-plugin
 * Plugin Name:       Woo-Buddypress-Integrator
 * Plugin URI:        https://woo.con
 * Description:       This plugin lets you integrate your Woocommerce account details to create a Buddypress profile
 * Version:           1.0.0
 * Author:            Simran Kaur
 * Author URI:        https://woo.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo_buddypress_integrator
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
define( 'WOO_BUDDYPRESS_INTEGRATOR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo_buddypress_integrator-activator.php
 */
function activate_woo_buddypress_integrator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo_buddypress_integrator-activator.php';
	Woo_buddypress_integrator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo_buddypress_integrator-deactivator.php
 */
function deactivate_woo_buddypress_integrator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo_buddypress_integrator-deactivator.php';
	Woo_buddypress_integrator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_buddypress_integrator' );
register_deactivation_hook( __FILE__, 'deactivate_woo_buddypress_integrator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo_buddypress_integrator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_buddypress_integrator() {

	$plugin = new Woo_buddypress_integrator();
	$plugin->run();

}
run_woo_buddypress_integrator();
