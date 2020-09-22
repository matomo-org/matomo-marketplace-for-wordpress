<?php
/**
 * Plugin Name: Matomo Marketplace for WordPress
 * Description: Keep plugins from the Matomo Marketplace up to date in your WordPress with the convenience of a click. Get notified on new updates.
 * Author: Matomo
 * Author URI: https://matomo.org
 * Version: 1.0.8
 *
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @package matomo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // if accessed directly
}

if ( ! defined( 'MATOMO_MARKETPLACE_ANALYTICS_FILE' ) ) {
	define( 'MATOMO_MARKETPLACE_ANALYTICS_FILE', __FILE__ );
}
if ( ! defined( 'MATOMO_MARKETPLACE_ENDPOINT' ) ) {
	define( 'MATOMO_MARKETPLACE_ENDPOINT', 'https://plugins.matomo.org/api/2.0/' );
}
if (!defined('MATOMO_MARKETPLACE_SUBMENU_SLUG')) {
	// should match \WpMatomo\Admin\Menu::SLUG_MARKETPLACE
	define('MATOMO_MARKETPLACE_SUBMENU_SLUG', 'matomo-marketplace');
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require __DIR__ . '/vendor/autoload.php';
} else {
	require 'vendor/autoload.php';
}

require 'vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php';

add_action('init', function () {

	Puc_v4_Factory::buildUpdateChecker(
		'https://builds.matomo.org/matomo-marketplace-for-wordpress.json',
		__FILE__,
		'matomo-marketplace-for-wordpress'
	);

	if (empty($GLOBALS['MATOMO_MARKETPLACE_PLUGINS'])) {
		return;
	}

	// we provide two ways to update a plugin... this one has the advantage that an update appears in the wordpress updater
	// in the dashboard and user gets notified.... it cannot install plugins though
	// so we're using an installer lib which also provides update functionality...

	$matomoMarketplacePlugins = $GLOBALS['MATOMO_MARKETPLACE_PLUGINS'];

	$api = new MatomoMarketplaceApi();

	foreach ( $matomoMarketplacePlugins as $plugin_file ) {
		$plugin_name = dirname( plugin_basename($plugin_file) );

		$update_check_url = $api->make_update_check_url($plugin_name);

		\Puc_v4_Factory::buildUpdateChecker(
			$update_check_url,
			$plugin_file,
			$plugin_name
		);
	}
});

include 'classes/MatomoMarketplaceAdmin.php';
include 'classes/MatomoMarketplaceApi.php';
include 'classes/MatomoMarketplaceTgmpa.php';

$matomo_marketplace_admin = new MatomoMarketplaceAdmin();
$matomo_marketplace_admin->register_hooks();

$matomo_marketplace_tgmpa = new MatomoMarketplaceTgmpa();
$matomo_marketplace_tgmpa->register_hooks();
