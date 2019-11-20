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

class MatomoMarketplaceTgmpa {

	public function customise_table_data ($table_data, $plugin) {
		$table_data['type'] = $plugin['owner'];
		$table_data['source'] = $plugin['description'];
		return $table_data;
	}

	public function customise_table_columns ($columns) {
		$columns['source'] = 'Description';
		$columns['type'] = 'Developer';
		return $columns;
	}

	public function register_hooks()
	{
		add_filter( 'tgmpa_table_data_item', array($this, 'customise_table_data'), 10, 2 );
		add_filter( 'tgmpa_table_columns', array($this, 'customise_table_columns'), 10, 1 );
	}

}
