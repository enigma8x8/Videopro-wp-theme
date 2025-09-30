<?php
/**
 * Breadcrumbs with deterministic WooCommerce flow.
 * Always shows: Sākums → E-veikals → Grozs → Apmaksa, when relevant.
 */

if (!defined('ABSPATH')) {
    exit;
}

$items = [];
$add_item = function (string $label, string $url = '') use (&$items) {
    foreach ($items as $it) {
        if ($url && !empty($it['url']) && $it['url'] === $url) {
            return;
        }
        if (!$url && empty($it['url']) && $it['label'] === $label) {
            return;
        }
    }
    $items[] = ['label' => $label, 'url' => $url];
};

// Home
$add_item(__('Sākums', 'videoprojects'), home_url('/'));

// Helpers for WooCommerce URLs
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : '';
$cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : '';
$checkout_url = (function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '');

// Canonical WooCommerce chains
if (function_exists('is_checkout') && is_checkout()) {
    if ($shop_url) { $add_item(__('E-veikals', 'videoprojects'), $shop_url); }
    if ($cart_url) { $add_item(__('Grozs', 'videoprojects'), $cart_url); }
    $add_item(__('Apmaksa', 'videoprojects'));
} elseif (function_exists('is_cart') && is_cart()) {
    if ($shop_url) { $add_item(__('E-veikals', 'videoprojects'), $shop_url); }
    $add_item(__('Grozs', 'videoprojects'));
} elseif (function_exists('is_product') && is_product()) {
    if ($shop_url) { $add_item(__('E-veikals', 'videoprojects'), $shop_url); }
    // Add one product category if exists
    $terms = get_the_terms(get_the_ID(), 'product_cat');
    if ($terms && !is_wp_error($terms)) {
        $term = array_shift($terms);
        $link = get_term_link($term);
        if (!is_wp_error($link)) {
            $add_item($term->name, $link);
        }
    }
    $add_item(get_the_title());
} elseif (function_exists('is_shop') && is_shop()) {
    $add_item(__('E-veikals', 'videoprojects'));
} elseif (function_exists('is_product_category') && is_product_category()) {
    if ($shop_url) { $add_item(__('E-veikals', 'videoprojects'), $shop_url); }
    $term = get_queried_object();
    if ($term && isset($term->name)) { $add_item($term->name); }
} else {
    // Generic WP contexts
    if (is_page()) {
        $ancestors = array_reverse(get_post_ancestors(get_the_ID()));
        foreach ($ancestors as $ancestor_id) {
            $add_item(get_the_title($ancestor_id), get_permalink($ancestor_id));
        }
        $add_item(get_the_title());
    } elseif (is_singular('pieredze')) {
        $pto = get_post_type_object('pieredze');
        $pt_label = ($pto && isset($pto->labels->name)) ? $pto->labels->name : __('Pieredze', 'videoprojects');
        $pt_archive = get_post_type_archive_link('pieredze');
        if ($pt_archive) {
            $add_item($pt_label, $pt_archive);
        } else {
            $pt_page = get_page_by_path('pieredze');
            if ($pt_page) {
                $add_item(get_the_title($pt_page), get_permalink($pt_page));
            } else {
                $add_item($pt_label);
            }
        }
        $add_item(get_the_title());
    } elseif (is_single()) {
        $cats = get_the_category();
        if (!empty($cats)) {
            $primary = $cats[0];
            $add_item($primary->name, get_category_link($primary->term_id));
        }
        $add_item(get_the_title());
    } elseif (is_post_type_archive('pieredze')) {
        $pto = get_post_type_object('pieredze');
        $pt_label = ($pto && isset($pto->labels->name)) ? $pto->labels->name : __('Pieredze', 'videoprojects');
        $add_item($pt_label);
    } elseif (is_search()) {
        $add_item(sprintf(__('Meklēšana: %s', 'videoprojects'), get_search_query()));
    } elseif (is_archive()) {
        $add_item(get_the_archive_title());
    } elseif (is_404()) {
        $add_item(__('Lapa nav atrasta', 'videoprojects'));
    }
}
?>

<nav class="breadcrumbs" aria-label="Breadcrumb">
<?php
$count = count($items);
foreach ($items as $i => $it) {
    $is_last = ($i === $count - 1);
    if (!$is_last && !empty($it['url'])) {
        echo '<a href="' . esc_url($it['url']) . '">' . esc_html($it['label']) . '</a>';
        echo '<span class="separator"></span>';
    } elseif (!$is_last) {
        echo '<span class="label">' . esc_html($it['label']) . '</span>';
        echo '<span class="separator"></span>';
    } else {
        echo '<span class="current">' . esc_html($it['label']) . '</span>';
    }
}
?>
</nav>
