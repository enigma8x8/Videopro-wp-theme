<?php

/**
 * Single Product stock.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/stock.php.
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

if (!$product) {
	return;
}

$stock_status = $product->get_stock_status();
$stock_text = '';
$stock_class = '';

switch ($stock_status) {
	case 'instock':
		$stock_text = 'Ir uz vietas';
		$stock_class = 'in-stock';
		break;
	case 'outofstock':
		$stock_text = 'Nav noliktavā';
		$stock_class = 'out-of-stock';
		break;
	case 'onbackorder':
		$stock_text = 'Uz pasūtījumu';
		$stock_class = 'on-backorder';
		break;
	default:
		$stock_text = 'Nav informācijas';
		$stock_class = 'no-info';
		break;
}

?>
<div class="stock-details">
	<span class="stock-status <?php echo esc_attr($stock_class); ?>"><?php echo esc_html($stock_text); ?></span>
</div>