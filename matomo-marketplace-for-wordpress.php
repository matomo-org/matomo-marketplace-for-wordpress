<?php
/**
 * Plugin Name: Matomo Marketplace for WordPress
 * Description: Keep plugins from the Matomo Marketplace up to date in your WordPress with the convenience of a click. Get notified on new updates.
 * Author: Matomo
 * Author URI: https://matomo.org
 * Version: 0.1.0
 * Domain Path: /languages
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

load_plugin_textdomain( 'matomo-marketplace-for-wordpress', false, basename( dirname( __FILE__ ) ) . '/languages' );

if ( ! defined( 'MATOMO_MARKETPLACE_ANALYTICS_FILE' ) ) {
	define( 'MATOMO_MARKETPLACE_ANALYTICS_FILE', __FILE__ );
}

add_action('init', function () {
	if (empty($GLOBALS['MATOMO_MARKETPLACE_PLUGINS'])) {
		return;
	}

	$matomoMarketplacePlugins = $GLOBALS['MATOMO_MARKETPLACE_PLUGINS'];

	require 'vendor/autoload.php';

	$matomoSettings = WpMatomo::$settings;
	$license_key = $matomoSettings->get_license_key();

	$base_url    = 'https://plugins.matomo.org/api/2.0/wordpressUpdateCheck?plugin=';

	foreach ( $matomoMarketplacePlugins as $plugin_file ) {
		$plugin_name = dirname( plugin_basename($plugin_file) );
		$instance    = \Puc_v4_Factory::buildUpdateChecker(
			$base_url . urlencode($plugin_name),
			$plugin_file,
			$plugin_name
		);

		if ($license_key) {
			$instance->addQueryArgFilter( function ( $args ) use ( $license_key ) {
				$args['access_token'] = $license_key;
				return $args;
			} );
		}
	}
});
