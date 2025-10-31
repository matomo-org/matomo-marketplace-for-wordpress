/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

import { Flex } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import debounce from './debounce.js';

const PluginFilters = ( { onFilterChange } ) => {
	const [ type, setType ] = useState( 'plugins' );
	const [ sort, setSort ] = useState( 'lastUpdated' );
	const [ search, setSearch ] = useState( '' );

	let debounced;
	if ( onFilterChange ) {
		debounced = debounce( onFilterChange, 800 );
	}

	// TODO: remove use of effect
	useEffect( () => {
		if ( debounced ) {
			debounced( { type, sort, search } );
		}
		// eslint-disable-next-line
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
				<option value="lastUpdated">Last Updated</option>
				<option value="numDownloads">Popular</option>
				<option value="createdDateTime">Newest</option>
				<option value="displayName">Alphabetically</option>
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
