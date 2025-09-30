<?php
get_header();
?>

<main id="site-main" class="site-main container py-5">
    <h1><?php bloginfo('name'); ?></h1>
    <p><?php bloginfo('description'); ?></p>

    <?php if (have_posts()) : ?>
        <ul class="post-list">
            <?php while (have_posts()) : the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <span class="post-date"><?php echo get_the_date(); ?></span>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p><?php esc_html_e('No posts found.', 'videoprojects'); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
