<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
	exit; // Exit if accessed directly
}

get_header(); ?>

<main id="main" class="site-main" role="main">
	<div class="container">
		<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
		?>

		<?php while (have_posts()) : ?>
			<?php the_post(); ?>

			<div class="single-product">
				<div class="add-to-cart-holder">
					<a href="<?php echo get_permalink(get_page_by_path('kontakti')); ?>" class="question-link d-flex align-items-center">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/question-icon.svg" alt="">
						<span>Jautājumi par preci?</span>
					</a>

					<a href="<?php echo wc_get_cart_url(); ?>" class="cart-details">
						<span>Iepirkumu grozs</span>
						<div class="badge"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
					</a>
				</div>

				<div class="main-details">
					<div class="gallery">
						<?php
						/**
						 * Hook: woocommerce_before_single_product_summary.
						 *
						 * @hooked woocommerce_show_product_sale_flash - 10
						 * @hooked woocommerce_show_product_images - 20
						 */
						do_action('woocommerce_before_single_product_summary');
						?>
					</div>

					<div class="summary">
						<?php
						/**
						 * Hook: woocommerce_single_product_summary.
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_rating - 10
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_sharing - 50
						 */
						do_action('woocommerce_single_product_summary');
						?>
					</div>
				</div>

				<?php
				/**
				 * Hook: woocommerce_after_single_product_summary.
				 *
				 * @hooked woocommerce_output_product_data_tabs - 10
				 * @hooked woocommerce_upsell_display - 15
				 * @hooked woocommerce_output_related_products - 20
				 */
				do_action('woocommerce_after_single_product_summary');
				?>
			</div>

		<?php endwhile; // end of the loop. 
		?>

		<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
		?>
	</div>
</main>

<?php
get_footer();

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
