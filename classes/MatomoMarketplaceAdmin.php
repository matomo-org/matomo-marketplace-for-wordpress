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

	private $valid_tabs = array( 'subscriptions' );

	public function register_hooks()
	{
		add_action( 'admin_menu', array( $this, 'add_menu' ), 9999 );
		add_action( 'network_admin_menu', array( $this, 'add_menu' ), 9999 );
		add_filter('http_request_args', array( $this, 'add_authentication_if_needed'), 10, 2);
	}

	public function add_authentication_if_needed($parsed_args, $url)
	{
		if (!empty($url)
		    && is_string($url)
		    && strpos($url, MATOMO_MARKETPLACE_ENDPOINT) === 0) {
			$api = new MatomoMarketplaceApi();
			$env_parameters = $api->get_environment_parameters();

			// we do this here for performance reasons so we request the environment parameters only when really needed
			// and not for example on each request when we make the update check URL
			foreach ($env_parameters as $parameter => $value) {
				$url = remove_query_arg($parameter, $url);
				$url = add_query_arg($parameter, $value, $url);
			}

			if (!empty($parsed_args['method']) && $parsed_args['method'] === 'GET') {
				$license_key = $api->get_license_key();
				// for premium features we may need to change it to POST so we can set the access token

				if (!empty($license_key)) {
					$parsed_args['method'] = 'POST';
					if (array_key_exists('body', $parsed_args) && is_array($parsed_args['body'])) {
						$parsed_args['body']['access_token'] = $license_key;
					} else {
						$parsed_args['body'] = array('access_token' => $license_key);
					}
				}
			}
		}

		return $parsed_args;
	}

	public function add_menu()
	{
		add_submenu_page( 'matomo', __( 'Marketplace', 'matomo-marketplace-for-wordpress' ), __( 'Marketplace', 'matomo-marketplace-for-wordpress' ), 'superuser_matomo', MATOMO_MARKETPLACE_SUBMENU_SLUG, array(
			$this,
			'show'
		) );
	}

	private function can_user_manage() {
		// only someone who can activate plugins is allowed to manage subscriptions
		if ( function_exists('is_multisite') && is_multisite() ) {
			return is_super_admin();
		}

		return current_user_can( Capabilities::KEY_SUPERUSER );
	}

	private function update_if_submitted() {
		if ( isset( $_POST )
			 && isset( $_POST[ self::FORM_NAME ] )
			 && is_admin()
			 && check_admin_referer( self::NONCE_LICENSE )
			 && $this->can_user_manage() ) {

			$value = '';
			$api = new MatomoMarketplaceApi();
			if ( $api->is_valid_api_key( $_POST[ self::FORM_NAME ] ) ) {
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
		if ( isset( $_GET['tab'] ) && in_array( $_GET['tab'], $this->valid_tabs, true ) ) {
			$active_tab = $_GET['tab'];
		}
		$can_view_subscription_tab = $this->can_user_manage();

		$api = new MatomoMarketplaceApi();
		$matomo_license_key = $api->get_license_key();

		include dirname( __FILE__ ) . '/views/marketplace.php';
	}

}
