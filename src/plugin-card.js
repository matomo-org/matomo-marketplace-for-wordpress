/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

// eslint-disable-next-line import/no-extraneous-dependencies
import * as React from 'react';
import { useState } from '@wordpress/element';
import {
	Card,
	CardBody,
	CardMedia,
	Flex,
	Spinner,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import './plugin-card.scss';

const DownloadButton = ( { plugin } ) => {
	const [ isDownloading, setIsDownloading ] = useState( false );

	let buttonText = plugin.is_downloadable
		? __( 'Download', 'matomo' )
		: __( 'Start free trial', 'matomo' );

	let buttonUrl;
	if ( plugin.is_downloadable ) {
		buttonUrl = plugin.installUrl;
	} else {
		buttonUrl = plugin.add_to_cart_url || plugin.external_url;
	}

	if ( plugin.isInstalled ) {
		buttonUrl = '';
		buttonText = __( 'Installed', 'matomo' );
	}

	return (
		<a
			href={ buttonUrl }
			target={ plugin.is_downloadable ? '' : '_blank' }
			rel={ plugin.is_downloadable ? '' : 'noreferrer noopener' }
			onClick={ () => plugin.is_downloadable && setIsDownloading( true ) }
		>
			<button
				className="button-primary purchaseable"
				title={ buttonText }
				disabled={
					plugin.isInstalled || isDownloading ? 'disabled' : ''
				}
			>
				{ buttonText }
				{ isDownloading && <Spinner /> }
			</button>
		</a>
	);
};

const PluginCard = ( { plugin } ) => {
	const { pluginUrl } = window.matomoMarketplaceForWordpressData;

	return (
		<Card className="matomo-plugin-card" data-plugin-slug={ plugin.slug }>
			<React.Fragment key=".0">
				<Flex direction="column">
					<CardMedia>
						<img
							src={ plugin.cover_image_url }
							alt=""
							className="cover-image"
						/>
					</CardMedia>
					<CardBody style={ { flex: 1 } }>
						<Flex direction="column">
							<div
								className="card-content-top"
								style={ { flex: 1 } }
							>
								<div className="price">
									{ plugin.pretty_price
										? `${ ( __( 'From' ), 'matomo' ) } ${
												plugin.pretty_price
										  } / ${ plugin.price_period }`
										: __( 'Free', 'matomo' ) }
								</div>

								<a
									className="card-title-link"
									href={ `${ plugin.external_url }?wp=1&source=wordpress` }
									target="_blank"
									rel="noreferrer noopener"
									tabIndex="0"
								>
									<div className="card-focus"></div>
									<h2 className="card-title">
										{ plugin.name }
										<span className="card-title-chevron">
											&nbsp;›
										</span>
									</h2>
								</a>

								<p className="card-description">
									{ plugin.description }
								</p>
							</div>
							<div className="card-content-bottom">
								<div className="owner">
									{ __( 'Created by', 'matomo' ) }{ ' ' }
									<span> { plugin.owner }</span>
								</div>
								<Flex justify="space-between">
									<div className="cta-container">
										<DownloadButton plugin={ plugin } />
									</div>
									<img
										className="matomo-badge matomo-badge-bottom"
										src={ `${ pluginUrl }/app/plugins/Marketplace/images/matomo-badge.png` }
										aria-label="Matomo plugin"
										alt=""
									/>
								</Flex>
							</div>
						</Flex>
					</CardBody>
				</Flex>
			</React.Fragment>
		</Card>
	);
};

export default PluginCard;
