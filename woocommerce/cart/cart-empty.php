<?php

/**
 * Empty cart page
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

// Default empty cart message via hook (can be filtered by plugins).
ob_start();
do_action('woocommerce_cart_is_empty');
$empty_message = trim(wp_strip_all_tags(ob_get_clean()));
if ($empty_message === '') {
	$empty_message = __('Your cart is currently empty.', 'woocommerce');
}
?>

<div class="vp-empty-cart">
	<div class="icon" aria-hidden="true"></div>
	<h2 class="title"><?php echo esc_html__('Grozs ir tukšs', 'videoprojects'); ?></h2>
	<p class="subtitle"><?php echo esc_html($empty_message); ?></p>

	<?php if (wc_get_page_id('shop') > 0) : ?>
		<p class="return-to-shop">
			<a class="button wc-backward" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
				<?php echo esc_html(apply_filters('woocommerce_return_to_shop_text', __('Return to shop', 'woocommerce'))); ?>
			</a>
		</p>
	<?php endif; ?>
</div>