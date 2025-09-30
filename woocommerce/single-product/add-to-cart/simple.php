<?php
/**
 * Simple product add to cart
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

    <?php do_action('woocommerce_before_add_to_cart_form'); ?>

    <form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

        <?php
        // Custom variations from ACF (optional)
        $custom_variations = get_field('product_variations', $product->get_id());

        if ($custom_variations && is_array($custom_variations)) : ?>
            <div class="variations">
                <?php foreach ($custom_variations as $variation) :
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
            </div>
        <?php endif; ?>

        <?php do_action('woocommerce_before_add_to_cart_quantity'); ?>
        <label for="quantity"><?php esc_html_e('Daudzums:', 'videoprojects'); ?></label>
        <div class="quantity">
            <button type="button" class="minus" aria-label="Decrease quantity"></button>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="99" step="1" />
            <button type="button" class="plus" aria-label="Increase quantity"></button>
        </div>
        <?php do_action('woocommerce_after_add_to_cart_quantity'); ?>

        <div class="add-to-cart">
            <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="add-btn btn btn-primary">Likt grozā</button>
        </div>

        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    </form>

    <?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>
