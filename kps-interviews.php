<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              srs-kps-interviews
 * @since             1.0.0
 * @package           Kps_Interviews
 *
 * @wordpress-plugin
 * Plugin Name:       KPS Interviews
 * Plugin URI:        kps-interviews
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Shriramsoft
 * Author URI:        srs-kps-interviews
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kps-interviews
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('KPS_INTERVIEWS_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kps-interviews-activator.php
 */
function activate_kps_interviews()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-kps-interviews-activator.php';
	Kps_Interviews_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kps-interviews-deactivator.php
 */
function deactivate_kps_interviews()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-kps-interviews-deactivator.php';
	Kps_Interviews_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_kps_interviews');
register_deactivation_hook(__FILE__, 'deactivate_kps_interviews');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-kps-interviews.php';

/**
 * Plugin Dependencies 
 */
require_once plugin_dir_path(__FILE__) . '/includes/TGM-Plugin-Activation/plugin-dependacies.php';


/**
 * Import CSV Files
 */
require_once plugin_dir_path(__FILE__) . '/includes/import_csv_files.php';



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kps_interviews()
{

	$plugin = new Kps_Interviews();
	$plugin->run();
}
run_kps_interviews();
