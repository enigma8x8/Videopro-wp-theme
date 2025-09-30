<?php

/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

global $product;

$attributes = $product->get_attributes();

if (! empty($attributes)) {
	echo '<table>';
	echo '<tbody>';

	foreach ($attributes as $attribute) {
		$name = wc_attribute_label($attribute->get_name());
		$values = array();

		if ($attribute->is_taxonomy()) {
			$terms = wp_get_post_terms($product->get_id(), $attribute->get_name());
			foreach ($terms as $term) {
				$values[] = $term->name;
			}
		} else {
			$values = $attribute->get_options();
		}

		if (! empty($values)) {
			echo '<tr>';
			echo '<td>' . esc_html($name) . '</td>';
			echo '<td>' . esc_html(implode(', ', $values)) . '</td>';
			echo '</tr>';
		}
	}

	echo '</tbody>';
	echo '</table>';
}
