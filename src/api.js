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
  console.log(path);

  try {
	  const result = await apiFetch( { path } );
    console.log(JSON.stringify(result));
    return result;
  } catch ( e ) {
    console.log(e.stack || e.message || e);
    throw e;
  }
}
