/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

import { Flex } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const PluginFilters = ( { onFilterChange, sort, search } ) => {
	return (
		<Flex className="matomo-plugin-filters" justify="flex-start">
			<select
				value={ sort }
				onChange={ ( e ) => {
					onFilterChange( { sort: e.target.value, search } );
				} }
			>
				<option value="lastUpdated">
					{ __( 'Last Updated', 'matomo' ) }
				</option>
				<option value="numDownloads">
					{ __( 'Popular', 'matomo' ) }
				</option>
				<option value="createdDateTime">
					{ __( 'Newest', 'matomo' ) }
				</option>
				<option value="displayName">
					{ __( 'Alphabetically', 'matomo' ) }
				</option>
			</select>

			<input
				type="text"
				value={ search }
				placeholder={ `${ __( 'Search plugins', 'matomo' ) }...` }
				onChange={ ( e ) => {
					onFilterChange( { search: e.target.value, sort } );
				} }
			/>
		</Flex>
	);
};

export default PluginFilters;
