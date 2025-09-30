<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header id="masthead" class="site-header">
        <div class="container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="<?php bloginfo('name'); ?>">
            </a>

            <nav id="site-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu-list',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>

                <div class="mobile-view d-lg-none">
                    <?php
                    // Получаем ссылку именно на страницу со слагом 'kontakti'
                    $kontakti_page = get_page_by_path('kontakti');
                    $kontakti_url = $kontakti_page ? get_permalink($kontakti_page->ID) : home_url('/');
                    ?>
                    <a href="<?php echo esc_url($kontakti_url); ?>" class="btn btn-primary w-100" role="button">
                        Pieteikt pakalpojumu
                    </a>
                </div>
            </nav>

            <div class="buttons d-flex align-items-center">
                <?php
                $header_phone = get_theme_mod('header_phone', '+371 22 525 100');
                ?>
                <a href="tel:<?php echo esc_attr($header_phone); ?>" class="header-phone">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/header-phone-icon.svg" alt="">
                    <span><?php echo esc_html($header_phone); ?></span>
                </a>

                <?php
                // Получаем ссылку именно на страницу со слагом 'kontakti'
                $kontakti_page = get_page_by_path('kontakti');
                $kontakti_url = $kontakti_page ? get_permalink($kontakti_page->ID) : home_url('/');
                ?>
                <a href="<?php echo esc_url($kontakti_url); ?>" class="btn btn-primary">Pieteikt pakalpojumu</a>
            </div>

            <button type="button" class="menu-toggle">
                <i class="icon"></i>
            </button>
        </div>
    </header>