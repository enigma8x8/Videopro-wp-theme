<?php

/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.4.0
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (! empty($product_tabs)) : ?>

	<div class="tabs-holder">
		<ul class="nav nav-tabs" id="single-product-tabs" role="tablist">
			<?php $i = 1; ?>
			<?php foreach ($product_tabs as $key => $product_tab) : ?>
				<li class="nav-item" role="presentation">
					<button class="nav-link <?php echo $i === 1 ? 'active' : ''; ?>"
						id="tab-<?php echo esc_attr($key); ?>"
						data-bs-toggle="tab"
						data-bs-target="#tab-<?php echo esc_attr($key); ?>-pane"
						type="button"
						role="tab"
						aria-controls="tab-<?php echo esc_attr($key); ?>-pane"
						aria-selected="<?php echo $i === 1 ? 'true' : 'false'; ?>">
						<?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key)); ?>
					</button>
				</li>
				<?php $i++; ?>
			<?php endforeach; ?>
		</ul>

		<div class="tab-content">
			<?php $i = 1; ?>
			<?php foreach ($product_tabs as $key => $product_tab) : ?>
				<div class="tab-pane fade <?php echo $i === 1 ? 'show active' : ''; ?>"
					id="tab-<?php echo esc_attr($key); ?>-pane"
					role="tabpanel"
					aria-labelledby="tab-<?php echo esc_attr($key); ?>"
					tabindex="0">
					<?php
					if (isset($product_tab['callback'])) {
						call_user_func($product_tab['callback'], $key, $product_tab);
					}
					?>
				</div>
				<?php $i++; ?>
			<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>