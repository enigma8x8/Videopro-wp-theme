<?php

/**
 * Template Name: Galvenā lapa
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <section class="home-hero">
        <div class="container">
            <div class="details">
                <h1><?php echo esc_html(get_field('hero_title') ?: 'Lūdzu, aizpildiet datus ACF'); ?></h1>
                <p class="sub-heading"><?php echo esc_html(get_field('hero_subtitle') ?: 'Lūdzu, aizpildiet datus ACF'); ?></p>

                <div class="trust-rating">
                    <div class="users-photos d-flex align-items-center">
                        <div class="list d-flex">
                            <?php
                            $user_photos = get_field('user_photos');
                            if ($user_photos && is_array($user_photos)):
                                foreach ($user_photos as $photo):
                                    if (is_array($photo) && isset($photo['url'])):
                            ?>
                                        <img src="<?php echo esc_url($photo['url']); ?>" alt="<?php echo esc_attr($photo['alt'] ?? ''); ?>">
                                    <?php
                                    endif;
                                endforeach;
                            elseif ($user_photos && is_string($user_photos)):
                                // If it's a single image
                                $photo_url = $user_photos;
                                if ($photo_url):
                                    ?>
                                    <img src="<?php echo esc_url($photo_url); ?>" alt="">
                                <?php
                                endif;
                            else:
                                // Fallback to default images
                                for ($i = 1; $i <= 5; $i++):
                                ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/user-photo-<?php echo $i; ?>.png" alt="">
                            <?php
                                endfor;
                            endif;
                            ?>
                        </div>

                        <span class="amount">+<?php
                                                $trust_rating = get_field('trust_rating');
                                                echo esc_html((is_array($trust_rating) && isset($trust_rating['users_count'])) ? $trust_rating['users_count'] : '295');
                                                ?></span>
                    </div>
                    <p><?php
                        $trust_rating = get_field('trust_rating');
                        $description = (is_array($trust_rating) && isset($trust_rating['description'])) ? $trust_rating['description'] : 'Mums uzticas vairāk kā <strong>400 uzņēmumu</strong> un pašvaldību visā Latvijas teritorijā';
                        echo wp_kses_post($description);
                        ?></p>

                    <div class="rating-stars">
                        <div class="stars">
                            <?php
                            $stars_image = get_field('stars_image');
                            if ($stars_image && is_array($stars_image) && isset($stars_image['url'])):
                            ?>
                                <img src="<?php echo esc_url($stars_image['url']); ?>" alt="<?php echo esc_attr($stars_image['alt'] ?? ''); ?>">
                            <?php else: ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/stars-image.svg" alt="">
                            <?php endif; ?>
                        </div>

                        <span><?php
                                $trust_rating = get_field('trust_rating');
                                echo esc_html((is_array($trust_rating) && isset($trust_rating['rating_score'])) ? $trust_rating['rating_score'] : 'Lūdzu, aizpildiet datus ACF');
                                ?> Reitings</span>
                    </div>
                </div>
            </div>

            <div class="video-gallery">
                <div class="list">
                    <div class="left-side">
                        <?php
                        $hero_videos = get_field('hero_videos');
                        if ($hero_videos && is_array($hero_videos)):
                            foreach ($hero_videos as $video):
                                if (is_array($video) && (isset($video['position']) && $video['position'] === 'left' || !isset($video['position']))):
                        ?>
                                    <div class="left-side__video">
                                        <video autoplay="" loop="" muted="" playsinline="">
                                            <source src="<?php echo esc_url($video['video_file'] ?? ''); ?>" type="video/mp4">
                                        </video>
                                    </div>
                        <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>

                    <div class="right-side">
                        <?php
                        if ($hero_videos && is_array($hero_videos)):
                            foreach ($hero_videos as $video):
                                if (is_array($video) && isset($video['position']) && $video['position'] === 'right'):
                        ?>
                                    <div class="right-side__video">
                                        <video autoplay="" loop="" muted="" playsinline="">
                                            <source src="<?php echo esc_url($video['video_file'] ?? ''); ?>" type="video/mp4">
                                        </video>
                                    </div>
                        <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="brands-logos">
        <div class="container">
            <ul class="list d-flex">
                <?php
                $brands_logos = get_field('brands_logos');
                if ($brands_logos && is_array($brands_logos)):
                    foreach ($brands_logos as $logo):
                        if (is_array($logo) && isset($logo['url'])):
                ?>
                            <li class="item">
                                <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt'] ?? ''); ?>">
                            </li>
                    <?php
                        endif;
                    endforeach;
                elseif ($brands_logos && is_string($brands_logos)):
                    // If it's a single image
                    ?>
                    <li class="item">
                        <img src="<?php echo esc_url($brands_logos); ?>" alt="">
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </section>

    <section class="home-services">
        <div class="container">
            <div class="section-heading-holder">
                <h2 class="section-heading"><?php
                                            $services_section = get_field('services_section');
                                            echo esc_html((is_array($services_section) && isset($services_section['title'])) ? $services_section['title'] : 'Lūdzu, aizpildiet datus ACF');
                                            ?></h2>
                <p class="sub-heading"><?php
                                        $services_section = get_field('services_section');
                                        echo esc_html((is_array($services_section) && isset($services_section['description'])) ? $services_section['description'] : 'Lūdzu, aizpildiet datus ACF');
                                        ?></p>
            </div>

            <div class="services-grid grid-4">
                <?php
                // Query services
                $services_query = new WP_Query(array(
                    'post_type' => 'services',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));

                if ($services_query->have_posts()):
                    while ($services_query->have_posts()):
                        $services_query->the_post();

                        // Get ACF fields
                        $service_short_description = get_field('service_short_description');
                        $service_external_link = get_field('service_external_link');

                        // Determine link
                        $service_link = $service_external_link ? $service_external_link : get_permalink();
                        $service_target = $service_external_link ? 'target="_blank"' : '';
                ?>
                        <div class="service-item">
                            <h3 class="name d-flex align-items-center">
                                <div class="icon">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    <?php else: ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-service-icon.svg" alt="<?php echo esc_attr(get_the_title()); ?>">
                                    <?php endif; ?>
                                </div>

                                <a href="<?php echo esc_url($service_link); ?>" <?php echo $service_target; ?> class="service-title-link">
                                    <span><?php echo esc_html(get_the_title()); ?></span>
                                </a>
                            </h3>

                            <p class="service-description m-0"><?php echo esc_html($service_short_description ?: get_the_excerpt()); ?></p>

                            <div class="service-button">
                                <a href="<?php echo esc_url($service_link); ?>" <?php echo $service_target; ?> class="btn btn-service">
                                    Apskatit
                                </a>
                            </div>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <section class="faq-home">
        <div class="container">
            <div class="blocks-holder">
                <div class="block">
                    <h2 class="block-heading"><?php
                                                $news_section = get_field('news_section');
                                                echo esc_html((is_array($news_section) && isset($news_section['title'])) ? $news_section['title'] : 'Lūdzu, aizpildiet datus ACF');
                                                ?></h2>

                    <div class="posts-list">
                        <?php
                        $news_section = get_field('news_section');
                        $news_posts = $news_section ? $news_section['posts'] : null;
                        if ($news_posts):
                            foreach ($news_posts as $post):
                                setup_postdata($post);
                        ?>
                                <article class="item">
                                    <a href="<?php echo get_permalink($post->ID); ?>" class="post-image">
                                        <?php if (has_post_thumbnail($post->ID)): ?>
                                            <?php echo get_the_post_thumbnail($post->ID, 'medium'); ?>
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/home-post-item-image-1.jpg" alt="">
                                        <?php endif; ?>
                                    </a>

                                    <div class="details">
                                        <div class="post-meta"><?php echo get_the_date('j.F Y', $post->ID); ?></div>

                                        <h3 class="entry-title">
                                            <a href="<?php echo get_permalink($post->ID); ?>"><?php echo esc_html($post->post_title); ?></a>
                                        </h3>

                                        <p class="excerpt m-0"><?php echo esc_html(wp_trim_words($post->post_excerpt ?: $post->post_content, 20)); ?></p>
                                    </div>
                                </article>
                        <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>

                    <?php
                    $news_section = get_field('news_section');
                    $more_news_link = $news_section ? $news_section['more_news_link'] : null;
                    if ($more_news_link):
                    ?>
                        <div class="btn-holder">
                            <a href="<?php echo esc_url($more_news_link['url']); ?>" class="btn btn-primary" <?php echo $more_news_link['target'] ? 'target="' . esc_attr($more_news_link['target']) . '"' : ''; ?>><?php echo esc_html($more_news_link['title']); ?></a>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="block">
                    <h2 class="block-heading"><?php
                                                $faq_section = get_field('faq_section');
                                                echo esc_html((is_array($faq_section) && isset($faq_section['title'])) ? $faq_section['title'] : 'Lūdzu, aizpildiet datus ACF');
                                                ?></h2>

                    <div class="accordion" id="faq-accordion">
                        <?php
                        $faq_section = get_field('faq_section');
                        $faq_items = $faq_section ? $faq_section['faq_items'] : null;
                        if ($faq_items):
                            $faq_counter = 1;
                            foreach ($faq_items as $faq):
                        ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button <?php echo $faq_counter > 1 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $faq_counter; ?>" aria-expanded="<?php echo $faq_counter === 1 ? 'true' : 'false'; ?>" aria-controls="collapse-<?php echo $faq_counter; ?>"><?php echo esc_html($faq['question'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></button>
                                    </h2>

                                    <div id="collapse-<?php echo $faq_counter; ?>" class="accordion-collapse collapse <?php echo $faq_counter === 1 ? 'show' : ''; ?>" data-bs-parent="#faq-accordion">
                                        <div class="accordion-body">
                                            <?php echo wp_kses_post($faq['answer'] ?: 'Lūdzu, aizpildiet datus ACF'); ?>
                                        </div>
                                    </div>
                                </div>
                        <?php
                                $faq_counter++;
                            endforeach;
                        endif;
                        ?>
                    </div>

                    <?php
                    $faq_section = get_field('faq_section');
                    $contact_link = $faq_section ? $faq_section['contact_link'] : null;
                    if ($contact_link):
                    ?>
                        <div class="btn-holder">
                            <a href="<?php echo esc_url($contact_link['url']); ?>" class="btn btn-secondary" <?php echo $contact_link['target'] ? 'target="' . esc_attr($contact_link['target']) . '"' : ''; ?>><?php echo esc_html($contact_link['title']); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php
    $stats_section = get_field('stats_section');
    if ($stats_section):
    ?>
        <section class="stats">
            <?php
            $background_video = $stats_section['background_video'] ?? null;
            if ($background_video && is_array($background_video) && isset($background_video['url'])):
            ?>
                <video autoplay="" loop="" muted="" playsinline="" class="bg-video">
                    <source src="<?php echo esc_url($background_video['url']); ?>" type="video/mp4">
                </video>
            <?php endif; ?>

            <div class="container">
                <h2 class="section-heading"><?php echo esc_html($stats_section['title'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></h2>

                <div class="stats-list">
                    <?php
                    $stats_list = $stats_section['stats_list'];
                    if ($stats_list):
                        foreach ($stats_list as $stat):
                    ?>
                            <div class="stat-item">
                                <span class="stat-item--number"><?php echo esc_html($stat['number'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></span>
                                <span class="stat-item--text"><?php echo esc_html($stat['text'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></span>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>