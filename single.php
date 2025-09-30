<?php

/**
 * Template for displaying single blog posts
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php
    $page_header_bg = get_field('page_header_background');
    $background_style = '';
    if ($page_header_bg):
        $background_style = 'background: url(\'' . esc_url($page_header_bg['url']) . '\') center center / cover no-repeat;';
    endif;
    ?>
    <section class="page-header page-header--single-post" style="<?php echo $background_style; ?>">
        <div class="container">
            <a href="<?php echo get_permalink(get_page_by_path('jaunumi')); ?>" class="back-btn">
                <span class="back-btn-text">Atpakaļ uz sarakstu</span>
            </a>

            <div>
                <div class="post-meta"><?php echo get_the_date('j.F Y'); ?></div>
                <h1><?php echo get_the_title(); ?></h1>
                <?php
                $subtitle = get_field('post_subtitle');
                if ($subtitle):
                ?>
                    <p class="sub-heading m-0"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div class="container has-aside">
        <div class="content">
            <article class="single-blog-post post">
                <div class="entry-content">
                    <?php the_content(); ?>

                    <?php
                    // Video section
                    if (function_exists('get_field')):
                        $video_file = get_field('post_video_file');
                        $video_image = get_field('post_video_image');
                        $video_title = get_field('post_video_title');
                        $video_author = get_field('post_video_author');
                        $video_description = get_field('post_video_description');

                        // Debug information (remove in production)
                        if (current_user_can('administrator')):
                            echo '<!-- Debug: Video file: ' . ($video_file ? 'exists' : 'not found') . ' -->';
                            echo '<!-- Debug: Video image: ' . ($video_image ? 'exists' : 'not found') . ' -->';
                        endif;

                        if ($video_file || $video_image):
                    ?>
                            <div class="video-holder" style="background: url(<?php echo esc_url($video_image ? $video_image['url'] : ''); ?>) center center / cover no-repeat;">
                                <?php if ($video_file): ?>
                                    <video muted playsinline controls class="bg-video">
                                        <source src="<?php echo esc_url($video_file['url']); ?>" type="<?php echo esc_attr($video_file['mime_type']); ?>">
                                    </video>
                                <?php endif; ?>

                                <div class="details">
                                    <button type="button" class="play-btn"></button>

                                    <h3 class="title"><?php echo esc_html($video_title ?: 'Video vieta'); ?></h3>
                                    <?php if ($video_author): ?>
                                        <span class="author">Videoprojekts eksperts: <strong><?php echo esc_html($video_author); ?></strong></span>
                                    <?php endif; ?>
                                    <?php if ($video_description): ?>
                                        <p class="description m-0"><?php echo esc_html($video_description); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Gallery section
                        $gallery_images = get_field('post_gallery');
                        if ($gallery_images):
                            $total_images = count($gallery_images);
                        ?>
                            <div class="inline-gallery">
                                <?php
                                // Show only first 3 images visually
                                $displayed_count = 0;
                                foreach ($gallery_images as $index => $image):
                                    $displayed_count++;
                                    $remaining = $total_images - $displayed_count;

                                    // Only show first 3 images visually
                                    if ($index < 3):
                                ?>
                                        <div class="gallery-item">
                                            <a href="<?php echo esc_url($image['url']); ?>" data-fancybox="gallery" data-caption="<?php echo esc_attr($image['title']); ?>">
                                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">

                                                <?php if ($index === 2 && $remaining > 0): ?>
                                                    <span class="amount">Vēl <?php echo $remaining; ?> bildes</span>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                <?php
                                    endif;
                                endforeach;
                                ?>

                                <?php
                                // Add hidden links for all remaining images (4th and beyond)
                                // This ensures all images are available in Fancybox gallery
                                if ($total_images > 3):
                                    for ($i = 3; $i < $total_images; $i++):
                                        $image = $gallery_images[$i];
                                ?>
                                        <a href="<?php echo esc_url($image['url']); ?>" data-fancybox="gallery" data-caption="<?php echo esc_attr($image['title']); ?>" style="display: none;">
                                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                        </a>
                                <?php
                                    endfor;
                                endif;
                                ?>
                            </div>
                        <?php endif; ?>
                </div>

                <footer>
                    <?php
                        $contact_button = get_field('contact_button');
                        if ($contact_button):
                    ?>
                        <a href="<?php echo esc_url($contact_button['url']); ?>" class="btn btn-secondary" <?php echo $contact_button['target'] ? 'target="' . esc_attr($contact_button['target']) . '"' : ''; ?>><?php echo esc_html($contact_button['title']); ?></a>
                    <?php endif; ?>

                    <?php
                        $show_social_media = get_field('show_social_media');
                        if ($show_social_media):
                    ?>
                        <div class="social-media d-flex align-items-center">
                            <span>Dalīties ar ierakstu</span>

                            <ul>
                                <?php
                                // Get current post data for sharing
                                $post_title = get_the_title();
                                $post_url = get_permalink();
                                $post_excerpt = wp_trim_words(get_the_excerpt() ?: get_the_content(), 20);

                                // Generate social media sharing URLs
                                $social_platforms = array(
                                    'facebook' => array(
                                        'icon' => 'post-fb-icon.svg',
                                        'label' => 'Facebook',
                                        'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($post_url) . '&quote=' . urlencode($post_title)
                                    ),
                                    'x' => array(
                                        'icon' => 'post-x-icon.svg',
                                        'label' => 'X (Twitter)',
                                        'url' => 'https://twitter.com/intent/tweet?text=' . urlencode($post_title) . '&url=' . urlencode($post_url)
                                    ),
                                    'linkedin' => array(
                                        'icon' => 'post-linkedin-icon.svg',
                                        'label' => 'LinkedIn',
                                        'url' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($post_url)
                                    ),
                                    'whatsapp' => array(
                                        'icon' => 'post-whatsapp-icon.svg',
                                        'label' => 'WhatsApp',
                                        'url' => 'https://wa.me/?text=' . urlencode($post_title . ' - ' . $post_url)
                                    ),
                                    'link' => array(
                                        'icon' => 'post-link-icon.svg',
                                        'label' => 'Kopēt saiti',
                                        'url' => '#'
                                    )
                                );

                                foreach ($social_platforms as $platform => $info):
                                ?>
                                    <li>
                                        <a href="<?php echo esc_url($info['url']); ?>" target="_blank" title="<?php echo esc_attr($info['label']); ?>" <?php echo $platform === 'link' ? 'onclick="copyToClipboard(\'' . esc_js($post_url) . '\'); return false;"' : ''; ?>>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $info['icon']; ?>" alt="<?php echo esc_attr($info['label']); ?>">
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </footer>
            </article>
        </div>
    <?php endif; ?>

    <aside class="sidebar">
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
                                            <div class="product-image"
                                                <a href="<?php echo esc_url($product->get_permalink()); ?>">
                                                    <?php echo $product->get_image('woocommerce_thumbnail'); ?>
                                                </a>
                                            </div>
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
    </div>

    <?php
    // Related posts section via template part
    get_template_part('template-parts/related-posts');
    ?>

    <?php
    // Related posts section
    if (function_exists('get_field')):
        $show_related_posts = get_field('show_related_posts');
        if ($show_related_posts):
            $related_posts_title = get_field('related_posts_title') ?: 'Tev varētu interesēt arī šie raksti';

            // Get related posts
            $related_posts = get_field('related_posts');
            if (!$related_posts) {
                // If no manual selection, get recent posts
                $related_posts_query = new WP_Query(array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 4,
                    'post__not_in' => array(get_the_ID()),
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));
            }
    ?>
            <section class="related-posts">
                <div class="container">
                    <h2 class="section-heading"><?php echo esc_html($related_posts_title); ?></h2>

                    <div class="posts-swiper">
                        <div class="swiper-holder">
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    <?php
                                    if ($related_posts):
                                        foreach ($related_posts as $related_post):
                                            $post_id = $related_post->ID;
                                    ?>
                                            <div class="swiper-slide">
                                                <article class="post-item">
                                                    <a href="<?php echo get_permalink($post_id); ?>" class="post-image">
                                                        <?php if (has_post_thumbnail($post_id)): ?>
                                                            <?php echo get_the_post_thumbnail($post_id, 'large'); ?>
                                                        <?php else: ?>
                                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/post-item-image-1.jpg" alt="">
                                                        <?php endif; ?>
                                                    </a>

                                                    <div class="details">
                                                        <div class="post-meta"><?php echo get_the_date('j.F Y', $post_id); ?></div>

                                                        <h3 class="entry-title">
                                                            <a class="blog-title-link" href="<?php echo get_permalink($post_id); ?>"><?php echo esc_html(get_the_title($post_id)); ?></a>
                                                        </h3>

                                                        <p class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt($post_id) ?: get_the_content($post_id), 20)); ?></p>
                                                    </div>
                                                </article>
                                            </div>
                                        <?php
                                        endforeach;
                                    elseif (isset($related_posts_query) && $related_posts_query->have_posts()):
                                        while ($related_posts_query->have_posts()):
                                            $related_posts_query->the_post();
                                        ?>
                                            <div class="swiper-slide">
                                                <article class="post-item">
                                                    <a href="<?php echo get_permalink(); ?>" class="post-image">
                                                        <?php if (has_post_thumbnail()): ?>
                                                            <?php the_post_thumbnail('large'); ?>
                                                        <?php else: ?>
                                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/post-item-image-1.jpg" alt="">
                                                        <?php endif; ?>
                                                    </a>

                                                    <div class="details">
                                                        <div class="post-meta"><?php echo get_the_date('j.F Y'); ?></div>

                                                        <h3 class="entry-title">
                                                            <a href="<?php echo get_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a>
                                                        </h3>

                                                        <p class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: get_the_content(), 20)); ?></p>
                                                    </div>
                                                </article>
                                            </div>
                                    <?php
                                        endwhile;
                                        wp_reset_postdata();
                                    endif;
                                    ?>
                                </div>
                            </div>


                            
                            <div class="swiper-nav">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
