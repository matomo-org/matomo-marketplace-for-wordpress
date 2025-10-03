<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @package matomo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var string $matomo_logo_big */
?>
<style>
	.matomo-marketplace-license-setup {
		width: 100%;
		max-width: 700px;
		background-color: white;
		box-shadow: 0 1px 2px rgba(0,0,0,.3);
		border-radius: 3px;
		padding-top: 48px;
		position: relative;
		margin: 32px auto 0 auto;
	}

	.matomo-marketplace-license-setup-header {
		position: absolute;
		border-top-left-radius: 3px;
		border-top-right-radius: 3px;
		top: 0;
		left: 0;
		right: 0;
		height: 48px;
		background-color: #e9e9e9;
	}

	.matomo-marketplace-license-setup-logo {
		top: -14px;
		left: calc(50% - 38px);
		position: absolute;
		border-radius: 50%;
		background-color: white;
		width: 72px;
		height: 72px;
		display: flex;
		align-items: center;
		justify-content: center;
		border: 2px solid #ccc;
	}

	.matomo-marketplace-license-setup-body {
		padding: 24px;
	}

	.matomo-marketplace-license-setup-logo img {
		width: 64px;
	}

	#license-key-input {
		min-width: 50%;
		border-radius: 0;
		border: 1px solid #ccc;
		margin-top: .8em;
		margin-left: 0;
	}

	.license-setup-step-text {
		font-size: 16px;
	}
</style>
<div class="matomo-marketplace-license-setup">
	<div class="matomo-marketplace-license-setup-header">
		<div class="matomo-marketplace-license-setup-logo">
			<img alt="Matomo Logo" src="<?php esc_attr_e( $matomo_logo_big ); ?>" />
		</div>
	</div>

	<div class="matomo-marketplace-license-setup-body">
		<h1><?php esc_html_e( 'Get your premium features license', 'matomo-marketplace-for-wordpress' ); ?></h1>

		<p>
			<?php echo sprintf( esc_html__( 'You can extend Matomo\'s capabilities using %1$sour premium plugins%2$s.', 'matomo-marketplace-for-wordpress' ), '<a href="https://plugins.matomo.org/premium?wp=1" target="_blank" rel="noreferrer noopener">', '</a>' ); ?>
		</p>

		<p>
			<?php esc_html_e( 'Using them requires a valid license key, which can be obtained in two ways: by starting a trial or purchasing a plugin subscription.', 'matomo-marketplace-for-wordpress' ); ?>
		</p>

		<p>
			<?php esc_html_e( 'Note: Your license key can be removed or changed after being added.', 'matomo-marketplace-for-wordpress' ); ?>
		</p>

		<p class="license-setup-step">
			<a class="license-setup-step-text" href="https://shop.matomo.org/my-account/" target="_blank" rel="noreferrer noopener">
				<?php esc_html_e( 'Step 1: Create a Marketplace Account', 'matomo-marketplace-for-wordpress' ); ?> »
			</a>
		</p>

		<p class="license-setup-step">
			<a class="license-setup-step-text" href="https://shop.matomo.org/my-account/downloads/" target="_blank" rel="noreferrer noopener">
				<?php esc_html_e( 'Step 2: Copy your License Key', 'matomo-marketplace-for-wordpress' ); ?> »
			</a>
		</p>

		<p class="license-setup-step">
			<span class="license-setup-step-text"><?php esc_html_e( 'Step 3: Enter it below:', 'matomo-marketplace-for-wordpress' ); ?></span>
			<br/>
			<form method="post">
				<?php wp_nonce_field( MatomoMarketplaceAdmin::NONCE_LICENSE ); ?>

				<input type="text" id="license-key-input"  placeholder="<?php esc_attr_e( 'License key...', 'matomo-marketplace-for-wordpress' ); ?>" autocomplete="off" maxlength="80" name="<?php echo esc_attr( MatomoMarketplaceAdmin::FORM_NAME ); ?>"/>
				<br/>
				<br/>
				<input type="submit" class="button-primary activate-license"
				   value="<?php esc_attr_e( 'Activate', 'matomo-marketplace-for-wordpress' ); ?>">
			</form>
		</p>
	</div>
</div>

