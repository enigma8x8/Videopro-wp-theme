<?php

/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

defined('ABSPATH') || exit;

global $product;

$attribute_keys  = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

do_action('woocommerce_before_add_to_cart_form'); ?>

<form class="variations_form cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. 
																																																																						?>">
	<?php do_action('woocommerce_before_variations_form'); ?>

	<?php if (empty($available_variations) && false !== $available_variations) : ?>
		<p class="stock out-of-stock"><?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce'))); ?></p>
	<?php else : ?>
		<div class="variations">
			<?php foreach ($attributes as $attribute_name => $options) : ?>
				<div class="option">
					<select class="selectpicker" data-style="btn-light" data-width="100%" name="attribute_<?php echo esc_attr(sanitize_title($attribute_name)); ?>" title="<?php echo esc_attr(wc_attribute_label($attribute_name)); ?>">
						<option value=""><?php echo esc_html(wc_attribute_label($attribute_name)); ?></option>
						<?php foreach ($options as $option) : ?>
							<option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endforeach; ?>

			<?php
			// Get custom variations from ACF
			$custom_variations = get_field('product_variations', $product->get_id());

			if ($custom_variations && is_array($custom_variations)) :
				foreach ($custom_variations as $variation) :
					$variation_name = $variation['variation_name'];
					$variation_options = $variation['variation_options'];

					if ($variation_name && $variation_options) :
						$options = array_map('trim', explode(',', $variation_options));
						$options = array_filter($options);
						?>
						<div class="option">
							<select class="selectpicker" data-style="btn-light" data-width="100%" name="custom_variation_<?php echo esc_attr(sanitize_title($variation_name)); ?>" title="<?php echo esc_attr($variation_name); ?>">
								<option value=""><?php echo esc_html($variation_name); ?></option>
								<?php foreach ($options as $option) : ?>
									<option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="single_variation_wrap">
			<?php
			/**
			 * Hook: woocommerce_before_single_variation.
			 */
			do_action('woocommerce_before_single_variation');

			/**
			 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
			 *
			 * @since 2.4.0
			 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
			 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
			 */
			do_action('woocommerce_single_variation');

			/**
			 * Hook: woocommerce_after_single_variation.
			 */
			do_action('woocommerce_after_single_variation');
			?>
		</div>
	<?php endif; ?>

	<?php do_action('woocommerce_after_variations_form'); ?>
</form>

<?php
do_action('woocommerce_after_add_to_cart_form');
