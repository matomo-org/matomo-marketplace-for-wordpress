<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @package matomo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // if accessed directly
}

class MatomoMarketplaceApi {
	private $endpoint = '';
	private $license_key_id = 'matomo_marketplace_license_key';

	public function __construct( ) {
		$this->endpoint = MATOMO_MARKETPLACE_ENDPOINT;
	}

	public function is_valid_api_key( $license_key ) {
		$looks_valid_format = ctype_alnum( $license_key )
							  && strlen( $license_key ) >= 40
							  && strlen( $license_key ) <= 80;
		if ( ! $looks_valid_format ) {
			return false;
		}

		if ( ! empty( $license_key ) ) {
			$result = $this->request_api(
				'consumer/validate',
				array(
					'access_token' => $license_key,
				)
			);

			return ! empty( $result['isValid'] );
		}

		return false;
	}

	private function is_multisite()
	{
		return function_exists('is_multisite') && is_multisite();
	}

	public function save_license_key($value) {
		if ( $this->is_multisite() ) {
			update_site_option( $this->license_key_id, $value );
		} else {
			update_option( $this->license_key_id, $value );
		}
	}

	public function get_license_key() {
		if ( $this->is_multisite() ) {
			return get_site_option( $this->license_key_id );
		}
		return get_option( $this->license_key_id );
	}

	public function get_environment_parameters() {
		global $wpdb;
		// we do not want to bootstrap entire Matomo here just to be on the safe side and not break anything
		// when installing/updating etc
		include_once plugin_dir_path(MATOMO_ANALYTICS_FILE) . 'app/core/Version.php';
		$num_blogs          = 1;
		if ( function_exists( 'get_blog_count' ) ) {
			$num_blogs = get_blog_count();
		}
		$params = array(
			'php' => PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '.' . PHP_RELEASE_VERSION,
			'matomo' => \Piwik\Version::VERSION,
			'mysql' => $wpdb->db_version(),
			'num_websites' => $num_blogs
		);
		return $params;
	}

	public function make_update_check_url($plugin_name) {
		return $this->endpoint . 'wordpress/plugins/'.rawurlencode($plugin_name).'/checkUpdate';
	}

	public function get_licenses() {
		$result = $this->request_api( 'consumer', array() );
		if ( ! empty( $result['licenses'] ) ) {
			return $result['licenses'];
		}

		return array();
	}

	public function get_plugins() {
		$result = $this->request_api( 'wordpress/plugins', array() );
		if ( ! empty( $result['plugins'] ) ) {
			return $result['plugins'];
		}

		return array();
	}

	private function request_api( $path, $request ) {
		$license_key = $this->get_license_key();

		if ( empty( $request['access_token'] ) &&  $license_key) {
			$request['access_token'] = $license_key;
		}

		if (strpos($path, '?') === false) {
			$path .= '?';
		} else {
			$path .= '&';
		}

		$path .= http_build_query($this->get_environment_parameters());

		$result = wp_remote_post(
			$this->endpoint . $path,
			array(
				'method'      => 'POST',
				'timeout'     => 30,
				'redirection' => 2,
				'body'        => $request,
			)
		);

		if ( is_wp_error( $result ) ) {
			throw new \Exception( $result->get_error_message() );
		}

		return json_decode( $result['body'], true );
	}
}
