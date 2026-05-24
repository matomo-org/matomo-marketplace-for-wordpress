<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @package matomo
 */

use WpMatomo\Admin\Marketplace\PopularFeatures;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var string $matomo_logo_big */
?>
<style>
	#matomo-marketplace-license-setup {
		background-color: white;
		padding: 2em 1.5em;
		border-radius: 6px;
	}

	.matomo-steps {
		justify-content: space-between;
	}

	.matomo-step:first-child {
		margin-left: 0;
	}

	.step-title {
		font-weight: bold;
		font-size: 14px;
	}

	.matomo-step > p {
		margin-bottom: 1.5em;
		color: #6a6a6a;
	}

	#license-key-input {
		min-height: 30px;
		display: inline-block;
		margin-bottom: 2em;
	}
</style>

<h1><?php matomo_header_icon(); ?><?php esc_html_e( 'Unlock premium features', 'matomo-marketplace-for-wordpress' ); ?></h1>

<p>
	<?php esc_html_e( 'Extend Matomo\'s capabilities with advanced analytics features.', 'matomo-marketplace-for-wordpress' ); ?>
</p>

<div class="matomo-steps" id="matomo-marketplace-license-setup">
	<div class="matomo-step">
		<div>
			<span class="step-number current matomo-primary-color-bg">1</span>
			<span class="step-title"><?php esc_html_e( 'Create a Marketplace account', 'matomo-marketplace-for-wordpress' ); ?></span>
		</div>
		<p>
			<?php
			echo sprintf(
				esc_html__( 'Sign up at %1$s to access premium plugins and manage subscriptions. If you already have an account, skip to the next step.', 'matomo-marketplace-for-wordpress' ),
				'<a href="https://shop.matomo.org/my-account/?wp=1" rel="noreferrer noopener" target="_blank">shop.matomo.org</a>'
			);
			?>
		</p>
		<div>
			<a href="https://shop.matomo.org/my-account/?wp=1" rel="noreferrer noopener" target="_blank">
				<button class="button-secondary">
					<?php esc_html_e( 'Go to Marketplace', 'matomo' ); ?>
					&nbsp;
					<span class="dashicons dashicons-external"></span>
				</button>
			</a>
		</div>
	</div>
	<div class="matomo-step">
		<div>
			<span class="step-number current matomo-primary-color-bg">2</span>
			<span class="step-title"><?php esc_html_e( 'Purchase or start a trial', 'matomo-marketplace-for-wordpress' ); ?></span>
		</div>
		<p>
			<?php esc_html_e( 'Subscribe to a premium plugin or begin a free trial — no payment needed to try.', 'matomo-marketplace-for-wordpress' ); ?>
		</p>
		<div>
			<a href="https://plugins.matomo.org/premium?wp=1" rel="noreferrer noopener" target="_blank">
				<button class="button-secondary">
					<?php esc_html_e( 'Browse premium plugins', 'matomo-marketplace-for-wordpress' ); ?>
					&nbsp;
					<span class="dashicons dashicons-external"></span>
				</button>
			</a>
		</div>
	</div>
	<div class="matomo-step">
		<div>
			<span class="step-number current matomo-primary-color-bg">3</span>
			<span class="step-title"><?php esc_html_e( 'Copy your license key', 'matomo-marketplace-for-wordpress' ); ?></span>
		</div>
		<p>
			<?php esc_html_e( 'Find your key in your Marketplace account under', 'matomo-marketplace-for-wordpress' ); ?>
			<strong><?php esc_html_e( 'My account', 'matomo-marketplace-for-wordpress' ); ?> <?php esc_html_e( 'Downloads & License Key', 'matomo-marketplace-for-wordpress' ); ?></strong>
		</p>
		<div>
			<a href="https://shop.matomo.org/my-account/downloads/?wp=1" rel="noreferrer noopener" target="_blank">
				<button class="button-secondary">
					<?php esc_html_e( 'Copy license key', 'matomo-marketplace-for-wordpress' ); ?>
					&nbsp;
					<span class="dashicons dashicons-external"></span>
				</button>
			</a>
		</div>
	</div>
	<div class="matomo-step">
		<div>
			<span class="step-number matomo-primary-color-bg">4</span>
			<span class="step-title"><?php esc_html_e( 'Enter your license key', 'matomo-marketplace-for-wordpress' ); ?></span>
		</div>
		<p>
			<?php esc_html_e( 'Paste your key below and activate — can be changed anytime after activation.', 'matomo-marketplace-for-wordpress' ); ?>
		</p>
		<div>
			<form method="post">
				<?php wp_nonce_field( MatomoMarketplaceAdmin::NONCE_LICENSE ); ?>

				<input id="license-key-input" placeholder="<?php esc_attr_e( 'License key', 'matomo-marketplace-for-wordpress' ); ?>" type="password" autocomplete="off" maxlength="80" name="<?php echo esc_attr( MatomoMarketplaceAdmin::FORM_NAME ); ?>"/>
				<input type="submit" class="button-primary activate-license" value="<?php esc_attr_e( 'Activate', 'matomo-marketplace-for-wordpress' ); ?>" />
			</form>
		</div>
	</div>
</div>

<h1 style="margin-top: 1em;margin-bottom: 1em;"><?php esc_html_e( 'Most popular premium features', 'matomo-marketplace-for-wordpress' ); ?></h1>

<?php
if ( class_exists( PopularFeatures::class ) ) {
	(new PopularFeatures())->show();
}
?>

