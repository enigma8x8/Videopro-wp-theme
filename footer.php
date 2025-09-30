        <footer id="main-footer">
            <div class="footer-top">
                <div class="container">
                    <ul class="links d-flex">
                        <?php
                        // Privātuma politika link
                        $privacy_pages = get_posts(array(
                            'post_type' => 'page',
                            'title' => 'Privātuma politika',
                            'post_status' => 'publish',
                            'numberposts' => 1
                        ));
                        $privacy_page = !empty($privacy_pages) ? $privacy_pages[0] : null;
                        if ($privacy_page) {
                            echo '<li><a href="' . get_permalink($privacy_page->ID) . '">Privātuma politika</a></li>';
                        } else {
                            echo '<li><a href="#">Privātuma politika</a></li>';
                        }

                        // E-veikala lietošanas noteikumi link
                        $terms_pages = get_posts(array(
                            'post_type' => 'page',
                            'title' => 'E-veikala lietošanas noteikumi',
                            'post_status' => 'publish',
                            'numberposts' => 1
                        ));
                        $terms_page = !empty($terms_pages) ? $terms_pages[0] : null;
                        if ($terms_page) {
                            echo '<li><a href="' . get_permalink($terms_page->ID) . '">E-veikala lietošanas noteikumi</a></li>';
                        } else {
                            echo '<li><a href="#">E-veikala lietošanas noteikumi</a></li>';
                        }
                        ?>
                    </ul>

                    <div class="social-media">
                        <span>Seko mums</span>

                        <ul class="d-flex">
                            <?php
                            $youtube_url = get_theme_mod('social_youtube', '');
                            if ($youtube_url) {
                                echo '<li><a href="' . esc_url($youtube_url) . '" target="_blank"><img src="' . get_template_directory_uri() . '/assets/images/footer-yt-icon.svg" alt="YouTube"></a></li>';
                            }

                            $facebook_url = get_theme_mod('social_facebook', '');
                            if ($facebook_url) {
                                echo '<li><a href="' . esc_url($facebook_url) . '" target="_blank"><img src="' . get_template_directory_uri() . '/assets/images/footer-fb-icon.svg" alt="Facebook"></a></li>';
                            }

                            $instagram_url = get_theme_mod('social_instagram', '');
                            if ($instagram_url) {
                                echo '<li><a href="' . esc_url($instagram_url) . '" target="_blank"><img src="' . get_template_directory_uri() . '/assets/images/footer-ig-icon.svg" alt="Instagram"></a></li>';
                            }

                            $linkedin_url = get_theme_mod('social_linkedin', '');
                            if ($linkedin_url) {
                                echo '<li><a href="' . esc_url($linkedin_url) . '" target="_blank"><img src="' . get_template_directory_uri() . '/assets/images/footer-linkedin-icon.svg" alt="LinkedIn"></a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer-content">
                <div class="container">
                    <div class="left-side">
                        <div class="menu-col">
                            <h4 class="widget-title">Pakalpojumi</h4>

                            <ul class="menu">
                                <?php
                                // Get services from database
                                $services = get_posts(array(
                                    'post_type' => 'services',
                                    'numberposts' => -1,
                                    'post_status' => 'publish',
                                    'orderby' => 'menu_order',
                                    'order' => 'ASC'
                                ));

                                if ($services) {
                                    foreach ($services as $service) {
                                        echo '<li class="menu-item">';
                                        echo '<a href="' . get_permalink($service->ID) . '">' . get_the_title($service->ID) . '</a>';
                                        echo '</li>';
                                    }
                                } else {
                                    // Fallback to static list if no services found
                                    $default_services = array(
                                        'Pilsētu drošība',
                                        'Videonovērošana',
                                        'Apsardzes sistēmas',
                                        'Tīkli un optika',
                                        'Datori un iekārtas',
                                        'Industriālās sistēmas',
                                        'Led risinājumi',
                                        'Video filmēšana',
                                        'Programmatūra'
                                    );

                                    foreach ($default_services as $service_name) {
                                        echo '<li class="menu-item">';
                                        echo '<a href="#">' . $service_name . '</a>';
                                        echo '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>

                        <div class="menu-col">
                            <h4 class="widget-title">Navigācija</h4>

                            <?php
                            if (has_nav_menu('navigacija')) {
                                wp_nav_menu(array(
                                    'theme_location' => 'navigacija',
                                    'menu_class' => 'menu',
                                    'container' => false,
                                    'fallback_cb' => false
                                ));
                            } else {
                                echo '<ul class="menu">';
                                echo '<li class="menu-item"><a href="' . home_url() . '">Galvenā</a></li>';
                                echo '<li class="menu-item"><a href="' . home_url('/pakalpojumi/') . '">Pakalpojumi</a></li>';
                                echo '<li class="menu-item"><a href="' . home_url('/pieredze/') . '">Pieredze</a></li>';
                                echo '<li class="menu-item"><a href="' . home_url('/par-mums/') . '">Par mums</a></li>';
                                echo '<li class="menu-item"><a href="' . home_url('/aktualitates/') . '">Aktualitātes</a></li>';
                                echo '<li class="menu-item"><a href="' . home_url('/e-veikals/') . '">E-veikals</a></li>';
                                echo '</ul>';
                            }
                            ?>
                        </div>

                        <div class="menu-col">
                            <h4 class="widget-title">Atbalsts</h4>

                            <?php
                            if (has_nav_menu('atbalsts')) {
                                wp_nav_menu(array(
                                    'theme_location' => 'atbalsts',
                                    'menu_class' => 'menu',
                                    'container' => false,
                                    'fallback_cb' => false
                                ));
                            } else {
                                echo '<ul class="menu">';
                                echo '<li class="menu-item"><a href="' . home_url('/kontakti/') . '">Kontakti</a></li>';
                                echo '<li class="menu-item"><a href="' . home_url('/tehniska-palidziba/') . '">Tehniskā palīdzība</a></li>';
                                echo '<li class="menu-item"><a href="' . home_url('/sadarbibas-partneriem/') . '">Sadarbības partneriem</a></li>';
                                echo '<li class="menu-item"><a href="' . home_url('/buj/') . '">BUJ</a></li>';
                                echo '</ul>';
                            }
                            ?>
                        </div>
                    </div>


                    <div class="right-side">
                        <div class="newsletter">
                            <form action="#" method="post">
                                <div class="input-holder">
                                    <?php echo do_shortcode('[gravityform id="1" title="true"]'); ?>
                                </div>
                                    <span class="confirm-text d-block">Pierakstot e-pastu, jūs piekrītat videoprojekts.lv <a href="<?php echo $privacy_page ? get_permalink($privacy_page->ID) : '#'; ?>" target="_blank">privātuma politikai</a>.</span>
                        
                            </div>

                        <div class="footer-logos">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-logos/footer-logo-1.svg" alt="">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-logos/footer-logo-2.svg" alt="">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-logos/footer-logo-3.svg" alt="">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-logos/footer-logo-4.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <span class="copyrights">&copy; <?php echo date('Y'); ?> videoprojekts.lv Visas tiesības aizsargātas</span>

                    
                </div>
            </div>
        </footer>

        <div class="content-overlay"></div>

        <?php wp_footer(); ?>
        </body>

        </html>