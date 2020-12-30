<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              .
 * @since             1.0.0
 * @package           Wprem_Careers
 *
 * @wordpress-plugin
 * Plugin Name:       WPREM Careers
 * Plugin URI:        http://business.yellowpages.ca
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.1.1
 * Author:            Imran Lakhani
 * Author URI:        .
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wprem-careers
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
define('WPREM_CAREERS_VERSION', '1.0.1');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wprem-careers-activator.php
 */
function activate_wprem_careers()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wprem-careers-activator.php';
    Wprem_Careers_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wprem-careers-deactivator.php
 */
function deactivate_wprem_careers()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wprem-careers-deactivator.php';
    Wprem_Careers_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wprem_careers');
register_deactivation_hook(__FILE__, 'deactivate_wprem_careers');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-wprem-careers.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wprem_careers()
{

    $plugin = new Wprem_Careers();
    $plugin->run();

}
run_wprem_careers();

require get_stylesheet_directory() . '/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://webprem@bitbucket.org/webprem/wprem-careers', //(repo minus .git)
    __FILE__,
    'wprem-careers' //(repo slug)
);

$myUpdateChecker->setAuthentication(array(
    'consumer_key' => 'CvNncrGZUyHnxqPXau',
    'consumer_secret' => 'Y5AC8ZKrkPjdskRLaVnRZxCdGkbJzdkL',
));

$myUpdateChecker->setBranch('master');

// force use of templates from plugin folder
function single_wprem_careers($template)
{
    if (is_singular('wprem_careers')) {
        $template = WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)) . '/single-wprem_careers.php';
    }
    return $template;
}
add_filter('template_include', 'single_wprem_careers');
