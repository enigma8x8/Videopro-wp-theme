<?php

/**
 * Template Name: Blog lapa
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
    <?php
    $page_header = get_field('page_header');
    if ($page_header):
    ?>

        <section class="page-header">
            <div class="container">
                <h1><?php echo esc_html($page_header['title'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></h1>
                <p class="sub-heading m-0"><?php echo esc_html($page_header['subtitle'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></p>
            </div>
        </section>
    <?php endif; ?>

    <div class="container">
        <?php
        // Get ACF settings
        $posts_per_page = get_field('posts_per_page') ?: 9;
        $excerpt_length = get_field('excerpt_length') ?: 20;
        $show_pagination = get_field('show_pagination') !== false; // Default to true

        // Get current page
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        // Query posts
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $blog_query = new WP_Query($args);

        if ($blog_query->have_posts()):
        ?>
            <div class="posts-grid grid-3">
                <?php
                while ($blog_query->have_posts()):
                    $blog_query->the_post();
                ?>
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
                                <a href="<?php echo get_permalink(); ?>" class="blog-title-link"><?php echo esc_html(get_the_title()); ?></a>
                            </h3>

                            <p class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: get_the_content(), $excerpt_length)); ?></p>
                            <style>
                                /* отключаем псевдо-элемент у ссылки заголовка */
                                .post-item .entry-title .blog-title-link::after {
                                content: none !important;   /* псевдо-элемент вовсе не создаётся */
                                /* подстраховка, если тема всё равно что-то рисует */
                                display: none !important;
                                background: none !important;
                                width: 0 !important;
                                height: 0 !important;
                                }
                            </style>

                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <?php if ($show_pagination && $blog_query->max_num_pages > 1): ?>
                <nav class="navigation pagination">
                    <div class="nav-links">
                        <?php
                        $big = 999999999; // need an unlikely integer
                        echo paginate_links(array(
                            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                            'format' => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'total' => $blog_query->max_num_pages,
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

        <?php else: ?>
            <div class="no-posts">
                <p><?php _e('Nav atrasts neviens posts.', 'videoprojects'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>