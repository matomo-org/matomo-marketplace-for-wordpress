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

	.matomo-marketplace-license-setup .wizard-steps-header {
		display: flex;
		flex-direction: row;
		align-items: flex-start;
	}

	.matomo-marketplace-license-setup .wizard-steps-header .step-title {
		text-transform: uppercase;
		flex: 1;
		color: #888;
	}

	.matomo-marketplace-license-setup .wizard-steps-header .divider {
		width: 33px;
	}

	.matomo-marketplace-license-setup .wizard-steps {
		display: flex;
		flex-direction: row;
		align-items: stretch;
	}

	.matomo-marketplace-license-setup .wizard-steps .step {
		flex: 1;
		padding-right: 32px;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		align-items: flex-start;
		padding-bottom: 6px;
	}

	.matomo-marketplace-license-setup .wizard-steps .divider {
		width: 1px;
		background-color: #aaa;
		margin: 0 16px;
	}

	.matomo-marketplace-license-setup .wizard-footer p{
		font-size: 0.9em;
		margin-top: 24px;
	}

	#license-key-input {
		min-width: 50%;
		border-radius: 0;
		border: 1px solid #ccc;
	}
</style>
<script>
	// TODO
</script>
<div class="matomo-marketplace-license-setup">
	<div class="matomo-marketplace-license-setup-header">
		<div class="matomo-marketplace-license-setup-logo">
			<img alt="Matomo Logo" src="<?php echo esc_attr( $matomo_logo_big ); ?>" />
		</div>
	</div>

	<div class="matomo-marketplace-license-setup-body">
		<h1><?php esc_html_e( 'Get your premium features license', 'matomo' ); ?></h1>

		<p class="license-setup-step">
			<a href="https://shop.matomo.org/my-account/" target="_blank" rel="noreferrer noopener">
				<?php esc_html_e( 'Step 1: Create a Marketplace Account', 'matomo' ); ?> »
			</a>
		</p>

		<p class="license-setup-step">
			<a href="https://shop.matomo.org/my-account/downloads/" target="_blank" rel="noreferrer noopener">
				<?php esc_html_e( 'Step 2: Copy your License Key', 'matomo' ); ?> »
			</a>
		</p>

		<p class="license-setup-step">
			<span><?php esc_html_e( 'Step 3: Enter it below:', 'matomo' ); ?></span>
			<br/>
			<input style="margin-top: .8em;" type="text" id="license-key-input" placeholder="<?php esc_attr_e( 'License key...', 'matomo' ); ?>" />
		</p>
	</div>
</div>

