<?php

/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined('ABSPATH') || exit;

global $product;

$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();

if ($post_thumbnail_id) {
	echo '<a data-fancybox="gallery" href="' . esc_url(wp_get_attachment_image_url($post_thumbnail_id, 'full')) . '" data-caption="">';
	echo wp_get_attachment_image($post_thumbnail_id, 'large');
	echo '</a>';

	// Add gallery images
	if ($attachment_ids) {
		foreach ($attachment_ids as $attachment_id) {
			echo '<a data-fancybox="gallery" href="' . esc_url(wp_get_attachment_image_url($attachment_id, 'full')) . '" data-caption="" style="display: none;">';
			echo wp_get_attachment_image($attachment_id, 'large');
			echo '</a>';
		}
	}
} else {
	echo '<img src="' . esc_url(wc_placeholder_img_src('woocommerce_single')) . '" alt="' . esc_html__('Awaiting product image', 'woocommerce') . '" class="wp-post-image" />';
}
