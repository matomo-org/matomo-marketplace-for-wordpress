/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

import { useState } from '@wordpress/element';

const useMarketplaceState = () => {
    const [ plugins, setPlugins ] = useState( window.matomoMarketplaceForWordpressData.plugins );

    return {
        plugins,
        setPlugins,
    };
};

export default useMarketplaceState;

