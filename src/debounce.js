const DEFAULT_DEBOUNCE_DELAY = 300;

export default function debounce( fn, delayInMs = DEFAULT_DEBOUNCE_DELAY ) {
	let timeout = null;

	const debounced = function wrapper( ...args ) {
		if ( timeout ) {
			clearTimeout( timeout );
		}

		timeout = setTimeout( () => {
			fn.call( this, ...args );
		}, delayInMs );
	};

	debounced.cancel = () => clearTimeout( timeout );

	return debounced;
}
