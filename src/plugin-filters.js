/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

import { Flex } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';

const PluginFilters = ( { onFilterChange } ) => {
	let [ type, setType ] = useState( 'plugins' );
	let [ sort, setSort ] = useState( 'last_updated' );
	let [ search, setSearch ] = useState( '' );

	useEffect( () => {
		if ( onFilterChange ) {
			onFilterChange( { type, sort, search } );
		}
	}, [ type, sort, search ] );

	return (
		<Flex className="matomo-plugin-filters" justify="flex-start">
			<select
				value={ type }
				onChange={ ( e ) => setType( e.target.value ) }
			>
				<option value="plugins">Plugins</option>
				<option value="themes">Themes</option>
			</select>

			<select
				value={ sort }
				onChange={ ( e ) => setSort( e.target.value ) }
			>
				<option value="last_updated">Last Updated</option>
				<option value="popular">Popular</option>
				<option value="newest">Newest</option>
				<option value="alphabetically">Alphabetically</option>
			</select>

			<input
				type="text"
				value={ search }
				placeholder={ `Search ${
					type === 'plugins' ? 'plugins' : 'themes'
				}...` }
				onChange={ ( e ) => setSearch( e.target.value ) }
			/>
		</Flex>
	);
};

export default PluginFilters;
