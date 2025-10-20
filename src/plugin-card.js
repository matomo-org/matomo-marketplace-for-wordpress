/**
 * Matomo - free/libre analytics platform
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

// eslint-disable-next-line import/no-extraneous-dependencies
import * as React from 'react';
import { Card, CardBody, CardMedia, Flex } from '@wordpress/components';
import './plugin-card.scss';

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
										? `From ${ plugin.pretty_price } / ${ plugin.price_period }`
										: 'Free' }
								</div>

								<a
									className="card-title-link"
									href={ plugin.external_url }
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
									Created by <span> { plugin.owner }</span>
								</div>
								<Flex justify="space-between">
									<div className="cta-container">
										<div
											className="button-primary purchaseable"
											title="Start free trial"
										>
											Start free trial
										</div>
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

// TODO: translations

export default PluginCard;

/*
                    <!--
                    -->

<div class="col s12 m6 l4">

    <div class="card-holder">
        <div class="card">
            <div class="card-content">

                <div class="content-container">
                    <div class="card-content-top"><img class="matomo-badge matomo-badge-top" src="plugins/Marketplace/images/matomo-badge.png" aria-label="Matomo plugin" alt="">
                    </div>
                    <div class="card-content-bottom">
                        <!---->
                </div>
            </div>
        </div>
    </div>
</div>
 */
