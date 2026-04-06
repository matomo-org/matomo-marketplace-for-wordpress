/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

import domReady from '@wordpress/dom-ready';
import { createRoot, useMemo, useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import PluginGrid from './plugin-grid.js';
import PluginFilters from './plugin-filters.js';
import { searchPlugins } from './api.js';
import './install-plugins.scss';
import debounce from './debounce.js';

function isSortAscending( sort ) {
	return sort === 'displayName';
}

let currentQuery;

const searchUsingFilter = async ( setPlugins, { sort, search } ) => {
	currentQuery = {
		sort,
		search,
	};

	setPlugins( null );

	const searchResult = await searchPlugins( {
		type: 'plugins',
		search,
	} );

	if ( currentQuery.sort !== sort || currentQuery.search !== search ) {
		return;
	}

	if ( isSortAscending( sort ) ) {
		searchResult.sort( function ( lhs, rhs ) {
			if ( lhs[ sort ] === rhs[ sort ] ) {
				return 0;
			}
			return lhs[ sort ] < rhs[ sort ] ? -1 : 1;
		} );
	} else {
		searchResult.sort( function ( lhs, rhs ) {
			if ( lhs[ sort ] === rhs[ sort ] ) {
				return 0;
			}
			return rhs[ sort ] < lhs[ sort ] ? -1 : 1;
		} );
	}

	setPlugins( searchResult );
};

const MarketplacePage = () => {
	const [ plugins, setPlugins ] = useState( null );
	const [ sort, setSort ] = useState( 'lastUpdated' );
	const [ search, setSearch ] = useState( '' );

	const searchUsingFilterDebounced = useMemo( () =>
		debounce( searchUsingFilter.bind( null, setPlugins ), 300 )
	);

	// initialize search to URL query param if there is a value there
	useEffect( () => {
		const params = new URLSearchParams( document.location.search );
		const s = params.get( 'search' ).trim();
		if ( s.length ) {
			setSearch( s );
		}
	} );

	useEffect( () => {
		searchUsingFilterDebounced( { sort, search } );
		return () => {
			searchUsingFilterDebounced.cancel();
		};
	}, [ sort, search ] );

	return (
		<div className="matomo-marketplace-install-plugins">
			<h1>Marketplace</h1>

			<p style={ { margin: '2em 0' } }>
				{ __(
					"Expand Matomo's functionality with plugins. Start free trials for" +
						' premium plugins or directly install free plugins developed by the Matomo' +
						' community.',
					'matomo'
				) }
			</p>

			<PluginFilters
				sort={ sort }
				search={ search }
				onFilterChange={ ( { sort, search } ) => {
					setSort( sort );
					setSearch( search );
				} }
			/>

			<PluginGrid plugins={ plugins } />
		</div>
	);
};

domReady( () => {
	const rootElement = document.getElementById(
		'matomo-marketplace-for-wordpress'
	);
	const root = createRoot( rootElement );

	root.render( <MarketplacePage /> );
} );
