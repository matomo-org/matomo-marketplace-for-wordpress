/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

import { useState } from '@wordpress/element';

// TODO: this function is unnecessary
const useMarketplaceState = () => {
	const [ plugins, setPlugins ] = useState( null );

	return {
		plugins,
		setPlugins,
	};
};

export default useMarketplaceState;
