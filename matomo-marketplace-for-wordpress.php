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

define('MATOMO_MARKETPLACE_SUBMENU_SLUG', 'matomo-install-plugins');

require 'vendor/autoload.php';

add_filter( 'tgmpa_table_data_item', 'matomo_mfw_tgmpa_table_data_item', 10, 2 );

function matomo_mfw_tgmpa_table_data_item( $table_data, $plugin ) {
	$table_data['source'] = 'Matomo Marketplace';
	$table_data['type'] = $plugin['description'];
	return $table_data;
}

add_filter( 'tgmpa_table_columns', 'matomo_mfw_tgmpa_table_columns' );

function matomo_mfw_tgmpa_table_columns( $columns ) {
	$columns['type'] = 'Description';
	unset($columns['source']);
	return $columns;
}

add_action( 'tgmpa_register', 'matomo_mfw_register_required_plugins' );

add_filter('http_request_args', function ($parsed_args, $url) {
	if (!empty($url) && is_string($url) && strpos($url, 'https://plugins.matomo.org') === 0) {
		if (is_plugin_active('matomo/matomo.php') && !empty($parsed_args['method']) && $parsed_args['method'] === 'GET') {
			$matomo_settings = WpMatomo::$settings;
			$license_key = $matomo_settings->get_license_key();
			// for premium features we may need to change it to POST so we can set the access token

			if (!empty($license_key)) {
				$parsed_args['method'] = 'POST';
				$parsed_args['body'] = array('access_token' => $license_key);
			}
		}
	}

	return $parsed_args;
}, 10, 2);

function matomo_mfw_register_required_plugins () {

	$plugins = array();

	if (is_admin()
	    && !empty($_SERVER['REQUEST_URI'])
	    && strpos($_SERVER['REQUEST_URI'], MATOMO_MARKETPLACE_SUBMENU_SLUG) !== false) {
		// we don't want to fetch marketplace on every admin page... only if we are on that specific page...

		$domain = 'https://plugins.matomo.org';
		$base_url = $domain . '/api/2.0/plugins';

		$params = array(
			'method'      => 'GET',
			'timeout'     => 60,
			'redirection' => 3,
		);

		$result = wp_remote_post($base_url, $params	);
		if (!empty($result['body'])) {
			$result = json_decode($result['body'], true);
		}


		if (!empty($result['plugins'])) {
			foreach ($result['plugins'] as $plugin) {
				if (empty($plugin['isDownloadable'])) {
					continue;
				}

				$download_url = $base_url. '/' . rawurlencode($plugin['name']) . '/download/latest';

				$plugins[] = array(
					'name'               => $plugin['displayName'], // The plugin name.
					'slug'               => $plugin['name'], // The plugin slug (typically the folder name).
					'description'        => $plugin['description'], // The plugin slug (typically the folder name).
					'source'             => $download_url, // The plugin source.
					'required'           => false, // If false, the plugin is only 'recommended' instead of required.
					'version'            => $plugin['latestVersion'], // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => $domain . '/' . rawurlencode($plugin['name']), // If set, overrides default API URL and points to an external URL.
					'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
				);
			}
		}

	}


	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'matomo-marketplace-for-wordpress',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => MATOMO_MARKETPLACE_SUBMENU_SLUG, // Menu slug.
		'parent_slug'  => 'matomo',            // Parent menu slug.
		'capability'   => \WpMatomo\Capabilities::KEY_SUPERUSER,    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => false,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'   => __( 'Install Plugins from the Matomo Marketplace', 'matomo-marketplace-for-wordpress' ),
			'return'       => __( 'Return to Matomo Marketplace Plugins Installer', 'matomo-marketplace-for-wordpress' ),
		)

		/*
		'strings'      => array(
			'menu_title'                      => __( 'Install Plugins', 'matomo-marketplace-for-wordpress' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'matomo-marketplace-for-wordpress' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'matomo-marketplace-for-wordpress' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'matomo-marketplace-for-wordpress' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'matomo-marketplace-for-wordpress'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'matomo-marketplace-for-wordpress'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'matomo-marketplace-for-wordpress'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'matomo-marketplace-for-wordpress'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'matomo-marketplace-for-wordpress'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'matomo-marketplace-for-wordpress'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'matomo-marketplace-for-wordpress'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'matomo-marketplace-for-wordpress'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'matomo-marketplace-for-wordpress'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'matomo-marketplace-for-wordpress' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'matomo-marketplace-for-wordpress' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'matomo-marketplace-for-wordpress' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'matomo-marketplace-for-wordpress' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'matomo-marketplace-for-wordpress' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'matomo-marketplace-for-wordpress' ),
			'dismiss'                         => __( 'Dismiss this notice', 'matomo-marketplace-for-wordpress' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'matomo-marketplace-for-wordpress' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'matomo-marketplace-for-wordpress' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );

	if (empty($plugins)) {
		add_action( 'admin_menu', function () {
			// still ensure we show link to admin when not on install page (and no plugins are there)
			/** @var \TGM_Plugin_Activation $tgmpa */
			$tgmpa = $GLOBALS['tgmpa'];
			$tgmpa->admin_menu();
		} );
	}
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