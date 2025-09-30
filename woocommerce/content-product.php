<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined('ABSPATH') || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if (! is_a($product, WC_Product::class) || ! $product->is_visible()) {
	return;
}

$product_id = $product->get_id();
$product_title = $product->get_name();
$product_permalink = $product->get_permalink();
$product_image_id = $product->get_image_id();
$product_image_url = wp_get_attachment_image_url($product_image_id, 'medium');
if (!$product_image_url) {
	$product_image_url = wc_placeholder_img_src('medium');
}

$is_on_sale = $product->is_on_sale();
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
$current_price = $product->get_price();
$stock_status = $product->get_stock_status();
$short_description = $product->get_short_description();
?>

<div class="product-item">
    <a href="<?php echo esc_url($product_permalink); ?>" class="product-image">
      <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product_title); ?>">
    </a>
	<div class="product-content">
		<h3 class="product-title">
			<a href="<?php echo esc_url($product_permalink); ?>"><?php echo esc_html($product_title); ?></a>
		</h3>

    <div class="price-holder">
			<?php if ($is_on_sale && $sale_price) : ?>
				<span class="price new-price">€<?php echo number_format($sale_price, 2); ?></span>
				<span class="old-price">€<?php echo number_format($regular_price, 2); ?></span>
			<?php else : ?>
				<span class="price new-price">€<?php echo number_format($current_price, 2); ?></span>
			<?php endif; ?>
		</div>
	</div>

	<div class="list-view-details">
		<div>
			<h3 class="product-title">
				<a href="<?php echo esc_url($product_permalink); ?>"><?php echo esc_html($product_title); ?></a>
			</h3>

			<?php if ($short_description) : ?>
				<?php
				// Apply WooCommerce formatting (expands shortcodes, adds autop),
				// then strip all HTML so we never output raw tags inside our own <p> wrapper.
				$short_desc_formatted = apply_filters('woocommerce_short_description', $short_description);
				$short_desc_text = trim(wp_strip_all_tags($short_desc_formatted));
				if ($short_desc_text !== '') :
				?>
					<p class="description"><?php echo esc_html($short_desc_text); ?></p>
				<?php endif; ?>
			<?php endif; ?>

			<div class="stock-details">
				<?php if ($stock_status === 'instock') : ?>
					<span class="stock-status in-stock">Ir uz vietas</span>
				<?php elseif ($stock_status === 'outofstock') : ?>
					<span class="stock-status out-of-stock">Nav uz vietas</span>
				<?php else : ?>
					<span class="stock-status on-backorder">Uz pasūtījumu</span>
				<?php endif; ?>
			</div>
		</div>

		<div class="product-actions">
			<div class="price-holder">
				<?php if ($is_on_sale && $sale_price) : ?>
					<span class="price new-price">€<?php echo number_format($sale_price, 2); ?></span>
					<span class="old-price">€<?php echo number_format($regular_price, 2); ?></span>
				<?php else : ?>
					<span class="price new-price">€<?php echo number_format($current_price, 2); ?></span>
				<?php endif; ?>
			</div>

			<a href="<?php echo esc_url($product_permalink); ?>" class="btn btn-secondary">Skatīt</a>
		</div>
	</div>
</div>
