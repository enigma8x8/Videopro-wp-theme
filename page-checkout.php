<?php
/* Template Name: Checkout Page */
/* Template targeting page with slug 'checkout' */
get_header();
$theme_uri = get_template_directory_uri();
?>

<main id="main" class="site-main" role="main">
    <div class="container">
        
        <?php get_template_part('template-parts/breadcrumbs'); ?>

        <h1 class="page-title"><?php echo esc_html(get_the_title()); ?></h1>

        <div class="checkout-container">
            <form action="#" method="post" class="checkout-form">
                <div class="woocommerce-billing-fields">
                    <div class="radio-list">
                        <div class="form-group">
                            <input type="radio" name="person-type" id="person-type-1" checked>
                            <label for="person-type-1">Fiziska persona</label>
                        </div>

                        <div class="form-group">
                            <input type="radio" name="person-type" id="person-type-2">
                            <label for="person-type-2">Juridiska persona</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label>Vārds</label>
                                <input type="text" name="first_name" class="input-text">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group required">
                                <label>Uzvārds</label>
                                <input type="text" name="last_name" class="input-text">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group required">
                                <label>Valsts</label>
                                <select name="country" class="selectpicker" title="Latvija">
                                    <option value="Latvija">Latvija</option>
                                    <option value="Lietuva">Lietuva</option>
                                    <option value="Igaunija">Igaunija</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group required">
                                <label>Ielas nosaukums</label>
                                <input type="text" name="street" placeholder="Mājas numurs un ielas nosaukums" class="input-text">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group required">
                                <label>Pilsēta</label>
                                <input type="text" name="city" class="input-text">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group required">
                                <label>Pasta indekss</label>
                                <input type="text" name="postcode" class="input-text">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group required">
                                <label>Tālrunis</label>
                                <input type="tel" name="phone" class="input-text">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group required">
                                <label>E-pasta adrese</label>
                                <input type="email" name="email" class="input-text">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Pasūtījuma piezīmes</label>
                                <textarea name="order_notes" class="input-text"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="woocommerce-checkout-review-order">
                    <h2>Jūsu pasūtījums</h2>

                    <div class="order-summary">
                        <table class="order-summary-table">
                            <thead>
                                <tr>
                                    <th colspan="2">Produkti</th>
                                </tr>
                            </thead>

                            <tbody>
<?php if (function_exists('WC') && WC()->cart && ! WC()->cart->is_empty()): ?>
    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
        $product   = $cart_item['data'];
        if (! $product || ! $product->exists()) continue;
        $qty        = $cart_item['quantity'];
        $name       = $product->get_name();
        $subtotal   = WC()->cart->get_product_subtotal($product, $qty);
    ?>
    <tr class="cart-item">
        <td class="product-name"><?php echo esc_html($name); ?> × <?php echo intval($qty); ?></td>
        <td class="product-total"><?php echo $subtotal; ?></td>
    </tr>
    <?php endforeach; ?>
    <tr class="cart-subtotal">
        <td><strong>Summa</strong></td>
        <td><strong><?php echo wc_price(WC()->cart->get_subtotal()); ?></strong></td>
    </tr>
<?php endif; ?>
<?php if (! (function_exists('WC') && WC()->cart && ! WC()->cart->is_empty())): ?>
                                <tr>
                                    <td>Preces nosaukums šajā vietā</td>
                                    <td>€325.00</td>
                                </tr>

                                <tr>
                                    <td><strong>Summa</strong></td>
                                    <td><strong>€325.00</strong></td>
                                </tr>

<?php endif; ?>
                                <tr>
                                    <td colspan="2">
                                        <strong>Piegāde</strong>

                                        <ul class="shipping-methods">
                                            <li>
                                                <input type="radio" name="shipping" id="shipping-1" checked>
                                                <label for="shipping-1">
                                                    <span>Omniva pakomāts €2.99</span>
                                                    <img src="<?php echo esc_url($theme_uri . '/assets/images/shipping-omniva-logo.png'); ?>" alt="Omniva">
                                                </label>

                                                <div class="option-box">
                                                    <label>Pakomātu saraksts</label>
                                                    <select name="omniva_station" class="selectpicker" title="Izvēlieties pakomāta adresi">
                                                        <option value="Option 1">Option 1</option>
                                                        <option value="Option 2">Option 2</option>
                                                    </select>
                                                </div>
                                            </li>

                                            <li>
                                                <input type="radio" name="shipping" id="shipping-2">
                                                <label for="shipping-2">
                                                    <span>Venipak pakomāts €2.99</span>
                                                    <img src="<?php echo esc_url($theme_uri . '/assets/images/shipping-venipak-logo.png'); ?>" alt="Venipak">
                                                </label>

                                                <div class="option-box">
                                                    <label>Pakomātu saraksts</label>
                                                    <select name="venipak_station" class="selectpicker" title="Izvēlieties pakomāta adresi">
                                                        <option value="Option 1">Option 1</option>
                                                        <option value="Option 2">Option 2</option>
                                                    </select>
                                                </div>
                                            </li>

                                            <li>
                                                <input type="radio" name="shipping" id="shipping-3">
                                                <label for="shipping-3">
                                                    <span>DPD paku skapis €2.99</span>
                                                    <img src="<?php echo esc_url($theme_uri . '/assets/images/shipping-dpd-logo.png'); ?>" alt="DPD">
                                                </label>

                                                <div class="option-box">
                                                    <label>Pakomātu saraksts</label>
                                                    <select name="dpd_station" class="selectpicker" title="Izvēlieties pakomāta adresi">
                                                        <option value="Option 1">Option 1</option>
                                                        <option value="Option 2">Option 2</option>
                                                    </select>
                                                </div>
                                            </li>

                                            <li>
                                                <input type="radio" name="shipping" id="shipping-4">
                                                <label for="shipping-4">
                                                    <span>Unisend pakomāts €2.99</span>
                                                    <img src="<?php echo esc_url($theme_uri . '/assets/images/shipping-unised-logo.png'); ?>" alt="Unisend">
                                                </label>

                                                <div class="option-box">
                                                    <label>Pakomātu saraksts</label>
                                                    <select name="unisend_station" class="selectpicker" title="Izvēlieties pakomāta adresi">
                                                        <option value="Option 1">Option 1</option>
                                                        <option value="Option 2">Option 2</option>
                                                    </select>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <?php if (function_exists('WC') && WC()->cart && ! WC()->cart->is_empty()): ?>
                                <?php $total_raw = WC()->cart->get_total('edit'); $tax_total = WC()->cart->get_totals()['total_tax'] ?? 0; ?>
                                    <tr class="order-total">
                                        <td><strong>Kopā</strong></td>
                                        <td><strong><?php echo wc_price($total_raw); ?> <span class="order-total-tax-note">(ieskaitot <?php echo wc_price($tax_total); ?> PVN)</span></strong></td>
                                    </tr>
                            
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="woocomerce-payment-methods">
                        <ul class="methods">
                            <li>
                                <input type="radio" name="payment" id="payment-1" checked>
                                <label for="payment-1">Internetbanka</label>

                                <div class="payment-box">
                                    <div class="form-group required">
                                        <label>Valsts</label>

                                        <select name="bank_country" class="selectpicker" title="Latvija">
                                            <option value="Latvija">Latvija</option>
                                            <option value="Lietuva">Lietuva</option>
                                            <option value="Igaunija">Igaunija</option>
                                        </select>

                                        <div class="options">
                                            <div class="form-group">
                                                <input type="radio" name="bank" id="bank-1">
                                                <label for="bank-1">
                                                    <img src="<?php echo esc_url($theme_uri . '/assets/images/payment-swedbank-logo.png'); ?>" alt="Swedbank">
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <input type="radio" name="bank" id="bank-2">
                                                <label for="bank-2">
                                                    <img src="<?php echo esc_url($theme_uri . '/assets/images/payment-seb-logo.png'); ?>" alt="SEB">
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <input type="radio" name="bank" id="bank-3">
                                                <label for="bank-3">
                                                    <img src="<?php echo esc_url($theme_uri . '/assets/images/payment-citadele-logo.png'); ?>" alt="Citadele">
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <input type="radio" name="bank" id="bank-4">
                                                <label for="bank-4">
                                                    <img src="<?php echo esc_url($theme_uri . '/assets/images/payment-luminor-logo.png'); ?>" alt="Luminor">
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <input type="radio" name="bank" id="bank-5">
                                                <label for="bank-5">
                                                    <img src="<?php echo esc_url($theme_uri . '/assets/images/payment-revolut-logo.png'); ?>" alt="Revolut">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <input type="radio" name="payment" id="payment-2">
                                <label for="payment-2">Bankas pārskaitījums</label>
                            </li>

                            <li>
                                <input type="radio" name="payment" id="payment-3">
                                <label for="payment-3">Cits maksājuma veids</label>
                            </li>

                            <li>
                                <input type="radio" name="payment" id="payment-4">
                                <label for="payment-4">Cits maksājuma veids 2</label>
                            </li>
                        </ul>
                    </div>

                    <div class="submit-form">
                        <div class="form-group">
                            <input type="checkbox" name="terms" id="checkbox-1">
                            <label for="checkbox-1">Piekrītu videoprojekts.lv <a href="#">iepirkšanās noteikumiem</a></label>
                        </div>

                        <div class="form-group">
                            <input type="checkbox" name="agree_privacy" id="checkbox-2">
                            <label for="checkbox-2">Piekrītu videoprojekts.lv <a href="#">privātuma politikai</a></label>
                        </div>

                        <div class="form-group">
                            <input type="checkbox" name="subscribe" id="checkbox-3">
                            <label for="checkbox-3">Piekrītu aktualitāšu saņemšanai no videoprojekts.lv</label>
                        </div>

                        <div class="order-btn">
                            <button type="submit" class="btn btn-primary">Maksāt</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>
