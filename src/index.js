import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';

const MarketplacePage = () => {
	return <div></div>;
};

domReady( () => {
	const root = createRoot(
		document.getElementById( 'matomo-marketplace-for-wordpress' )
	);

	root.render( <MarketplacePage /> );
} );
