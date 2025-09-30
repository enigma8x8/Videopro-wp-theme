<?php

/**
 * Template Name: Par mums lapa
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php
    $page_header = get_field('page_header');
    if ($page_header):
    ?>
        <section class="page-header page-header--about-us has-video">
            <?php if ($page_header['background_video']): ?>
                <video autoplay="" loop="" muted="" playsinline="" class="bg-video">
                    <source src="<?php echo esc_url($page_header['background_video']['url']); ?>" type="video/mp4">
                </video>
            <?php endif; ?>

            <div class="container">
                <div>
                    <h1><?php echo esc_html($page_header['title'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></h1>
                    <p class="sub-heading m-0"><?php echo esc_html($page_header['subtitle'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></p>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <div class="about-us-page container has-aside">
        <div class="content">
            <?php
            $main_content = get_field('main_content');
            if ($main_content):
            ?>
                <?php if ($main_content['description']): ?>
                    <?php echo wp_kses_post($main_content['description']); ?>
                <?php endif; ?>

                <?php if ($main_content['key_facts_title']): ?>
                    <h2><?php echo esc_html($main_content['key_facts_title']); ?></h2>
                <?php endif; ?>

                <?php
                $key_facts = $main_content['key_facts'];
                if ($key_facts):
                ?>
                    <ul>
                        <?php foreach ($key_facts as $fact): ?>
                            <li><?php echo wp_kses_post($fact['text']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endif; ?>

            <?php
            $certificates = get_field('certificates');
            if ($certificates && $certificates['title']):
            ?>
                <h2><?php echo esc_html($certificates['title']); ?></h2>

                <?php
                $certificates_list = $certificates['certificates_list'];
                if ($certificates_list):
                ?>
                    <div class="certificates-grid">
                        <?php foreach ($certificates_list as $certificate): ?>
                            <a data-fancybox="gallery" href="<?php echo esc_url($certificate['url']); ?>" class="certificate-item">
                                <img src="<?php echo esc_url($certificate['url']); ?>" alt="<?php echo esc_attr($certificate['alt']); ?>">
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <aside class="sidebar">
            <?php get_template_part('template-parts/order-form-sidebar-4'); ?>

            <div class="sidebar-services">
                <h3 class="block-title">Pakalpojumu saraksts</h3>

                <?php
                // Query services from custom post type
                $services_query = new WP_Query(array(
                    'post_type' => 'services',
                    'post_status' => 'publish',
                    'posts_per_page' => 6,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));

                if ($services_query->have_posts()):
                ?>
                    <ul class="list">
                        <?php while ($services_query->have_posts()): $services_query->the_post(); ?>
                            <li>
                                <a href="<?php echo get_permalink(); ?>" class="service-item d-flex align-items-center">
                                    <?php
                                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                                    if ($thumbnail_url):
                                    ?>
                                        <div class="icon">
                                            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <span><?php echo esc_html(get_the_title()); ?></span>
                                </a>
                            </li>
                        <?php endwhile;
                        wp_reset_postdata();
                        ?>
                    </ul>
                <?php else: ?>
                    <p>Nav pieejami pakalpojumi.</p>
                <?php endif; ?>
            </div>
        </aside>
    </div>

    <?php
    $reviews = get_field('reviews');
    if ($reviews && $reviews['title']):
        $reviews_list = $reviews['reviews_list'];
        if ($reviews_list):
    ?>
            <div class="reviews-swiper">
                <div class="container">
                    <h2 class="block-heading"><?php echo esc_html($reviews['title']); ?></h2>

                    <div class="swiper-holder">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($reviews_list as $review): ?>
                                    <div class="swiper-slide">
                                        <article class="review-item">
                                            <header>
                                                <span class="author-name"><?php echo esc_html($review['author_name'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></span>
                                                <span class="author-position"><?php echo esc_html($review['author_position'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></span>
                                            </header>
                                            <div class="review-text">
                                                <p><?php echo esc_html($review['text'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></p>
                                            </div>
                                        </article>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="swiper-pagination rectangles"></div>
                    </div>
                </div>
            </div>
    <?php endif;
    endif; ?>

    <?php
    $team = get_field('team');
    if ($team):
    ?>
        <div class="container">
            <div class="person-contact d-flex align-items-start">
                <?php
                $team_members = $team['team_members'];
                if ($team_members):
                ?>
                    <div class="persons-list d-flex">
                        <?php foreach ($team_members as $member): ?>
                            <div class="persons-list__person">
                                <?php if ($member['photo']): ?>
                                    <div class="photo">
                                        <img src="<?php echo esc_url($member['photo']['url']); ?>" alt="<?php echo esc_attr($member['photo']['alt']); ?>">
                                    </div>
                                <?php endif; ?>

                                <h3 class="name"><?php echo esc_html($member['name'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></h3>
                                <span class="position d-block m-0"><?php echo esc_html($member['position'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="text">
                    <p><?php echo esc_html($team['description'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></p>

                    <?php if ($team['contact_link']): ?>
                        <a href="<?php echo esc_url($team['contact_link']['url']); ?>" class="btn btn-secondary" <?php echo $team['contact_link']['target'] ? 'target="' . esc_attr($team['contact_link']['target']) . '"' : ''; ?>><?php echo esc_html($team['contact_link']['title']); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>