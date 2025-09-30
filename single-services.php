<?php

/**
 * Template for displaying single service pages
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="<?php echo home_url(); ?>">Sākums</a>
            <span class="separator"></span>
            <a href="<?php echo get_permalink(get_page_by_path('pakalpojumi')); ?>">Pakalpojumi</a>
            <span class="separator"></span>
            <span class="current"><?php echo get_the_title(); ?></span>
        </nav>
    </div>

    <div class="text-page container has-aside">
        <aside class="sidebar">
            <div class="sidebar-services">
                <ul class="list">
                    <?php
                    // Query all services for sidebar
                    $sidebar_services = new WP_Query(array(
                        'post_type' => 'services',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    ));

                    if ($sidebar_services->have_posts()):
                        while ($sidebar_services->have_posts()):
                            $sidebar_services->the_post();
                            $current_service_id = get_the_ID();
                            $is_current = (get_the_ID() == get_queried_object_id()) ? 'active' : '';
                    ?>
                            <li>
                                <a href="<?php echo get_permalink(); ?>" class="service-item <?php echo $is_current; ?>">
                                    <div class="icon">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-service-icon.svg" alt="<?php echo esc_attr(get_the_title()); ?>">
                                        <?php endif; ?>
                                    </div>

                                    <span><?php echo get_the_title(); ?></span>
                                </a>
                            </li>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </ul>
            </div>

            <?php get_template_part('template-parts/order-form-sidebar-4'); ?>

            <?php
            // Check if WooCommerce is active
            if (class_exists('WooCommerce')):
                // Get 3 random WooCommerce products
                $args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'orderby' => 'rand'
                );
                $random_products_query = new WP_Query($args);
            endif;
            ?>
            <div class="sidebar-products-swiper">
                <h3 class="block-title">Populārākie produkti</h3>
                <p class="sub-title">Preces, kas paredzētas pilšetu drošībai. Ieskatietiet mūsu <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">e-veikalā</a></p>

                <div class="swiper-holder">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php
                            if (isset($random_products_query) && $random_products_query->have_posts()):
                                while ($random_products_query->have_posts()):
                                    $random_products_query->the_post();
                                    $product = wc_get_product(get_the_ID());
                                    if ($product):
                            ?>
                                        <div class="swiper-slide">
                                            <div class="product-item">
                                                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="product-image">
                                                    <?php echo $product->get_image('woocommerce_thumbnail'); ?>
                                                </a>

                                                <div class="product-content">
                                                    <h3 class="product-title">
                                                        <a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html($product->get_name()); ?></a>
                                                    </h3>

                                                    <div class="price-holder">
                                                        <?php echo $product->get_price_html(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    endif;
                                endwhile;
                                wp_reset_postdata();
                            else:
                                ?>
                                <div class="swiper-slide">
                                    <div class="product-item">
                                        <p>Nav produktu</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="swiper-pagination rectangles"></div>
                </div>
            </div>
        </aside>

        <div class="content">
            <h1 class="page-title"><?php echo get_the_title(); ?></h1>

            <?php the_content(); ?>

            <?php
            $video_file = get_field('service_video_file');
            $video_image = get_field('service_video_image');

            if ($video_file || $video_image): ?>
                <div class="video-section mb-4">
                    <?php if ($video_file): ?>
                        <div class="video-holder" style="background: url(<?php echo esc_url($video_image['url']); ?>) center center / cover no-repeat;">
                            <video muted playsinline controls class="bg-video">
                                <source src="<?php echo esc_url($video_file['url']); ?>" type="<?php echo esc_attr($video_file['mime_type']); ?>">
                            </video>
                            <div class="video-loading-spinner" style="display: none;">
                                <div class="spinner"></div>
                            </div>

                            <div class="details">
                                <button type="button" class="play-btn"></button>

                                <h3 class="title"><?php echo get_the_title(); ?></h3>
                                <?php if (get_field('service_video_author')): ?>
                                    <span class="author">Videoprojekts eksperts: <strong><?php echo esc_html(get_field('service_video_author')); ?></strong></span>
                                <?php endif; ?>
                                <?php if (get_field('service_video_description')): ?>
                                    <p class="description m-0"><?php echo esc_html(get_field('service_video_description')); ?></p>
                                <?php endif; ?>
                            </div>


                        </div>
                    <?php elseif ($video_image): ?>
                        <div class="video-holder" style="background: url(<?php echo esc_url($video_image['url']); ?>) center center / cover no-repeat;">
                            <div class="details">
                                <h3 class="title"><?php echo get_the_title(); ?></h3>
                                <?php if (get_field('service_video_author')): ?>
                                    <span class="author">Videoprojekts eksperts: <strong><?php echo esc_html(get_field('service_video_author')); ?></strong></span>
                                <?php endif; ?>
                                <?php if (get_field('service_video_description')): ?>
                                    <p class="description m-0"><?php echo esc_html(get_field('service_video_description')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>


                </div>
            <?php endif; ?>

            <?php if (get_field('service_solutions_title')): ?>
                <h2><?php echo esc_html(get_field('service_solutions_title')); ?></h2>
            <?php endif; ?>

            <?php
            // Get solutions list
            $solutions = get_field('service_solutions');
            if ($solutions): ?>
                <div class="security-solutions-list">
                    <?php foreach ($solutions as $solution): ?>
                        <div class="item">
                            <h3><?php echo esc_html($solution['title']); ?></h3>
                            <p><?php echo esc_html($solution['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <style> html, body{ background-color: #fff !important; } </style>
        </div>
    </div>
</main>

<?php get_footer(); ?>
