<?php

/**
 * Single variation cart button
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	<?php
	do_action('woocommerce_before_add_to_cart_quantity');
	?>
	<label for="quantity"><?php esc_html_e('Daudzums:', 'videoprojects'); ?></label>
	<div class="quantity">
		<button type="button" class="minus" aria-label="Decrease quantity"></button>
		<input type="number" id="quantity" name="quantity" value="1" min="1" max="99" step="1" />
		<button type="button" class="plus" aria-label="Increase quantity"></button>
	</div>
	<?php
	do_action('woocommerce_after_add_to_cart_quantity');
	?>

    <div class="add-to-cart">
        <button type="submit" class="single_add_to_cart_button button alt add-btn btn btn-primary<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
    </div>

	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
