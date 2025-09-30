<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

defined('ABSPATH') || exit;



do_action('woocommerce_before_cart');
?>

<div class="container">
    <nav class="breadcrumbs">
        <a href="<?php echo esc_url(home_url('/')); ?>">Sākums</a>
        <span class="separator"></span>
        <?php if (is_product_category()) : ?>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">E-veikals</a>
            <span class="separator"></span>
            <span class="current"><?php single_cat_title(); ?></span>
        <?php elseif (is_cart()) : ?>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">E-veikals</a>
            <span class="separator"></span>
            <span class="current">Iepirkumu grozs</span>
		<?php else : ?>
			<span class="current">E-veikals</span>
        <?php endif; ?>
    </nav>

    <h1 class="page-title">
        <?php if (is_product_category()) : ?>
            <?php single_cat_title(); ?>
        <?php else : ?>
            Iepirkumu grozs
        <?php endif; ?>
    </h1>
</div>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
	<?php do_action('woocommerce_before_cart_table'); ?>


	<div class="cart-container">
		<div class="cart-items">
			<table>
				<thead>
					<tr>
						<th class="th-product"><?php echo esc_html__('Prece', 'videoprojects'); ?></th>
						<th class="th-price"><?php echo esc_html__('Cena', 'videoprojects'); ?></th>
						<th class="th-amount"><?php echo esc_html__('Daudzums', 'videoprojects'); ?></th>
						<th class="th-total"><?php echo esc_html__('Kopā', 'videoprojects'); ?></th>
					</tr>
				</thead>

				<tbody>
					<?php do_action('woocommerce_before_cart_contents'); ?>

					<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
						$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
						$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
						if (! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
							continue;
						}
						$product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
						$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
						$thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
					?>
						<tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
							<td class="td-product" data-label="<?php echo esc_attr__('Prece', 'videoprojects'); ?>">
								<div class="product-details">
									<?php
									echo apply_filters(
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a role="button" href="%s" class="remove-btn" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
											esc_url(wc_get_cart_remove_url($cart_item_key)),
											esc_attr(sprintf(
												/* translators: %s: product name */
												__('Remove %s from cart', 'woocommerce'),
												wp_strip_all_tags($product_name)
											)),
											esc_attr($product_id),
											esc_attr($_product->get_sku())
										),
										$cart_item_key
									);
									?>

									<?php if (! $product_permalink) : ?>
										<span class="thumbnail"><?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																?></span>
									<?php else : ?>
										<a href="<?php echo esc_url($product_permalink); ?>" class="thumbnail"><?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																												?></a>
									<?php endif; ?>

									<div class="details">
										<?php if (! $product_permalink) : ?>
											<span class="name"><?php echo wp_kses_post($product_name); ?></span>
										<?php else : ?>
											<?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" class="name">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key)); ?>
										<?php endif; ?>

										<?php
										do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
										echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
											echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
										}
										?>
									</div>
								</div>
							</td>

							<td class="td-price" data-label="<?php echo esc_attr__('Cena', 'videoprojects'); ?>">
								<?php
								$tax_rates     = WC_Tax::get_rates($_product->get_tax_class());
								$tax_percent   = $tax_rates ? array_sum(wp_list_pluck($tax_rates, 'rate')) : 0;
                                $show_vat_note = wc_tax_enabled() && ($tax_percent > 0);
								?>
								<div class="price">
									<strong><?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
											?></strong>
									<?php if ($show_vat_note) : ?> <?php echo sprintf(esc_html__('ar PVN (%s%%)', 'videoprojects'), wc_format_decimal($tax_percent, 0)); ?><?php endif; ?>
								</div>
							</td>

							<td class="td-amount" data-label="<?php echo esc_attr__('Daudzums', 'videoprojects'); ?>">
								<?php
								if ($_product->is_sold_individually()) {
									$min_quantity = 1;
									$max_quantity = 1;
								} else {
									$min_quantity = 0;
									$max_quantity = $_product->get_max_purchase_quantity();
								}

								$product_quantity = woocommerce_quantity_input(
									array(
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $max_quantity,
										'min_value'    => $min_quantity,
										'product_name' => $product_name,
									),
									$_product,
									false
								);

								echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</td>

							<td class="td-total" data-label="<?php echo esc_attr__('Kopā', 'videoprojects'); ?>">
								<div class="price">
									<strong><?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
											?></strong>
									<?php if ($show_vat_note) : ?> <?php echo sprintf(esc_html__('ar PVN (%s%%)', 'videoprojects'), wc_format_decimal($tax_percent, 0)); ?><?php endif; ?>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>

					<?php do_action('woocommerce_after_cart_contents'); ?>
				</tbody>
			</table>

			<div class="cart-actions">
				<?php if (wc_coupons_enabled()) : ?>
					<div class="cart-coupon">
						<label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
						<input type="text" name="coupon_code" id="coupon_code" value="" placeholder="<?php echo esc_attr__('Atlaižu kupons', 'videoprojects'); ?>" />
						<button type="submit" class="btn btn-primary" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php echo esc_html__('Aktivizēt kuponu', 'videoprojects'); ?></button>
						<?php do_action('woocommerce_cart_coupon'); ?>
					</div>
				<?php endif; ?>

				<button type="submit" class="update-cart-btn desktop" name="empty_cart" value="1"><?php echo esc_html__('Atsvaidzināt grozu', 'videoprojects'); ?></button>
				<button type="submit" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>" style="display:none"></button>
			</div>
		</div>

		<div class="cart-totals">
			<h3><?php echo esc_html__('Groza kopsumma', 'videoprojects'); ?></h3>

			<table class="cart-totals-table">
				<tbody>
					<tr>
						<td><?php echo esc_html__('Pasūtījuma summa:', 'videoprojects'); ?></td>
						<td><?php wc_cart_totals_subtotal_html(); ?></td>
					</tr>

					<?php if (wc_coupons_enabled()) : ?>
						<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
							<tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
								<td><strong><?php echo esc_html__('Atlaide:', 'videoprojects'); ?></strong> <?php echo wp_kses_post(wc_cart_totals_coupon_label($coupon)); ?></td>
								<td><?php wc_cart_totals_coupon_html($coupon); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>

				<tfoot>



					<tr class="order-total">
						<td><?php echo esc_html__('Kopā:', 'videoprojects'); ?></td>
						<td>
							<?php
							// Render total without trailing includes text, then print includes tax on a new line below.
							$total_html = WC()->cart->get_total();
							echo '<strong>' . wp_kses_post($total_html) . '</strong>';

							if (wc_tax_enabled() && WC()->cart->display_prices_including_tax()) {
								$tax_string_array = array();
								$cart_tax_totals  = WC()->cart->get_tax_totals();
								if (get_option('woocommerce_tax_total_display') === 'itemized') {
									foreach ($cart_tax_totals as $code => $tax) {
										$tax_string_array[] = sprintf('%s %s', $tax->formatted_amount, $tax->label);
									}
								} elseif (! empty($cart_tax_totals)) {
									$tax_string_array[] = sprintf('%s %s', wc_price(WC()->cart->get_taxes_total(true, true)), WC()->countries->tax_or_vat());
								}
								if (! empty($tax_string_array)) {
									echo '<div class="order-tax-note">' . wp_kses_post(sprintf(__('(includes %s)', 'woocommerce'), implode(', ', $tax_string_array))) . '</div>';
								}
							}
							?>
						</td>
					</tr>



					<?php if (wc_tax_enabled()) : ?>
						<?php
						$taxable_address = WC()->customer->get_taxable_address();
						$estimated_text  = '';
						if (WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()) {
							$estimated_text = sprintf(
								' <small>%s</small>',
								sprintf(
									/* translators: %s: country. */
									esc_html__('(estimated for %s)', 'woocommerce'),
									WC()->countries->estimated_for_prefix($taxable_address[0]) . WC()->countries->countries[$taxable_address[0]]
								)
							);
						}
						?>
                    <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
                        <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
                            <tr class="tax-total tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
                                <td><?php echo wp_kses_post($tax->label) . ' 21%' . $estimated_text; ?></td>
                                <td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr class="tax-total">
                            <td><?php echo esc_html(WC()->countries->tax_or_vat()) . ' (21%)' . $estimated_text; ?></td>
                            <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                        </tr>
                    <?php endif; ?>
					<?php endif; ?>

					<?php if (wc_tax_enabled()) : ?>
						<tr class="ex-tax-total">
							<td><?php echo esc_html__('Summa bez PVN', 'videoprojects'); ?></td>
							<td><?php echo WC()->cart->get_total_ex_tax(); ?></td>
						</tr>
					<?php endif; ?>

					





				</tfoot>
			</table>

			<a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn btn-primary"><?php echo esc_html__('Noformēt pirkumu', 'videoprojects'); ?></a>
		</div>

		<button type="submit" class="update-cart-btn mobile" name="empty_cart" value="1"><?php echo esc_html__('Atsvaidzināt grozu', 'videoprojects'); ?></button>
	</div>

	<?php do_action('woocommerce_cart_actions'); ?>
	<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

	<?php do_action('woocommerce_after_cart_table'); ?>
</form>

<?php do_action('woocommerce_after_cart'); ?>

<style>
.page-id-10 .entry-title { 
	display: none; 
}; 
</style>