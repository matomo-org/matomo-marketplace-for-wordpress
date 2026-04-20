/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';

export function searchPlugins( { type, search } ) {
	const path = addQueryArgs( '/matomo-marketplace-for-wordpress/v1/plugins', {
		type,
		search,
	} );
  console.log({ path });

  try {
	  return apiFetch( { path } );
  } catch ( e ) {
    console.log(e.stack || e.message || e);
    throw e;
  }
}
