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

const MarketplacePage = () => {
    const state = useMarketplaceState();

	return (
		<div>
			<p style={ { margin: '2em 0' } }>
				Expand Matomo&#39;s functionality with plugins and change its
				appearance with themes. Start free trials for premium plugins or
				directly install free plugins and themes.
			</p>

            <PluginFilters></PluginFilters>

			<PluginGrid plugins={state.plugins} />
		</div>
	);
};

domReady( () => {
	const root = createRoot(
		document.getElementById( 'matomo-marketplace-for-wordpress' )
	);

	root.render( <MarketplacePage /> );
} );
