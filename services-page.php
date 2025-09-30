<?php

/**
 * Template Name: Pakalpojumu lapa
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php
    $page_header = get_field('page_header');
    if ($page_header):
        $background_style = '';
        if ($page_header['background_image']):
            $background_style = 'background: url(\'' . esc_url($page_header['background_image']['url']) . '\') center center / cover no-repeat;';
        endif;
    ?>
        <section class="page-header" style="<?php echo $background_style; ?>">
            <div class="container">
                <h1><?php echo esc_html($page_header['title'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></h1>
                <p class="sub-heading m-0"><?php echo esc_html($page_header['subtitle'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></p>
            </div>
        </section>
    <?php endif; ?>

    <div class="container">
        <div class="single-services">
            <div class="services-grid grid-4">
                <?php
                // Pagination settings (optional ACF field), default 12
                $posts_per_page = get_field('posts_per_page') ?: 12;
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                // Query services (paged)
                $services_query = new WP_Query(array(
                    'post_type' => 'services',
                    'post_status' => 'publish',
                    'posts_per_page' => $posts_per_page,
                    'paged' => $paged,
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
                        <div class="service-item clickable-card" role="link" tabindex="0" data-href="<?php echo esc_url($service_link); ?>" data-target="<?php echo $service_target ? '_blank' : '_self'; ?>">
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

                            
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelectorAll('.single-services .service-item.clickable-card').forEach(function(card) {
                            var url = card.getAttribute('data-href');
                            var target = card.getAttribute('data-target') || '_self';
                            if (!url) return;

                            function navigate() {
                                if (target === '_blank') {
                                    window.open(url, '_blank');
                                } else {
                                    window.location.href = url;
                                }
                            }
                            card.addEventListener('click', function(e) {
                                var interactive = e.target.closest('a, button, input, textarea, select');
                                if (interactive) return;
                                navigate();
                            });
                            card.addEventListener('keydown', function(e) {
                                if (e.key === 'Enter' || e.keyCode === 13) {
                                    navigate();
                                }
                            });
                            card.style.cursor = 'pointer';
                        });
                    });
                </script>
            </div>
            <?php if (!empty($services_query) && $services_query->max_num_pages > 1): ?>
                <nav class="navigation pagination">
                    <div class="nav-links">
                        <?php
                        $big = 999999999; // need an unlikely integer
                        echo paginate_links(array(
                            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                            'format' => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'total' => $services_query->max_num_pages,
                            'prev_text' => '<',
                            'next_text' => '>',
                            'type' => 'plain',
                            'end_size' => 1,
                            'mid_size' => 1
                        ));
                        ?>
                    </div>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>