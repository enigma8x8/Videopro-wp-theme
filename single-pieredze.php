<?php

/**
 * Template for displaying single pieredze pages
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <div class="container">
        <?php get_template_part('template-parts/breadcrumbs'); ?>
    </div>

    <div class="text-page container has-aside">
        <aside class="sidebar">
            <?php if (has_post_thumbnail()): ?>
                <div class="sidebar-featured-image" style="margin-bottom: 20px;">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
            <div class="sidebar-pieredze">
                <ul class="list">
                    <?php
                    // Query all pieredze for sidebar
                    $sidebar_pieredze = new WP_Query(array(
                        'post_type' => 'pieredze',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    ));

                    if ($sidebar_pieredze->have_posts()):
                        while ($sidebar_pieredze->have_posts()):
                            $sidebar_pieredze->the_post();
                            $current_pieredze_id = get_the_ID();
                            $is_current = (get_the_ID() == get_queried_object_id()) ? 'active' : '';
                    ?>

                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </ul>
            </div>

            <style> .sidebar-featured-image{width: 327px;height: 241px;} </style>

            <?php get_template_part('template-parts/order-form-sidebar-4'); ?>

            <div class="sidebar-products-swiper sidebar-news-swiper">
                <h3 class="block-title">Jaunumi</h3>
                <?php
                $news_query = new WP_Query(array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 5,
                    'orderby' => 'date',
                    'order' => 'DESC',
                ));
                ?>
                <div class="swiper-holder">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php if ($news_query->have_posts()): ?>
                                <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
                                    <div class="swiper-slide">
                                        <div class="product-item">
                                            
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php if (has_post_thumbnail()): ?>
                                                        <?php the_post_thumbnail('large'); ?>
                                                    <?php else: ?>
                                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/post-item-image-1.jpg" alt="">
                                                    <?php endif; ?>
                                                </a>
                                            
                                            <div class="product-content">
                                                <h3 class="product-title">
                                                    <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile;
                                wp_reset_postdata(); ?>
                            <?php else: ?>
                                <div class="swiper-slide">
                                    <div class="product-item">
                                        <p>Nav jaunumu</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="swiper-pagination rectangles"></div>
                </div>
            </div>
            <style>
                /* Local overrides for Jaunumi slider on single-pieredze */
                .single-pieredze .sidebar .sidebar-products-swiper .product-item .product-image {
                    height: auto !important;
                    /* override global 435px */
                    margin: 0 0 6px 0;
                    padding: 0;
                }

                .single-pieredze .sidebar .sidebar-products-swiper .product-item .product-title {
                    margin: 0 0 6px 0;
                }

                .single-pieredze .sidebar .sidebar-products-swiper .swiper-holder {
                    margin: 0;
                }

                .single-pieredze .sidebar .sidebar-products-swiper .swiper-pagination.rectangles {
                    margin-top: 6px;
                }

                .single-pieredze .sidebar .sidebar-products-swiper .product-item .product-image img,
                .sidebar-news-swiper .product-item .product-image img {
                    width: 100%;
                    height: auto;
                    transition: none;
                }

                .sidebar-news-swiper .product-item .product-image:hover img {
                    transform: none;
                }
            </style>
        </aside>

        <div class="content">
            <h1 class="page-title"><?php echo get_the_title(); ?></h1>

            <?php the_content(); ?>

            <?php
            $video_file = get_field('pieredze_video_file');
            $video_image = get_field('pieredze_video_image');

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


                                <?php if (get_field('pieredze_video_author')): ?>
                                    <span class="author">Videoprojekts eksperts: <strong><?php echo esc_html(get_field('pieredze_video_author')); ?></strong></span>
                                <?php endif; ?>
                                <?php if (get_field('pieredze_video_description')): ?>
                                    <p class="description m-0"><?php echo esc_html(get_field('pieredze_video_description')); ?></p>
                                <?php endif; ?>
                            </div>


                        </div>
                    <?php elseif ($video_image): ?>
                        <div class="video-holder" style="background: url(<?php echo esc_url($video_image['url']); ?>) center center / cover no-repeat;">
                            <div class="details">

                                <?php if (get_field('pieredze_video_author')): ?>
                                    <span class="author">Videoprojekts eksperts: <strong><?php echo esc_html(get_field('pieredze_video_author')); ?></strong></span>
                                <?php endif; ?>
                                <?php if (get_field('pieredze_video_description')): ?>
                                    <p class="description m-0"><?php echo esc_html(get_field('pieredze_video_description')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>


                </div>
            <?php endif; ?>

            <?php if (get_field('pieredze_projects_title')): ?>
                <h2><?php echo esc_html(get_field('pieredze_projects_title')); ?></h2>
            <?php endif; ?>

            <?php
            // Get projects list
            $projects = get_field('pieredze_projects');
            if ($projects): ?>
                <div class="pieredze-projects-list">
                    <?php foreach ($projects as $project): ?>
                        <div class="item">
                            <h3><?php echo esc_html($project['title']); ?></h3>
                            <p><?php echo esc_html($project['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Removed duplicate the_content() call -->
        </div>
    </div>
</main>

<?php get_footer(); ?>