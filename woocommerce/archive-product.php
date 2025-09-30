<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header('shop');
?>












<main id="main" class="site-main" role="main">
	<div class="container">
		<nav class="breadcrumbs">
			<a href="<?php echo esc_url(home_url('/')); ?>">Sākums</a>
			<span class="separator"></span>
			<?php if (is_product_category()) : ?>
				<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">E-veikals</a>
				<span class="separator"></span>
				<span class="current"><?php single_cat_title(); ?></span>
			<?php else : ?>
				<span class="current">E-veikals</span>
			<?php endif; ?>
		</nav>

		<h1 class="page-title">
			<?php if (is_product_category()) : ?>
				<?php single_cat_title(); ?>
			<?php else : ?>
				E-veikals
			<?php endif; ?>
		</h1>
	</div>

	<div class="container has-aside">
		<aside class="sidebar">
			<div class="widget">
				<div class="widget-content">
					<button type="button" class="product-categories-toggle">Product categories</button>

					<ul class="product-categories">
						<li class="category-item <?php echo is_shop() && !is_product_category() ? 'active' : ''; ?>">
							<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Visi produkti</a>
						</li>

						<?php
						$product_categories = get_terms(array(
							'taxonomy' => 'product_cat',
							'hide_empty' => true,
							'parent' => 0,
							'exclude' => array(get_term_by('slug', 'uncategorized', 'product_cat')->term_id ?? 0),
						));

						if ($product_categories && !is_wp_error($product_categories)) {
							foreach ($product_categories as $category) {
								$is_active = is_product_category($category->term_id);
								$has_children = get_terms(array(
									'taxonomy' => 'product_cat',
									'hide_empty' => true,
									'parent' => $category->term_id,
								));

								$class = 'category-item';
								if ($is_active) {
									$class .= ' active';
								}
								if ($has_children) {
									$class .= ' dropdown';
								}
						?>
								<li class="<?php echo esc_attr($class); ?>">
									<a href="<?php echo esc_url(get_term_link($category)); ?>" <?php echo $has_children ? 'class="dropdown-toggle"' : ''; ?>>
										<?php echo esc_html($category->name); ?>
									</a>

									<?php if ($has_children) : ?>
										<ul class="sub-categories">
											<?php foreach ($has_children as $child) : ?>
												<li>
													<a href="<?php echo esc_url(get_term_link($child)); ?>">
														<?php echo esc_html($child->name); ?>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</li>
						<?php
							}
						}
						?>
					</ul>
				</div>
			</div>

			<!-- Contact Information Section -->
			<div class="questions">
				<h3 class="heading"><?php echo esc_html(get_theme_mod('contact_heading', 'Ir jautājumi?')); ?></h3>
				<p><?php echo esc_html(get_theme_mod('contact_description', 'Sazinies ar mūsu atsaucīgo komandu, lai uzzinātu papildus informāciju par konkrētu produktu, piegādi vai apmaksas iespējām.')); ?></p>

				<ul>
					<li><strong>Telefons:</strong> <a href="tel:<?php echo esc_attr(get_theme_mod('contact_phone', '+371 22525100')); ?>"><?php echo esc_html(get_theme_mod('contact_phone', '+371 22525100')); ?></a></li>
					<li><strong>E-pasts:</strong> <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', 'info@videoprojekts.lv')); ?>"><?php echo esc_html(get_theme_mod('contact_email', 'info@videoprojekts.lv')); ?></a></li>
				</ul>
			</div>
		</aside>

		<div class="content">
            <div class="toolbar top">
				<div class="left-side">
					<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="toolbar-cart">
						<span>Iepirkumu grozs</span>

                        <div class="icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/catalog-cart-icon.svg" alt="">
                        </div>

                        <span class="badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    </a>
                </div>

                <div class="right-side">
                    <?php videoprojects_catalog_ordering(); ?>
                    <?php videoprojects_view_switcher(); ?>
                </div>
            </div>


			<?php if (woocommerce_product_loop()) : ?>
				<div class="product-list grid-4">
					<?php
					if (wc_get_loop_prop('total')) {
						while (have_posts()) {
							the_post();
							wc_get_template_part('content', 'product');
						}
					}
					?>
				</div>

				<?php
				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action('woocommerce_after_shop_loop');
				?>
			<?php else : ?>
				<?php
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action('woocommerce_no_products_found');
				?>
			<?php endif; ?>
		</div>
	</div>
</main>

<?php
get_footer('shop');
