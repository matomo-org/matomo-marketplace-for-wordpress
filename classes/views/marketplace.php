<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @package matomo
 */

use WpMatomo\Admin\Marketplace;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/** @var array $valid_tabs */
/** @var string|bool|null $active_tab */
/** @var \WpMatomo\Admin\Marketplace $matomoMarketplaceWpMatomo */
?>
<div class="wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2 class="nav-tab-wrapper">
        <?php if (in_array('marketplace', $valid_tabs, true)) { ?>
            <a href="?page=matomo-marketplace&tab=marketplace"
               class="nav-tab <?php echo ($active_tab === 'marketplace') ? 'nav-tab-active' : ''; ?>"
            ><?php esc_html_e( 'Overview', 'matomo-marketplace-for-wordpress' ); ?></a>
        <?php }?>
		<?php if (in_array('install', $valid_tabs, true)) { ?>
		    <a href="?page=matomo-marketplace&tab=install"
               class="nav-tab <?php echo ( $active_tab === 'install' ) ? 'nav-tab-active' : ''; ?>"
		    ><?php esc_html_e( 'Install Plugins', 'matomo-marketplace-for-wordpress' ); ?></a>
		<?php }?>
		<?php if ( in_array('subscriptions', $valid_tabs, true ) ) { ?>
			<a href="?page=matomo-marketplace&tab=subscriptions"
			   class="nav-tab <?php echo 'subscriptions' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Subscriptions', 'matomo-marketplace-for-wordpress' ); ?></a>
		<?php } ?>
	</h2>
	<?php if ( 'marketplace' === $active_tab ) {
		$matomoMarketplaceWpMatomo->show();
    } elseif ( 'install' === $active_tab ) {
		$plugins = array();

        $api = new MatomoMarketplaceApi();
        $apiPlugins = $api->get_plugins();

        if (!empty($apiPlugins)) {
            foreach ($apiPlugins as $plugin) {
                if (empty($plugin['isDownloadable'])) {
                    continue;
                }

                $plugins[] = array(
                    'name'               => $plugin['displayName'], // The plugin name.
                    'owner'              => $plugin['owner'],
                    'slug'               => $plugin['name'], // The plugin slug (typically the folder name).
                    'description'        => $plugin['description'], // The plugin slug (typically the folder name).
                    'source'             => $plugin['downloadUrl'], // The plugin source.
                    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                    'version'            => $plugin['latestVersion'], // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                    'external_url'       => !empty($plugin['homeUrl']) ? $plugin['homeUrl'] : '', // If set, overrides default API URL and points to an external URL.
                    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
                );
            }
        }

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'matomo-marketplace-for-wordpress',
			'default_path' => '',
			'menu'         => MATOMO_MARKETPLACE_SUBMENU_SLUG,
			'parent_slug'  => 'matomo',
			'capability'   => 'superuser_matomo',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => false,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'   => __( 'Install Plugins from the Matomo Marketplace', 'matomo-marketplace-for-wordpress' ),
				'return'       => __( 'Return to Matomo Marketplace Plugins Installer', 'matomo-marketplace-for-wordpress' ),
			)
		);

		tgmpa( $plugins, $config );

        /** @var \TGM_Plugin_Activation $tgmpa */
        $tgmpa = $GLOBALS['tgmpa'];
        if (!empty($tgmpa->plugins)) {
	        $tgmpa->plugins = array_filter($tgmpa->plugins, function ($plugin) {
		        return !empty($plugin['owner']);
	        });
        }
        $tgmpa->install_plugins_page();

     } elseif ( 'subscriptions' === $active_tab ) { ?>

		<h1><?php esc_html_e( 'Premium Feature Subscriptions', 'matomo-marketplace-for-wordpress' ); ?></h1>
		<p><?php esc_html_e( 'If you have purchased Matomo Premium Features, please enter your license key below.', 'matomo-marketplace-for-wordpress' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( MatomoMarketplaceAdmin::NONCE_LICENSE ); ?>

			<p>
				<label><?php esc_html_e( 'License key', 'matomo-marketplace-for-wordpress' ); ?></label>
				<input type="text" autocomplete="off" maxlength="80" name="<?php echo esc_attr( MatomoMarketplaceAdmin::FORM_NAME ); ?>" style="width:300px;">
				<br/>
				<br/>
				<input type="submit" class="button-primary"
					   value="<?php echo( ! empty( $matomo_license_key ) ? esc_attr__( 'Update License Key', 'matomo-marketplace-for-wordpress' ) : esc_attr__( 'Save License Key', 'matomo-marketplace-for-wordpress' ) ); ?>">

                <?php
                if (!empty($matomo_license_key)) {
                    ?><input type="submit" class="button-primary"
                            name="remove_license_key"
                             value="<?php echo esc_attr__( 'Remove License Key', 'matomo-marketplace-for-wordpress' ); ?>">
	                <?php
                }
                ?>
			</p>
		</form>

		<?php

		if ( ! empty( $matomo_license_key ) ) {
			$matomo_api      = new MatomoMarketplaceApi();
			$matomo_licenses = $matomo_api->get_licenses();
			?>
			<h2><?php esc_html_e( 'Your subscriptions', 'matomo-marketplace-for-wordpress' ); ?></h2>
			<p><?php esc_html_e( 'Here\'s a summary of your subscriptions.', 'matomo-marketplace-for-wordpress' ); ?>
				<?php
				echo sprintf(
					esc_html__( 'You can find all details, download Premium Features and change your subscriptions by %1$slogging in to your account on the Matomo Marketplace%2$s.', 'matomo-marketplace-for-wordpress' ),
					'<a rel="noreferrer noopener" target="_blank" href="https://shop.matomo.org/my-account/">',
					'</a>'
				);
				?>
			</p>
			<table class="widefat">
				<thead>
				<tr>
					<th><?php esc_html_e( 'Name', 'matomo-marketplace-for-wordpress' ); ?></th>
					<th><?php esc_html_e( 'Type', 'matomo-marketplace-for-wordpress' ); ?></th>
					<th><?php esc_html_e( 'Status', 'matomo-marketplace-for-wordpress' ); ?></th>
					<th><?php esc_html_e( 'Start date', 'matomo-marketplace-for-wordpress' ); ?></th>
					<th><?php esc_html_e( 'End date', 'matomo-marketplace-for-wordpress' ); ?></th>
					<th><?php esc_html_e( 'Next payment date', 'matomo-marketplace-for-wordpress' ); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ( $matomo_licenses as $matomo_license ) { ?>
					<tr>
						<td>
						<?php
                        $matomo_marketplace_is_license_valid = !empty($matomo_license['isValid']);
						if ( ! empty( $matomo_license['plugin']['htmlUrl'] ) ) {
							echo '<a href="' . esc_url( $matomo_license['plugin']['htmlUrl'] ) . '" target="_blank" rel="noreferrer noopener">';
						}
                        if ( ! empty( $matomo_license['plugin']['displayName'] ) ) {
	                        echo esc_html( $matomo_license['plugin']['displayName'] );
                        }
						if ( ! empty( $matomo_license['plugin']['htmlUrl'] ) ) {
							echo '</a>';
						}
						?>
						</td>
                        <td><?php
                            if( ! empty( $matomo_license['productType'] ) ) {
                                echo esc_html( $matomo_license['productType'] );
                            }
                            ?>
                        </td>
						<td><?php
                            if( ! empty( $matomo_license['status'] ) ) {
                                echo esc_html( $matomo_license['status'] );
                            }

                            if (!empty($matomo_license['isExceeded'])) {
                                echo 'The license is exceeded. There are possibly more sites on this WordPress installation than the subscription authorizes.';
                            }
						?></td>
						<td><?php echo( ! empty( $matomo_license['startDate'] ) ? esc_html( $matomo_license['startDate'] ) : '' ); ?></td>
						<td><?php
                            if ($matomo_marketplace_is_license_valid && ! empty( $matomo_license['nextPaymentDate'] )) {
                                echo 'License renews on next payment date';
							} elseif( ! empty( $matomo_license['endDate'] ) ) {
								echo esc_html( $matomo_license['endDate'] );
							}  ?></td>
						<td><?php echo( ! empty( $matomo_license['nextPaymentDate'] ) ? esc_html( $matomo_license['nextPaymentDate'] ) : '' ); ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<?php
		}
		?>

	<?php } ?>
</div>
