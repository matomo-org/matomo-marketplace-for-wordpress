/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

import { Flex } from '@wordpress/components';
import { useState } from '@wordpress/element';
import useMarketplaceState from './marketplace-state.js';

const PluginFilters = ({ onFilterChange }) => {
    let [ showPluginsOrThemes, setShowPluginsOrThemes ] = useState('plugins');
    let [ sort, setSort ] = useState('last_updated');
    let [ search, setSearch ] = useState('');

    return (
        <Flex>
            <select>
                <option value="plugins">Plugins</option>
                <option value="themes">Themes</option>
            </select>

            <select>
                <option value="last_updated">Last Updated</option>
                <option value="popular">Popular</option>
                <option value="newest">Newest</option>
                <option value="alphabetically">Alphabetically</option>
            </select>

            <input
                type="text"
                value={search}
                placeholder={`Search ${showPluginsOrThemes === 'plugins' ? 'plugins' : 'themes'}...`}
            />
        </Flex>
    );
};

export default PluginFilters;
