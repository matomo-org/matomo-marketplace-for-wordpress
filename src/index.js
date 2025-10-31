/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';
import PluginGrid from './plugin-grid.js';
import PluginFilters from './plugin-filters.js';
import useMarketplaceState from './marketplace-state.js';
import { searchPlugins } from './api.js';
import './install-plugins.scss';

function isSortAscending( sort ) {
	return sort === 'displayName';
}

let currentQuery;

const MarketplacePage = () => {
	const { plugins, setPlugins } = useMarketplaceState();

	return (
		<div className="matomo-marketplace-install-plugins">
			<h1>Marketplace</h1>

			<p style={ { margin: '2em 0' } }>
				Expand Matomo&#39;s functionality with plugins and change its
				appearance with themes. Start free trials for premium plugins or
				directly install free plugins and themes.
			</p>

			<PluginFilters
				onFilterChange={ async ( { type, sort, search } ) => {
					currentQuery = {
						type,
						sort,
						search,
					};

					setPlugins( null );

					const searchResult = await searchPlugins( {
						type,
						search,
					} );

					if (
						currentQuery.type !== type ||
						currentQuery.sort !== sort ||
						currentQuery.search !== search
					) {
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
				} }
			></PluginFilters>

			<PluginGrid plugins={ plugins } />
		</div>
	);
};

domReady( () => {
	const root = createRoot(
		document.getElementById( 'matomo-marketplace-for-wordpress' )
	);

	root.render( <MarketplacePage /> );
} );
