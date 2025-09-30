<?php

/**
 * Template Name: Kontaktu lapa
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

    <div class="contacts-page">
        <div class="container has-aside">
            <div class="content">
                <?php
                $main_content = get_field('main_content');
                if ($main_content):
                ?>
                    <?php if ($main_content['description']): ?>
                        <p><?php echo esc_html($main_content['description']); ?></p>
                    <?php endif; ?>

                    <?php
                    $persons = $main_content['persons'];
                    if ($persons):
                    ?>
                        <div class="persons-list">
                            <?php foreach ($persons as $person): ?>
                                <div class="person-item">
                                    <?php if ($person['photo']): ?>
                                        <div class="photo d-flex align-items-center justify-content-center">
                                            <img src="<?php echo esc_url($person['photo']['url']); ?>" alt="<?php echo esc_attr($person['photo']['alt']); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <div class="details">
                                        <h3 class="name"><?php echo esc_html($person['name'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></h3>
                                        <span class="position"><?php echo esc_html($person['position'] ?: 'Lūdzu, aizpildiet datus ACF'); ?></span>

                                        <ul>
                                            <?php if ($person['phone']): ?>
                                                <li>
                                                    <a href="tel:<?php echo esc_attr($person['phone']); ?>"><?php echo esc_html($person['phone']); ?></a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if ($person['email']): ?>
                                                <li>
                                                    <a href="mailto:<?php echo esc_attr($person['email']); ?>"><?php echo esc_html($person['email']); ?></a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php
                $map = get_field('map');
                if ($map && $map['title']):
                ?>
                    <div class="map-holder">
                        <h2><?php echo esc_html($map['title']); ?></h2>

                        <?php if ($map['embed_code']): ?>
                            <?php echo wp_kses($map['embed_code'], array(
                                'iframe' => array(
                                    'src' => array(),
                                    'width' => array(),
                                    'height' => array(),
                                    'style' => array(),
                                    'allowfullscreen' => array(),
                                    'loading' => array(),
                                    'referrerpolicy' => array()
                                )
                            )); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <aside class="sidebar">
                <?php
                $sidebar = get_field('sidebar');
                if ($sidebar):
                ?>
                    <?php get_template_part('template-parts/order-form-sidebar-2'); ?>

                    <?php
                    $company_info = $sidebar['company_info'];
                    if ($company_info):
                    ?>
                        <div class="company-contacts">
                            <?php if ($company_info['photo']): ?>
                                <div class="image">
                                    <img src="<?php echo esc_url($company_info['photo']['url']); ?>" alt="<?php echo esc_attr($company_info['photo']['alt']); ?>">
                                </div>
                            <?php endif; ?>

                            <ul>
                                <?php if ($company_info['name']): ?>
                                    <li><?php echo esc_html($company_info['name']); ?></li>
                                <?php endif; ?>

                                <?php if ($company_info['reg_number']): ?>
                                    <li><?php echo esc_html($company_info['reg_number']); ?></li>
                                <?php endif; ?>

                                <?php if ($company_info['address']): ?>
                                    <li><?php echo esc_html($company_info['address']); ?></li>
                                <?php endif; ?>

                                <?php if ($company_info['office']): ?>
                                    <li><?php echo esc_html($company_info['office']); ?></li>
                                <?php endif; ?>

                                <?php if ($company_info['account']): ?>
                                    <li><?php echo esc_html($company_info['account']); ?></li>
                                <?php endif; ?>

                                <?php if ($company_info['bank']): ?>
                                    <li><?php echo esc_html($company_info['bank']); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</main>

<?php get_footer(); ?>