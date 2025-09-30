<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (! defined('ABSPATH')) {
	exit;
}

global $product, $woocommerce_loop;

if (empty($product) || ! $product->exists()) {
	return;
}

if (! $product->is_visible()) {
	return;
}

$related_products = wc_get_related_products($product->get_id(), 8);

if (sizeof($related_products) === 0) {
	return;
}

$args = apply_filters(
	'woocommerce_related_products_args',
	array(
		'post_type'      => 'product',
		'ignore_sticky_posts' => 1,
		'no_found_rows'  => 1,
		'posts_per_page' => 8,
		'orderby'        => isset($orderby) ? $orderby : 'rand',
		'post__in'       => $related_products,
		'post__not_in'   => array($product->get_id()),
	)
);

$products                    = new WP_Query($args);
$woocommerce_loop['name']    = 'related';
$woocommerce_loop['columns'] = apply_filters('woocommerce_related_products_columns', $columns);

if ($products->have_posts()) : ?>

<div class="related-products">
  <h2 class="block-heading">Tev varētu interesēt arī šīs preces</h2>

  <div class="products-swiper">
    <div class="swiper-holder">
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php foreach ( $products->posts as $rel_post ) :
            $rp = wc_get_product( $rel_post->ID );
            if ( ! $rp || ! $rp->is_visible() ) { continue; }
          ?>
            <div class="swiper-slide">
              <div class="product-item">
                <a href="<?php echo esc_url( get_permalink( $rp->get_id() ) ); ?>" class="product-image">
                  <?php
                  if ( $rp->get_image_id() ) {
                    echo wp_get_attachment_image( $rp->get_image_id(), 'woocommerce_thumbnail', false, array(
                      'alt' => esc_attr( $rp->get_name() ),
                    ) );
                  } else {
                    echo wc_placeholder_img( 'woocommerce_thumbnail' );
                  }
                  ?>
                </a>

                <div class="product-content">
                  <h3 class="product-title">
                    <a href="<?php echo esc_url( get_permalink( $rp->get_id() ) ); ?>"><?php echo esc_html( $rp->get_name() ); ?></a>
                  </h3>

                  <div class="price-holder">
                    <?php if ( $rp->is_on_sale() ) : ?>
                      <span class="price new-price"><?php echo wp_kses_post( wc_price( $rp->get_sale_price() ) ); ?></span>
                      <span class="old-price"><?php echo wp_kses_post( wc_price( $rp->get_regular_price() ) ); ?></span>
                    <?php else : ?>
                      <?php if ( $rp->get_price() !== '' ) : ?>
                        <span class="price new-price"><?php echo wp_kses_post( wc_price( $rp->get_price() ) ); ?></span>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="swiper-nav">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>
  </div>
</div>

<?php
endif;

wp_reset_postdata();
