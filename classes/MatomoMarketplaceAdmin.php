<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @package matomo
 */

use WpMatomo\Capabilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // if accessed directly
}

class MatomoMarketplaceAdmin {
	const NONCE_LICENSE = 'matomo_license';
	const FORM_NAME     = 'matomo_license_key';

	public function register_hooks()
	{
		add_action( 'admin_menu', array( $this, 'add_menu' ), 9999 );
		add_action( 'network_admin_menu', array( $this, 'add_menu' ), 9999 );
		add_filter( 'http_request_args', array( $this, 'add_authentication_if_needed'), 10, 2);
		add_filter( 'tgmpa_table_data_items', array( $this, 'sort_plugins'), 9999999, 1);
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'rest_api_init', [ $this, 'rest_api_init' ] );
	}

	public function rest_api_init() {
		register_rest_route(
			'matomo-marketplace-for-wordpress/v1',
			'/plugins',
			[
				'methods'             => 'GET',
				'callback'            => [ $this, 'search_plugins_rest' ],
				'permission_callback' => '__return_true',
			]
		);
	}

	public function search_plugins_rest( \WP_REST_Request $request ) {
		return $this->search_plugins( $request->get_param( 'type' ), $request->get_param( 'search' ) );
	}

	public function search_plugins( $type = 'plugins', $search = '' ) {
		$matomo_mwp_plugins = [];

		$api = new MatomoMarketplaceApi();
		$apiPlugins = $api->get_available_plugins( $type, $search );

		if (!empty($apiPlugins)) {
			foreach ($apiPlugins as $plugin) {
				if ( empty( $plugin['owner'] ) ) {
					continue;
				}

				$install_url = $this->get_tgmpa_url();
				$install_url = add_query_arg(
					array(
						'plugin'        => urlencode( $plugin['name'] ),
						'tgmpa-install' => 'install-plugin',
						'tgmpa-nonce'   => wp_create_nonce( 'tgmpa-install' ),
						'tab'           => 'install',
					),
					$install_url
				);

				$unknown = __( 'Unknown', 'matomo-marketplace-for-wordpress' );

				$matomo_mwp_plugins[] = array(
					'name'               => isset( $plugin['displayName'] ) ? $plugin['displayName'] : $unknown,
					'owner'              => isset( $plugin['owner'] ) ? $plugin['owner'] : $unknown,
					'slug'               => isset( $plugin['name'] ) ? $plugin['name'] : $unknown,
					'description'        => isset( $plugin['description'] ) ? $plugin['description'] : $unknown,
					'source'             => isset( $plugin['downloadUrl'] ) ? $plugin['downloadUrl'] : null, // The plugin source.
					'required'           => false, // If false, the plugin is only 'recommended' instead of required.
					'version'            => isset( $plugin['latestVersion'] ) ? $plugin['latestVersion'] : null, // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
					'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
					'external_url'       => !empty($plugin['homeUrl']) ? $plugin['homeUrl'] : '', // If set, overrides default API URL and points to an external URL.
					'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
					'is_downloadable'    => isset( $plugin['isDownloadable'] ) ? $plugin['isDownloadable'] : false,
					'add_to_cart_url'    => isset( $plugin['addToCartUrl'] ) ? $plugin['addToCartUrl'] : null,
					'cover_image_url'    => isset( $plugin['coverImage'] ) ? $plugin['coverImage'] : null,
					'pretty_price'       => isset( $plugin['prettyPrice'] ) ? $plugin['prettyPrice'] : null,
					'price_period'       => isset( $plugin['pricePeriod'] ) ? $plugin['pricePeriod'] : null,
					'lastUpdated'        => isset( $plugin['lastUpdated'] ) ? $plugin['lastUpdated'] : null,
					'numDownloads'       => isset( $plugin['numDownloads'] ) ? $plugin['numDownloads'] : 0,
					'createdDateTime'    => isset( $plugin['createdDateTime'] ) ? $plugin['createdDateTime'] : null,
					'displayName'        => isset( $plugin['displayName'] ) ? $plugin['displayName'] : '',
					'installUrl'         => $install_url,
					'isInstalled'		 => is_file( WP_PLUGIN_DIR . '/' . $plugin['name'] . '/' . $plugin['name'] . '.php' ),
				);
			}
		}

		return $matomo_mwp_plugins;
	}

	public function admin_enqueue_scripts( $admin_page )
	{
		if (
			'matomo-analytics_page_' . MATOMO_MARKETPLACE_SUBMENU_SLUG !== $admin_page
			&& (
				empty( $_REQUEST['tab'] )
				|| 'tab' !== $_REQUEST['tab']
			)
		) {
			return;
		}

		$asset_file = plugin_dir_path( MATOMO_MARKETPLACE_ANALYTICS_FILE ) . 'build/index.asset.php';

		if ( ! is_file( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'matomo-marketplace-for-wordpress-script',
			plugins_url( 'build/index.js', MATOMO_MARKETPLACE_ANALYTICS_FILE ),
			$asset['dependencies'],
			$asset['version'],
			[ 'in_footer' => true ]
		);

		wp_enqueue_style(
			'matomo-marketplace-for-wordpress-style',
			plugins_url( 'build/index.css', MATOMO_MARKETPLACE_ANALYTICS_FILE ),
			array_filter(
				$asset['dependencies'],
				function ( $style ) {
					return wp_style_is( $style, 'registered' );
				}
			),
			$asset['version']
    	);

		wp_set_script_translations(
			'matomo-marketplace-for-wordpress-script',
			'matomo',
			plugin_dir_path( __FILE__ ) . 'languages'
		);
	}

	public function sort_plugins($items)
	{
		$type = array();
		$name = array();

		foreach ( $items as $i => $plugin ) {
			$type[ $i ] = $plugin['type']; // Required / recommended.
			$name[ $i ] = $plugin['sanitized_plugin'];
		}

		array_multisort( $name, SORT_ASC, $type, SORT_DESC, $items );

		return $items;
	}

	public function add_authentication_if_needed($parsed_args, $url)
	{
		if (!empty($url)
		    && is_string($url)
		    && strpos($url, MATOMO_MARKETPLACE_ENDPOINT) === 0) {
			$parsed_args['method'] = 'POST';

			$api = new MatomoMarketplaceApi();
			$env_parameters = $api->get_environment_parameters();

			// we do this here for performance reasons so we request the environment parameters only when really needed
			// and not for example on each request when we make the update check URL
			foreach ($env_parameters as $parameter => $value) {
				if (array_key_exists('body', $parsed_args) && is_array($parsed_args['body'])) {
					$parsed_args['body'][$parameter] = rawurlencode($value);
				} else {
					$parsed_args['body'] = array($parameter => rawurlencode($value));
				}
			}

			$license_key = $api->get_license_key();
			// for premium features we may need to change it to POST so we can set the access token

			if (!empty($license_key)) {
				if (array_key_exists('body', $parsed_args) && is_array($parsed_args['body'])) {
					$parsed_args['body']['access_token'] = $license_key;
				} else {
					$parsed_args['body'] = array('access_token' => $license_key);
				}
			}
		}

		return $parsed_args;
	}

	public function add_menu()
	{
		if ( ! is_plugin_active( 'matomo/matomo.php' ) ) {
			return;
		}

		$capability = 'view_matomo';
		if ( $this->is_multisite() ) {
			$capability = 'superuser_matomo';
		}

		add_submenu_page(
			'matomo',
			__( 'Marketplace', 'matomo-marketplace-for-wordpress' ),
			__( 'Marketplace', 'matomo-marketplace-for-wordpress' ),
			$capability,
			MATOMO_MARKETPLACE_SUBMENU_SLUG,
			[ $this, 'show' ],
			5
		);
	}

	private function can_user_manage() {
		// only someone who can activate plugins is allowed to manage subscriptions
		if ( $this->is_multisite() ) {
			return is_super_admin();
		}

		return current_user_can( Capabilities::KEY_SUPERUSER );
	}

	private function is_multisite() {
		return function_exists('is_multisite') && is_multisite();
	}

	private function update_if_submitted() {
		if ( isset( $_POST )
			 && isset( $_POST[ self::FORM_NAME ] )
			 && is_admin()
			 && check_admin_referer( self::NONCE_LICENSE )
			 && $this->can_user_manage() ) {

			$value = '';
			$api = new MatomoMarketplaceApi();
			if (!empty($_POST['remove_license_key'])) {
				$value = '';
			} elseif ( $api->is_valid_api_key( $_POST[ self::FORM_NAME ] ) ) {
				$value = $_POST[ self::FORM_NAME ];
			} else {
				echo '<div class="error"><p>' . esc_html__( 'License key is not valid', 'matomo-marketplace-for-wordpress' ) . '</p></div>';
			}

			$api->save_license_key($value);
		}
	}

	public function show() {
		$this->update_if_submitted();

		$active_tab = '';
		$valid_tabs[] = array();

		if ($this->can_user_manage()) {
			if (current_user_can( 'install_plugins' )) {
				$active_tab = 'install';
				$valid_tabs[] = 'install';
			}
			$valid_tabs[] = 'subscriptions';
		}

		if ( isset( $_GET['tab'] )
		     && in_array( $_GET['tab'], $valid_tabs, true ) ) {
			$active_tab = $_GET['tab'];
		}

		if (
			$this->is_tgmpa_action()
			&& in_array('install', $valid_tabs)
			&& $active_tab !== 'subscriptions'
		) {
			// we need to force the install tab... to guarantee tgmpa works... as it is using the slug but can't add
			// another URL parameter automatically like `&tab=install`. If we didn't force the tab, then the tgmpa
			// code wouldn't be executed and it would not install or update a plugin
			$active_tab = 'install';
		}

		$api = new MatomoMarketplaceApi();
		$matomo_license_key = $api->get_license_key();

		$matomo_logo_big = plugins_url( 'assets/img/logo-big.png', MATOMO_MARKETPLACE_ANALYTICS_FILE );

		$matomo_is_tgmpa_admin_action = $this->is_tgmpa_action();

		try {
			$matomo_mwp_plugins = $this->search_plugins();
		} catch ( \Exception $e ) {
			$matomo_error = $e->getMessage();
			error_log( 'Failed to connect to Matomo Marketplace API: ' . $matomo_error );
		}

		include dirname( __FILE__ ) . '/views/marketplace.php';
	}

	private function is_tgmpa_action()
	{
		$tgmpa_params = [
			'tgmpa-install',
			'tgmpa-update',
			'plugin_status',
			'tgmpa-nonce',
			'plugin',
			'_wpnonce',
			'nonce',
		];

		foreach ( $tgmpa_params as $param ) {
			if (
				isset( $_GET[ $param ] )
				|| isset( $_POST[ $param ] )
			) {
				return true;
			}
		}

		return false;
	}

	private function get_tgmpa_url() {
		static $url;

		if ( ! isset( $url ) ) {
			$parent = 'admin.php';
			$url = add_query_arg(
				array(
					'page' => urlencode( 'matomo-marketplace' ),
				),
				self_admin_url( $parent )
			);
		}

		return $url;
	}
}
