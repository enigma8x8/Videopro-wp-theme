<?php

/**
 * Breadcrumb for the shop pages.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.0
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! empty($breadcrumb)) {

	echo '<nav class="breadcrumbs">';

	foreach ($breadcrumb as $key => $crumb) {

		echo '<span class="breadcrumb-item">';

		if (! empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
			echo '<a href="' . esc_url($crumb[1]) . '">' . esc_html($crumb[0]) . '</a>';
		} else {
			echo '<span class="current">' . esc_html($crumb[0]) . '</span>';
		}

		echo '</span>';

		if (sizeof($breadcrumb) !== $key + 1) {
			echo '<span class="separator"></span>';
		}
	}

	echo '</nav>';
}
