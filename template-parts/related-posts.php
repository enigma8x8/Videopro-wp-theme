<?php
/**
 * Related posts section (slider)
 * Markup and classes follow html/single-blog-post.html exactly.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post;

// Collect related posts by tags first, then categories; fallback to latest posts
$related_args = [
    'post_type'           => 'post',
    'posts_per_page'      => 8,
    'ignore_sticky_posts' => true,
    'post__not_in'        => [$post->ID],
];

$tax_query = [];

$tags = wp_get_post_terms($post->ID, 'post_tag', ['fields' => 'ids']);
if (!empty($tags)) {
    $tax_query[] = [
        'taxonomy' => 'post_tag',
        'field'    => 'term_id',
        'terms'    => $tags,
    ];
}

// If no tags, try categories
if (empty($tax_query)) {
    $cats = wp_get_post_terms($post->ID, 'category', ['fields' => 'ids']);
    if (!empty($cats)) {
        $tax_query[] = [
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $cats,
        ];
    }
}

if (!empty($tax_query)) {
    $related_args['tax_query'] = [
        'relation' => 'OR',
        ...$tax_query,
    ];
}

$related_query = new WP_Query($related_args);

// Do not render if there are no posts
if (!$related_query->have_posts()) {
    wp_reset_postdata();
    return;
}
?>

<section class="related-posts">
    <div class="container">
        <h2 class="section-heading">Tev varētu interesēt arī šie raksti</h2>

        <div class="posts-swiper">
            <div class="swiper-holder">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                            <div class="swiper-slide">
                                <article class="post-item">
                                    <a href="<?php echo esc_url(get_permalink()); ?>" class="post-image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('large'); ?>
                                        <?php else : ?>
                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/post-item-image-1.jpg'); ?>" alt="" />
                                        <?php endif; ?>
                                    </a>

                                    <div class="details">
                                        <div class="post-meta"><?php echo esc_html(get_the_date()); ?></div>

                                        <h3 class="entry-title">
                                            <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
                                        </h3>

                                        <p class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
                                    </div>
                                </article>
                            </div>
                        <?php endwhile; ?>
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

<?php wp_reset_postdata();
