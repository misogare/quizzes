<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mesvak.software
 * @since             1.0.0
 * @package           Quizzes
 *
 * @wordpress-plugin
 * Plugin Name:       quizz
 * Plugin URI:        https://mesvak.software
 * Description:       this is a quiz radio plugin with scoring system 
 * Version:           1.0.0
 * Author:            mesvak
 * Author URI:        https://mesvak.software/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quizzes
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
define( 'QUIZZES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-quizzes-activator.php
 */
 function activate_quizzes() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-quizzes-activator.php';
    Quizzes_Activator::activate();
 }
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-quizzes-deactivator.php
 */
function deactivate_quizzes() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-quizzes-deactivator.php';
    Quizzes_Deactivator::deactivate();

}
    
    /**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quizzes.php';

register_activation_hook( __FILE__, 'activate_quizzes' );
register_deactivation_hook( __FILE__, 'deactivate_quizzes' );


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_quizzes() {

	$plugin = new Quizzes();
	$plugin->run();

}
run_quizzes();
