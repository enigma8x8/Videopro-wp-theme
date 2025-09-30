<?php

/**
 * Single Product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 1.6.4
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post;

$short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);
$detailed_description = get_field('product_detailed_description', $post->ID);

// Debug information
if (defined('WP_DEBUG') && WP_DEBUG) {
    error_log('Short description: ' . ($short_description ? 'exists' : 'empty'));
    error_log('Detailed description: ' . ($detailed_description ? 'exists' : 'empty'));
}

if (! $short_description && ! $detailed_description) {
    return;
}
?>
<div class="details">
    <?php if ($short_description) : ?>
        <div class="short-desc">
            <?php echo wp_kses_post($short_description); ?>
        </div>
    <?php endif; ?>

    <?php if ($detailed_description) : ?>
        <div class="detailed-desc" style="display: none;">
            <?php echo wp_kses_post($detailed_description); ?>
        </div>
        <button type="button" class="read-full">Pilns preces apraksts</button>
    <?php else : ?>
        <!-- Debug: No detailed description found -->
        <?php if (defined('WP_DEBUG') && WP_DEBUG) : ?>
            <div style="background: #f0f0f0; padding: 10px; margin: 10px 0; border: 1px solid #ccc;">
                <strong>Debug:</strong> No detailed description found for product ID: <?php echo $post->ID; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>