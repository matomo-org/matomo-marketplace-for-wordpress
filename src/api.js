/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';

export async function searchPlugins( { type, search } ) {
	const path = addQueryArgs( '/matomo-marketplace-for-wordpress/v1/plugins', {
		type,
		search,
	} );

  return await apiFetch( { path } );
}
