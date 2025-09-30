<?php

/**
 * Other Section tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/other-section.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 1.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}

global $product;

$other_section_content = get_field('other_section', $product->get_id());

if ($other_section_content) : ?>
    <div class="other-section-content">
        <?php echo wp_kses_post($other_section_content); ?>
    </div>
<?php else : ?>
    <p><?php esc_html_e('Nav papildu informācijas.', 'videoprojects'); ?></p>
<?php endif; ?>