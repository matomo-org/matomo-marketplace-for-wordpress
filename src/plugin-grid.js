/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
import { __experimentalGrid as Grid, Animate } from '@wordpress/components';
import PluginCard from './plugin-card.js';

const PluginGrid = ( { plugins } ) => {
	let children;
	if ( plugins === null ) {
		children = (
			<Animate type="loading">
				{ ( { className } ) => (
					<span className={ className }>Loading...</span>
				) }
			</Animate>
		);
	} else {
		children = plugins.map( ( p ) => (
			<PluginCard plugin={ p } key={ p.slug } />
		) );
	}

	return (
		<Grid
			alignment="stretch"
			columns={ 3 }
			gap={ 2 }
			children={ children }
		></Grid>
	);
};

export default PluginGrid;
