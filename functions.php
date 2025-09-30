<?php
// Empty cart on custom submit from cart form
add_action('template_redirect', function () {
    if (!is_admin() && isset($_POST['empty_cart']) && $_POST['empty_cart'] === '1') {
        if (isset($_POST['woocommerce-cart-nonce']) && wp_verify_nonce($_POST['woocommerce-cart-nonce'], 'woocommerce-cart')) {
            WC()->cart->empty_cart();
            wp_safe_redirect(wc_get_cart_url());
            exit;
        }
    }
});

/**
 * VideoProjects Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function videoprojects_setup()
{
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'videoprojects'),
        'footer' => __('Footer Menu', 'videoprojects'),
        'navigacija' => __('Navigācija', 'videoprojects'),
        'atbalsts' => __('Atbalsts', 'videoprojects'),
    ));
}
add_action('after_setup_theme', 'videoprojects_setup');

/**
 * Enqueue scripts and styles
 */
function videoprojects_scripts()
{
    // Get theme directory URI
    $theme_uri = get_template_directory_uri();

    // Enqueue CSS files
    wp_enqueue_style('bootstrap-reboot', $theme_uri . '/assets/bootstrap/scss/bootstrap-reboot.css', array(), '5.3.0');
    wp_enqueue_style('bootstrap-grid', $theme_uri . '/assets/bootstrap/scss/bootstrap-grid.css', array('bootstrap-reboot'), '5.3.0');
    wp_enqueue_style('bootstrap-utilities', $theme_uri . '/assets/bootstrap/scss/bootstrap-utilities.css', array('bootstrap-grid'), '5.3.0');

    // Vendor CSS first
    wp_enqueue_style('bootstrap-select', $theme_uri . '/assets/css/bootstrap-select.min.css', array('bootstrap-utilities'), '1.0.0');
    wp_enqueue_style('jquery-fancybox', $theme_uri . '/assets/css/jquery.fancybox.min.css', array(), '1.0.0');
    wp_enqueue_style('swiper-bundle', $theme_uri . '/assets/css/swiper-bundle.min.css', array(), '1.0.0');

    // Main theme stylesheet LAST so it can override vendors.
    $style_file = get_template_directory() . '/assets/css/style.css';
    $style_ver  = file_exists($style_file) ? filemtime($style_file) : '1.0.0';
    wp_enqueue_style(
        'videoprojects-style',
        $theme_uri . '/assets/css/style.css',
        array('bootstrap-utilities', 'bootstrap-select', 'jquery-fancybox', 'swiper-bundle'),
        $style_ver
    );
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css', array(), '1.11.3');

    // Enqueue JavaScript files
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-bundle', $theme_uri . '/assets/bootstrap/dist/js/bootstrap.bundle.js', array('jquery'), '5.3.0', true);
    wp_enqueue_script('swiper-bundle', $theme_uri . '/assets/js/swiper-bundle.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('bootstrap-select', $theme_uri . '/assets/js/bootstrap-select.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('jquery-fancybox', $theme_uri . '/assets/js/jquery.fancybox.min.js', array('jquery'), '1.0.0', true);
    // Ensure our functions run after bootstrap-select is available
    wp_enqueue_script('videoprojects-functions', $theme_uri . '/assets/js/functions.js', array('jquery', 'bootstrap-select'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'videoprojects_scripts');

/**
 * Register widget areas
 */
function videoprojects_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Footer Widget Area', 'videoprojects'),
        'id'            => 'footer-widget-area',
        'description'   => __('Add widgets here to appear in footer.', 'videoprojects'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'videoprojects_widgets_init');

/**
 * Customize excerpt length
 */
function videoprojects_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'videoprojects_excerpt_length');

/**
 * Customize excerpt more
 */
function videoprojects_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'videoprojects_excerpt_more');

/**
 * Add custom image sizes
 */
function videoprojects_image_sizes()
{
    add_image_size('hero-image', 1920, 1080, true);
    add_image_size('service-thumbnail', 400, 300, true);
    add_image_size('blog-thumbnail', 800, 600, true);
}
add_action('after_setup_theme', 'videoprojects_image_sizes');

/**
 * WooCommerce support
 */
function videoprojects_woocommerce_support()
{
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('woocommerce-breadcrumb');
}
add_action('after_setup_theme', 'videoprojects_woocommerce_support');






/**
 * ACF JSON sync
 */
function videoprojects_acf_json_save_point($path)
{
    return get_stylesheet_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'videoprojects_acf_json_save_point');

function videoprojects_acf_json_load_point($paths)
{
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'videoprojects_acf_json_load_point');

/**
 * Customizer settings
 */
function videoprojects_customize_register($wp_customize)
{
    // Header Settings Section
    $wp_customize->add_section('header_settings', array(
        'title'    => __('Header Settings', 'videoprojects'),
        'priority' => 30,
    ));

    // Header Phone Number
    $wp_customize->add_setting('header_phone', array(
        'default'           => '+371 22 525 100',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('header_phone', array(
        'label'   => __('Header Phone Number', 'videoprojects'),
        'section' => 'header_settings',
        'type'    => 'text',
    ));

    // E-veikala iestatījumi Section
    $wp_customize->add_section('contact_info_settings', array(
        'title'    => __('E-veikala iestatījumi', 'videoprojects'),
        'priority' => 35,
    ));

    // Contact Heading
    $wp_customize->add_setting('contact_heading', array(
        'default'           => 'Ir jautājumi?',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_heading', array(
        'label'   => __('Contact Section Heading', 'videoprojects'),
        'section' => 'contact_info_settings',
        'type'    => 'text',
    ));

    // Contact Description
    $wp_customize->add_setting('contact_description', array(
        'default'           => 'Sazinies ar mūsu atsaucīgo komandu, lai uzzinātu papildus informāciju par konkrētu produktu, piegādi vai apmaksas iespējām.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('contact_description', array(
        'label'   => __('Contact Description', 'videoprojects'),
        'section' => 'contact_info_settings',
        'type'    => 'textarea',
    ));

    // Contact Phone
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '+371 22525100',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label'   => __('Contact Phone', 'videoprojects'),
        'section' => 'contact_info_settings',
        'type'    => 'text',
    ));

    // Contact Email
    $wp_customize->add_setting('contact_email', array(
        'default'           => 'info@videoprojekts.lv',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label'   => __('Contact Email', 'videoprojects'),
        'section' => 'contact_info_settings',
        'type'    => 'email',
    ));

    // Products per page
    $wp_customize->add_setting('products_per_page', array(
        'default'           => 12,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('products_per_page', array(
        'label'       => __('Products per page', 'videoprojects'),
        'description' => __('Number of products to display on catalog pages', 'videoprojects'),
        'section'     => 'contact_info_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 100,
            'step' => 1,
        ),
    ));

    // Social Media Settings Section
    $wp_customize->add_section('social_media_settings', array(
        'title'    => __('Social Media Settings', 'videoprojects'),
        'priority' => 40,
    ));

    // YouTube URL
    $wp_customize->add_setting('social_youtube', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_youtube', array(
        'label'   => __('YouTube URL', 'videoprojects'),
        'section' => 'social_media_settings',
        'type'    => 'url',
    ));

    // Facebook URL
    $wp_customize->add_setting('social_facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_facebook', array(
        'label'   => __('Facebook URL', 'videoprojects'),
        'section' => 'social_media_settings',
        'type'    => 'url',
    ));

    // Instagram URL
    $wp_customize->add_setting('social_instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_instagram', array(
        'label'   => __('Instagram URL', 'videoprojects'),
        'section' => 'social_media_settings',
        'type'    => 'url',
    ));

    // LinkedIn URL
    $wp_customize->add_setting('social_linkedin', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_linkedin', array(
        'label'   => __('LinkedIn URL', 'videoprojects'),
        'section' => 'social_media_settings',
        'type'    => 'url',
    ));
}
add_action('customize_register', 'videoprojects_customize_register');

/**
 * Gravity Forms: disable Enhanced UI (Chosen) so we can style selects with Bootstrap Select
 */
add_filter('gform_enable_enhanced_ui', '__return_false');

/**
 * Set products per page from customizer
 */
function videoprojects_products_per_page()
{
    $products_per_page = get_theme_mod('products_per_page', 12);
    return $products_per_page;
}
add_filter('loop_shop_per_page', 'videoprojects_products_per_page', 20);

/**
 * Custom catalog ordering function
 */
function videoprojects_catalog_ordering()
{
    $orderby = isset($_GET['orderby']) ? wc_clean(wp_unslash($_GET['orderby'])) : 'date';

    $catalog_orderby_options = array(
        'date'       => __('Jaunākie produkti', 'videoprojects'),
        'date-old'   => __('Vecākie produkti', 'videoprojects'),
        'price'      => __('Cena: no zemākās uz augstāko', 'videoprojects'),
        'price-desc' => __('Cena: no augstākās uz zemāko', 'videoprojects'),
        'title'      => __('Pēc alfabēta', 'videoprojects'),
    );

    if (!empty($catalog_orderby_options)) {
        echo '<div class="sort-by">';
        echo '<div class="form-group">';
        echo '<label for="orderby">Kārtot pēc:</label>';
        // Use Bootstrap Select for styling to match catalog page
        echo '<select name="orderby" id="orderby" class="orderby selectpicker" data-width="fit" data-dropup-auto="false">';

        foreach ($catalog_orderby_options as $id => $name) {
            echo '<option value="' . esc_attr($id) . '" ' . selected($orderby, $id, false) . '>' . esc_html($name) . '</option>';
        }

        echo '</select>';
        echo '</div>';
        echo '</div>';
    }
}









// Корректная сортировка каталога
if (false) add_filter( 'woocommerce_get_catalog_ordering_args', function( $args, $orderby, $order ) {

    switch ( $orderby ) {

        case 'date-old': // старые сверху
            $args['orderby'] = 'date';
            $args['order']   = 'ASC';
            unset( $args['meta_key'], $args['meta_type'] );
            break;

        case 'title': // по алфавиту A→Z
            $args['orderby'] = 'title';
            $args['order']   = 'ASC';
            unset( $args['meta_key'], $args['meta_type'] );
            break;

        case 'price':     // цена ↑
        case 'price-desc':// цена ↓
            // 1) Путь по-умолчанию WooCommerce через lookup-таблицы
            $args['orderby'] = 'price';
            $args['order']   = ( $orderby === 'price' ) ? 'ASC' : 'DESC';
            unset( $args['meta_key'], $args['meta_type'] );

            // 2) Fallback: если по какой-то причине Woo не применит lookup,
            //    подстрахуемся мета-сортировкой по _price (работает на локали)
            add_filter( 'posts_clauses', function( $clauses, $wp_query ) use ( $orderby ) {
                // только для основного продуктового запроса каталога
                if ( ! is_admin()
                     && $wp_query->is_main_query()
                     && ( is_shop() || is_product_taxonomy() ) ) {

                    global $wpdb;

                    // если Woo не добавил ORDER BY price из lookup-таблиц,
                    // подменим ORDER BY на meta_value_num(_price)
                    if ( strpos( $clauses['orderby'], 'price' ) === false
                         && strpos( $clauses['orderby'], '_price' ) === false ) {

                        // присоединим мету _price, если её ещё нет
                        if ( strpos( $clauses['join'], "AS price_meta" ) === false ) {
                            $clauses['join'] .= " LEFT JOIN {$wpdb->postmeta} AS price_meta
                                ON ($wpdb->posts.ID = price_meta.post_id
                                AND price_meta.meta_key = '_price')";
                        }

                        $direction = ( $orderby === 'price' ) ? 'ASC' : 'DESC';
                        $clauses['orderby'] = " CAST(price_meta.meta_value AS DECIMAL(20,6)) {$direction} ";
                    }
                }
                return $clauses;
            }, 20, 2 );

            break;

        // 'date' — новые сверху — оставляем поведение Woo
        default:
            break;
    }

    return $args;
}, 10, 3 );


// На всякий случай снимем старый хук, если он подключён
remove_action( 'pre_get_posts', 'videoprojects_custom_sorting', 99 );










/**
 * Add JavaScript for sorting functionality
 */
function videoprojects_sorting_script()
{
    if (is_shop() || is_product_category() || is_product_tag()) {
?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const orderbySelect = document.querySelector('.orderby');

                if (orderbySelect) {
                    orderbySelect.addEventListener('change', function() {
                        const orderby = this.value;
                        const url = new URL(window.location.href);

                        // Reset pagination: remove query pagers and "/page/N/" from path
                        url.searchParams.delete('paged');
                        url.searchParams.delete('page');
                        url.searchParams.delete('product-page');
                        // Strip trailing /page/N from pathname if present
                        url.pathname = url.pathname.replace(/\/?page\/(\d+)\/?$/i, '/');

                        // Apply new sort
                        url.searchParams.set('orderby', orderby);

                        // Navigate to first page with new ordering
                        window.location.href = url.toString();
                    });
                }
            });
        </script>
    <?php
    }
}
add_action('wp_footer', 'videoprojects_sorting_script');

/**
 * Final-pass catalog ordering mapping (ensures price sorting works).
 * Runs late to override earlier theme/plugin filters without SQL hacks.
 */
add_filter('woocommerce_get_catalog_ordering_args', function($args, $orderby, $order){
    switch ($orderby){
        case 'date-old':
            $args['orderby'] = 'date';
            $args['order']   = 'ASC';
            unset($args['meta_key'], $args['meta_type']);
            break;
        case 'title':
            $args['orderby'] = 'title';
            $args['order']   = 'ASC';
            unset($args['meta_key'], $args['meta_type']);
            break;
        case 'price':
            $args['orderby'] = 'price';
            $args['order']   = 'ASC';
            unset($args['meta_key'], $args['meta_type']);
            break;
        case 'price-desc':
            $args['orderby'] = 'price';
            $args['order']   = 'DESC';
            unset($args['meta_key'], $args['meta_type']);
            break;
    }
    return $args;
}, 999, 3);

/**
 * Safety fallback for price ordering when lookup tables are missing/stale.
 * If Woo hasn't injected ORDER BY for price via wc_product_meta_lookup,
 * we sort by the _price meta to avoid empty results.
 */
add_filter('posts_clauses', function($clauses, $wp_query){
    if ( is_admin() || ! $wp_query->is_main_query() || !( is_shop() || is_product_taxonomy() ) ) {
        return $clauses;
    }

    $orderby = isset($_GET['orderby']) ? wc_clean( wp_unslash($_GET['orderby']) ) : '';
    if ($orderby !== 'price' && $orderby !== 'price-desc') {
        return $clauses;
    }

    // If Woo hasn't added ORDER BY by lookup table and no _price present in orderby
    $orderby_sql = isset($clauses['orderby']) ? $clauses['orderby'] : '';
    $has_lookup_order = ( strpos($orderby_sql, 'wc_product_meta_lookup') !== false ) || ( strpos($orderby_sql, 'price' ) !== false );
    $has_meta_order   = ( strpos($orderby_sql, '_price') !== false );
    if ( ! $has_lookup_order && ! $has_meta_order ) {
        global $wpdb;
        if ( strpos($clauses['join'], 'AS price_meta') === false ) {
            $clauses['join'] .= " LEFT JOIN {$wpdb->postmeta} AS price_meta ON ({$wpdb->posts}.ID = price_meta.post_id AND price_meta.meta_key = '_price')";
        }
        $dir = ($orderby === 'price') ? 'ASC' : 'DESC';
        $clauses['orderby'] = " CAST(price_meta.meta_value AS DECIMAL(20,6)) {$dir} ";
    }

    return $clauses;
}, 999, 2);

/**
 * ACF → Woo price sync
 * - Copies ACF fields 'regular_price' and 'sale_price' into Woo meta
 * - Rebuilds lookup table and clears transients
 */
function vp_sync_product_prices_from_acf( $product_id ) {
    if ( get_post_type( $product_id ) !== 'product' ) return;

    $regular = null; $sale = null;
    if ( function_exists('get_field') ) {
        // Primary expected keys
        $regular = get_field('regular_price', $product_id);
        $sale    = get_field('sale_price', $product_id);
        // Common alternates (just in case)
        if ( $regular === null || $regular === '' ) $regular = get_field('price_regular', $product_id);
        if ( $sale === null    || $sale === '' )    $sale    = get_field('price_sale', $product_id);
    }

    // If ACF not present or no values provided — nothing to sync
    if ( $regular === null && $sale === null ) return;

    if ( function_exists('wc_format_decimal') ) {
        if ( $regular !== null && $regular !== '' ) $regular = wc_format_decimal( $regular );
        if ( $sale    !== null && $sale    !== '' ) $sale    = wc_format_decimal( $sale );
    }

    if ( $regular !== null && $regular !== '' ) update_post_meta( $product_id, '_regular_price', $regular );
    if ( $sale    !== null && $sale    !== '' )    update_post_meta( $product_id, '_sale_price',    $sale );

    // Compute effective _price
    $price = get_post_meta( $product_id, '_price', true );
    if ( $sale !== null && $sale !== '' && $regular !== null && $regular !== '' && floatval($sale) > 0 && floatval($sale) < floatval($regular) ) {
        $price = $sale;
    } elseif ( $regular !== null && $regular !== '' ) {
        $price = $regular;
    }
    if ( $price !== null && $price !== '' ) update_post_meta( $product_id, '_price', $price );

    if ( function_exists('wc_delete_product_transients') ) wc_delete_product_transients( $product_id );
    if ( function_exists('wc_update_product_lookup_tables') ) wc_update_product_lookup_tables( $product_id );
}

// Sync on product save and ACF save
add_action( 'save_post_product', function( $post_id ){
    // Avoid infinite loops during programmatic updates
    if ( defined('WP_IMPORTING') && WP_IMPORTING ) return;
    vp_sync_product_prices_from_acf( $post_id );
}, 20 );

add_action( 'acf/save_post', function( $post_id ){
    // Runs after ACF updates its fields
    vp_sync_product_prices_from_acf( $post_id );
}, 20 );

// Simple bulk-sync trigger with admin URL (Tools → Products list notice)
add_action( 'admin_post_vp_bulk_sync_prices', function(){
    if ( ! current_user_can('manage_woocommerce') ) wp_die('Insufficient permissions');
    check_admin_referer( 'vp_bulk_sync_prices' );
    $ids = get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1, 'fields' => 'ids', 'post_status' => array('publish','draft','pending','private') ) );
    foreach ( $ids as $pid ) vp_sync_product_prices_from_acf( $pid );
    wp_safe_redirect( add_query_arg( array( 'vp_sync_done' => 1 ), admin_url('edit.php?post_type=product') ) );
    exit;
});

add_action( 'admin_notices', function(){
    if ( ! is_admin() || ! current_user_can('manage_woocommerce') ) return;
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if ( $screen && $screen->id === 'edit-product' ) {
        $url = wp_nonce_url( admin_url('admin-post.php?action=vp_bulk_sync_prices'), 'vp_bulk_sync_prices' );
        echo '<div class="notice notice-info"><p>Sync ACF prices → Woo meta: <a href="'.esc_url($url).'">Run now</a></p></div>';
    }
    if ( isset($_GET['vp_sync_done']) ) {
        echo '<div class="notice notice-success is-dismissible"><p>Price sync completed.</p></div>';
    }
});

/**
 * Custom result count template
 */
function videoprojects_result_count()
{
    $total    = wc_get_loop_prop('total');
    $per_page = wc_get_loop_prop('per_page');
    $current  = wc_get_loop_prop('current_page');

    if ($total <= $per_page) {
        return;
    }

    $first = ($per_page * $current) - $per_page + 1;
    $last  = min($total, $per_page * $current);

    echo '<div class="result-count">';
    printf(_n('Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'woocommerce'), $first, $last, $total);
    echo '</div>';
}

/**
 * Add view switcher functionality
 */
function videoprojects_view_switcher()
{
    $current_view = isset($_GET['view']) ? sanitize_text_field($_GET['view']) : 'grid-view';
    ?>
    <div class="view-switcher">
        <button type="button" data-view="list-view" title="List view" class="<?php echo $current_view === 'list-view' ? 'active' : ''; ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/view-list-icon.svg" alt="">
        </button>

        <button type="button" data-view="grid-view" class="<?php echo $current_view === 'grid-view' ? 'active' : ''; ?>" title="Grid view">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/view-grid-icon.svg" alt="">
        </button>
    </div>
    <?php
}

/**
 * Add JavaScript for view switcher
 */
function videoprojects_view_switcher_script()
{
    if (is_shop() || is_product_category() || is_product_tag()) {
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const viewSwitcher = document.querySelector('.view-switcher');
                if (viewSwitcher) {
                    const buttons = viewSwitcher.querySelectorAll('button');
                    const productList = document.querySelector('.product-list');

                    buttons.forEach(button => {
                        button.addEventListener('click', function() {
                            const view = this.getAttribute('data-view');

                            // Remove active class from all buttons
                            buttons.forEach(btn => btn.classList.remove('active'));
                            // Add active class to clicked button
                            this.classList.add('active');

                            // Update product list class
                            if (productList) {
                                productList.className = 'product-list ' + view;
                            }

                            // Update URL without page reload
                            const url = new URL(window.location);
                            url.searchParams.set('view', view);
                            window.history.pushState({}, '', url);
                        });
                    });

                    // Set initial view based on URL parameter
                    const urlParams = new URLSearchParams(window.location.search);
                    const viewParam = urlParams.get('view');
                    if (viewParam) {
                        const activeButton = viewSwitcher.querySelector('[data-view="' + viewParam + '"]');
                        if (activeButton) {
                            buttons.forEach(btn => btn.classList.remove('active'));
                            activeButton.classList.add('active');
                            if (productList) {
                                productList.className = 'product-list ' + viewParam;
                            }
                        }
                    }
                }
            });
        </script>
    <?php
    }
}
add_action('wp_footer', 'videoprojects_view_switcher_script');

/**
 * Add mobile category toggle functionality
 */
function videoprojects_category_toggle_script()
{
    if (is_shop() || is_product_category() || is_product_tag()) {
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const categoryToggle = document.querySelector('.product-categories-toggle');
                const categoryList = document.querySelector('.product-categories');

                if (categoryToggle && categoryList) {
                    categoryToggle.addEventListener('click', function() {
                        categoryList.classList.toggle('show');
                        this.classList.toggle('active');
                    });
                }

                // Handle dropdown categories
                const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
                dropdownToggles.forEach(toggle => {
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        const parent = this.closest('.dropdown');
                        const subCategories = parent.querySelector('.sub-categories');

                        if (subCategories) {
                            subCategories.classList.toggle('show');
                            this.classList.toggle('active');
                        }
                    });
                });
            });
        </script>
<?php
    }
}
add_action('wp_footer', 'videoprojects_category_toggle_script');

/**
 * Register Services Custom Post Type
 */
function videoprojects_register_services_post_type()
{
    $labels = array(
        'name'               => __('Services', 'videoprojects'),
        'singular_name'      => __('Service', 'videoprojects'),
        'menu_name'          => __('Services', 'videoprojects'),
        'add_new'            => __('Add New Service', 'videoprojects'),
        'add_new_item'       => __('Add New Service', 'videoprojects'),
        'edit_item'          => __('Edit Service', 'videoprojects'),
        'new_item'           => __('New Service', 'videoprojects'),
        'view_item'          => __('View Service', 'videoprojects'),
        'search_items'       => __('Search Services', 'videoprojects'),
        'not_found'          => __('No services found', 'videoprojects'),
        'not_found_in_trash' => __('No services found in trash', 'videoprojects'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'services'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-tools',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'        => true,
    );

    register_post_type('services', $args);
}
add_action('init', 'videoprojects_register_services_post_type');

/**
 * Register Pieredze Post Type
 */
function videoprojects_register_pieredze_post_type()
{
    $labels = array(
        'name'               => __('Pieredze', 'videoprojects'),
        'singular_name'      => __('Pieredze', 'videoprojects'),
        'menu_name'          => __('Pieredze', 'videoprojects'),
        'add_new'            => __('Add New Pieredze', 'videoprojects'),
        'add_new_item'       => __('Add New Pieredze', 'videoprojects'),
        'edit_item'          => __('Edit Pieredze', 'videoprojects'),
        'new_item'           => __('New Pieredze', 'videoprojects'),
        'view_item'          => __('View Pieredze', 'videoprojects'),
        'search_items'       => __('Search Pieredze', 'videoprojects'),
        'not_found'          => __('No pieredze found', 'videoprojects'),
        'not_found_in_trash' => __('No pieredze found in trash', 'videoprojects'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'pieredze'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'        => true,
    );

    register_post_type('pieredze', $args);
}
add_action('init', 'videoprojects_register_pieredze_post_type');

/**
 * ACF Fields for Products
 */
function videoprojects_acf_product_fields()
{
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_product_fields',
            'title' => 'Product Fields',
            'fields' => array(
                array(
                    'key' => 'field_product_detailed_description',
                    'label' => 'Detailed Description',
                    'name' => 'product_detailed_description',
                    'type' => 'wysiwyg',
                    'instructions' => 'Detailed description that appears when clicking "Pilns preces apraksts" button',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_product_variations',
                    'label' => 'Product Variations',
                    'name' => 'product_variations',
                    'type' => 'repeater',
                    'instructions' => 'Add dropdown variations for the product',
                    'required' => 0,
                    'layout' => 'table',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_variation_name',
                            'label' => 'Variation Name',
                            'name' => 'variation_name',
                            'type' => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key' => 'field_variation_options',
                            'label' => 'Variation Options',
                            'name' => 'variation_options',
                            'type' => 'textarea',
                            'instructions' => 'Enter options separated by commas',
                            'required' => 1,
                            'rows' => 3,
                        ),
                    ),
                ),
                array(
                    'key' => 'field_attached_documents',
                    'label' => 'Attached Documents',
                    'name' => 'attached_documents',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_document_title',
                            'label' => 'Document Title',
                            'name' => 'document_title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_document_file',
                            'label' => 'Document File',
                            'name' => 'document_file',
                            'type' => 'file',
                            'return_format' => 'array',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_other_section',
                    'label' => 'Other Section',
                    'name' => 'other_section',
                    'type' => 'wysiwyg',
                    'instructions' => 'Content for "Cita sekcija" tab',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'product',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ));
    }
}
add_action('acf/init', 'videoprojects_acf_product_fields');

/**
 * ACF Fields for Pieredze
 */
function videoprojects_acf_pieredze_fields()
{
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_pieredze_post_fields',
            'title' => 'Pieredzes lauki',
            'fields' => array(
                array(
                    'key' => 'field_pieredze_short_description',
                    'label' => 'Īss apraksts',
                    'name' => 'pieredze_short_description',
                    'type' => 'textarea',
                    'instructions' => 'Īss apraksts pieredzes kartītē',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_pieredze_external_link',
                    'label' => 'Ārējā saite',
                    'name' => 'pieredze_external_link',
                    'type' => 'url',
                    'instructions' => 'Ārējā saite (ja nav norādīta, tad tiek izmantota iekšējā saite uz pieredzes lapu)',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_pieredze_description',
                    'label' => 'Pieredzes apraksts',
                    'name' => 'pieredze_description',
                    'type' => 'textarea',
                    'instructions' => 'Galvenais apraksts pieredzes lapā',
                    'required' => 0,
                    'new_lines' => 'br',
                    'rows' => 4,
                ),
                array(
                    'key' => 'field_pieredze_video_file',
                    'label' => 'Video fails',
                    'name' => 'pieredze_video_file',
                    'type' => 'file',
                    'instructions' => 'Augšupielādējiet video failu pieredzes lapā',
                    'required' => 0,
                    'return_format' => 'array',
                    'library' => 'all',
                    'mime_types' => 'mp4,mov,avi,webm',
                ),
                array(
                    'key' => 'field_pieredze_video_image',
                    'label' => 'Video fona attēls',
                    'name' => 'pieredze_video_image',
                    'type' => 'image',
                    'instructions' => 'Attēls video fona vietā',
                    'required' => 0,
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ),
                array(
                    'key' => 'field_pieredze_video_author',
                    'label' => 'Video autors',
                    'name' => 'pieredze_video_author',
                    'type' => 'text',
                    'instructions' => 'Video autora vārds',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_pieredze_video_description',
                    'label' => 'Video apraksts',
                    'name' => 'pieredze_video_description',
                    'type' => 'text',
                    'instructions' => 'Īss video apraksts',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_pieredze_projects_title',
                    'label' => 'Projektu virsraksts',
                    'name' => 'pieredze_projects_title',
                    'type' => 'text',
                    'instructions' => 'Virsraksts projektu sarakstam',
                    'required' => 0,
                ),
                array(
                    'key' => 'field_pieredze_projects',
                    'label' => 'Projektu saraksts',
                    'name' => 'pieredze_projects',
                    'type' => 'repeater',
                    'instructions' => 'Pieredzes projektu saraksts',
                    'required' => 0,
                    'layout' => 'table',
                    'button_label' => 'Pievienot projektu',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_pieredze_project_title',
                            'label' => 'Projekta nosaukums',
                            'name' => 'title',
                            'type' => 'text',
                            'required' => 0,
                        ),
                        array(
                            'key' => 'field_pieredze_project_description',
                            'label' => 'Projekta apraksts',
                            'name' => 'description',
                            'type' => 'textarea',
                            'required' => 0,
                            'rows' => 3,
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'pieredze',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ));
    }
}
add_action('acf/init', 'videoprojects_acf_pieredze_fields');

/**
 * ACF Fields for Pieredze Page
 */
function videoprojects_acf_pieredze_page_fields()
{
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_pieredze_page_fields',
            'title' => 'Pieredzes lapas lauki',
            'fields' => array(
                array(
                    'key' => 'field_pieredze_page_header',
                    'label' => 'Lapas galvene',
                    'name' => 'page_header',
                    'type' => 'group',
                    'instructions' => 'Galvenes sekcijas iestatījumi',
                    'required' => 0,
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_pieredze_page_title',
                            'label' => 'Lapas virsraksts',
                            'name' => 'title',
                            'type' => 'text',
                            'instructions' => 'Galvenais virsraksts lapas galvenē',
                            'required' => 1,
                            'default_value' => 'Mūsu pieredze',
                        ),
                        array(
                            'key' => 'field_pieredze_page_subtitle',
                            'label' => 'Apakšvirsraksts',
                            'name' => 'subtitle',
                            'type' => 'textarea',
                            'instructions' => 'Apakšvirsraksta teksts zem galvenā virsraksta',
                            'required' => 1,
                            'default_value' => 'Mūsu uzņēmums ir veicis daudzus projektus dažādās nozarēs, sniedzot drošības sistēmu un kameru risinājumus, kas palīdzējuši mūsu klientiem pasargāt savu īpašumu un datus.',
                        ),
                        array(
                            'key' => 'field_pieredze_page_background',
                            'label' => 'Fona attēls',
                            'name' => 'background_image',
                            'type' => 'image',
                            'instructions' => 'Fona attēls lapas galvenei',
                            'required' => 0,
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                            'library' => 'all',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'pieredze-page.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ));
    }
}
add_action('acf/init', 'videoprojects_acf_pieredze_page_fields');

/**
 * WooCommerce template customizations
 */








/**
 * Translate breadcrumbs to Latvian
 */
function videoprojects_translate_breadcrumbs($breadcrumb)
{
    foreach ($breadcrumb as $key => $crumb) {
        // Translate "Home" to "Sākumlapa"
        if ($crumb[0] === 'Home') {
            $breadcrumb[$key][0] = 'Sākumlapa';
        }
        // Translate "Shop" to "Veikals" if needed
        elseif ($crumb[0] === 'Shop') {
            $breadcrumb[$key][0] = 'Veikals';
        }
    }

    return $breadcrumb;
}
add_filter('woocommerce_get_breadcrumb', 'videoprojects_translate_breadcrumbs');

/**
 * Populate Gravity Forms select field with services
 */
function videoprojects_populate_services_select($choices, $field, $value)
{
    // Check if this is the services select field (you may need to adjust the field ID)
    if ($field->inputName === 'services-select' || $field->label === 'Pakalpojumi' || $field->id == 2) {

        // Get all published services
        $services = get_posts(array(
            'post_type' => 'services',
            'post_status' => 'publish',
            'numberposts' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        ));

        // Reset choices array
        $choices = array();

        // Add default option
        $choices[] = array(
            'text' => 'Izvēlieties pakalpojumu',
            'value' => ''
        );

        // Add services to choices
        foreach ($services as $service) {
            $choices[] = array(
                'text' => $service->post_title,
                'value' => $service->post_title
            );
        }
    }

    return $choices;
}
add_filter('gform_field_choices', 'videoprojects_populate_services_select', 10, 3);

/**
 * Populate Gravity Forms select field with pieredze
 */
function videoprojects_populate_pieredze_select($choices, $field, $value)
{
    // Check if this is the pieredze select field
    if ($field->inputName === 'pieredze-select' || $field->label === 'Pieredze' || $field->id == 3) {

        // Get all published pieredze
        $pieredze = get_posts(array(
            'post_type' => 'pieredze',
            'post_status' => 'publish',
            'numberposts' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        ));

        // Reset choices array
        $choices = array();

        // Add default option
        $choices[] = array(
            'text' => 'Izvēlieties pieredzi',
            'value' => ''
        );

        // Add pieredze to choices
        foreach ($pieredze as $pieredze_item) {
            $choices[] = array(
                'text' => $pieredze_item->post_title,
                'value' => $pieredze_item->post_title
            );
        }
    }

    return $choices;
}
add_filter('gform_field_choices', 'videoprojects_populate_pieredze_select', 10, 3);

/**
 * Alternative method using gform_pre_render for more control
 */
function videoprojects_populate_services_dynamic($form)
{
    // Check if this is form ID 2
    if ($form['id'] == 2) {

        // Get all published services
        $services = get_posts(array(
            'post_type' => 'services',
            'post_status' => 'publish',
            'numberposts' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        ));

        // Find the services select field and populate it
        foreach ($form['fields'] as &$field) {
            // Check if this is a select field that should contain services
            if ($field->type == 'select' && (
                $field->inputName === 'services-select' ||
                $field->label === 'Pakalpojumi' ||
                strpos($field->label, 'pakalpojumu') !== false ||
                strpos($field->label, 'Pakalpojumi') !== false
            )) {

                $choices = array();

                // Add default option
                $choices[] = array(
                    'text' => 'Izvēlieties pakalpojumu',
                    'value' => ''
                );

                // Add services to choices
                foreach ($services as $service) {
                    $choices[] = array(
                        'text' => $service->post_title,
                        'value' => $service->post_title
                    );
                }

                $field->choices = $choices;
            }
        }
    }

    return $form;
}
add_filter('gform_pre_render', 'videoprojects_populate_services_dynamic');

/**
 * Alternative method using gform_pre_render for pieredze
 */
function videoprojects_populate_pieredze_dynamic($form)
{
    // Check if this is form ID 3 (or adjust as needed)
    if ($form['id'] == 3) {

        // Get all published pieredze
        $pieredze = get_posts(array(
            'post_type' => 'pieredze',
            'post_status' => 'publish',
            'numberposts' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        ));

        // Find the pieredze select field and populate it
        foreach ($form['fields'] as &$field) {
            // Check if this is a select field that should contain pieredze
            if ($field->type == 'select' && (
                $field->inputName === 'pieredze-select' ||
                $field->label === 'Pieredze' ||
                strpos($field->label, 'pieredzi') !== false ||
                strpos($field->label, 'Pieredze') !== false
            )) {

                $choices = array();

                // Add default option
                $choices[] = array(
                    'text' => 'Izvēlieties pieredzi',
                    'value' => ''
                );

                // Add pieredze to choices
                foreach ($pieredze as $pieredze_item) {
                    $choices[] = array(
                        'text' => $pieredze_item->post_title,
                        'value' => $pieredze_item->post_title
                    );
                }

                $field->choices = $choices;
            }
        }
    }

    return $form;
}
add_filter('gform_pre_render', 'videoprojects_populate_pieredze_dynamic');

/**
 * Add stock status display after product title
 */
function videoprojects_display_stock_status()
{
    wc_get_template('single-product/stock.php');
}
add_action('woocommerce_single_product_summary', 'videoprojects_display_stock_status', 7);

/**
 * Add custom product tabs
 */
function videoprojects_custom_product_tabs($tabs)
{
    global $product;

    // Add Documents tab
    $attached_documents = get_field('attached_documents', $product->get_id());
    if ($attached_documents && is_array($attached_documents)) {
        $tabs['documents'] = array(
            'title'    => __('Pievienotie dokumenti', 'videoprojects'),
            'priority' => 20,
            'callback' => 'videoprojects_documents_tab_content'
        );
    }

    // Add Other Section tab
    $other_section_content = get_field('other_section', $product->get_id());
    if ($other_section_content) {
        $tabs['other_section'] = array(
            'title'    => __('Cita sekcija', 'videoprojects'),
            'priority' => 30,
            'callback' => 'videoprojects_other_section_tab_content'
        );
    }

    return $tabs;
}
add_filter('woocommerce_product_tabs', 'videoprojects_custom_product_tabs');

/**
 * Documents tab content callback
 */
function videoprojects_documents_tab_content($key, $tab)
{
    wc_get_template('single-product/tabs/documents.php');
}

/**
 * Other Section tab content callback
 */
function videoprojects_other_section_tab_content($key, $tab)
{
    wc_get_template('single-product/tabs/other-section.php');
}








/* 1) Сообщаем Woo, как трактовать наши ключи из выпадашки */
if (false) add_filter( 'woocommerce_get_catalog_ordering_args', function( $args, $orderby, $order ) {
	switch ( $orderby ) {
		case 'date-old':          // старые сверху
			$args['orderby'] = 'date';
			$args['order']   = 'ASC';
			unset( $args['meta_key'], $args['meta_type'] );
			break;

		case 'title':             // по алфавиту A→Z
			$args['orderby'] = 'title';
			$args['order']   = 'ASC';
			unset( $args['meta_key'], $args['meta_type'] );
			break;

		case 'price':             // цена ↑ (через lookup Woo)
			$args['orderby'] = 'price';
			$args['order']   = 'ASC';
			unset( $args['meta_key'], $args['meta_type'] );
			break;

		case 'price-desc':        // цена ↓ (через lookup Woo)
			$args['orderby'] = 'price';
			$args['order']   = 'DESC';
			unset( $args['meta_key'], $args['meta_type'] );
			break;
	}
	return $args;
}, 10, 3 );

/* 2) Если тема/плагины мешают: дублируем логику на уровне Woo query */
if (false) add_action( 'woocommerce_product_query', function( $q ) {
	$orderby = isset($_GET['orderby']) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : '';
	switch ( $orderby ) {
		case 'date-old':
			$q->set( 'orderby', 'date' );
			$q->set( 'order', 'ASC' );
			break;

		case 'title':
			$q->set( 'orderby', 'title' );
			$q->set( 'order', 'ASC' );
			break;

		case 'price':
			$q->set( 'orderby', 'price' ); // пусть Woo сам отсортирует по lookup
			$q->set( 'order', 'ASC' );
			break;

		case 'price-desc':
			$q->set( 'orderby', 'price' );
			$q->set( 'order', 'DESC' );
			break;
	}
}, 20 );

// 1) Маппинг наших значений выпадашки
add_filter('woocommerce_get_catalog_ordering_args', function($args, $orderby, $order){
  switch ($orderby){
    case 'date-old':   $args['orderby']='date';  $args['order']='ASC';  unset($args['meta_key'],$args['meta_type']); break;
    case 'title':      $args['orderby']='title'; $args['order']='ASC';  unset($args['meta_key'],$args['meta_type']); break;
    case 'price':      $args['orderby']='price'; $args['order']='ASC';  unset($args['meta_key'],$args['meta_type']); break;
    case 'price-desc': $args['orderby']='price'; $args['order']='DESC'; unset($args['meta_key'],$args['meta_type']); break;
  }
  return $args;
}, 10, 3);

// 2) Фолбэк: если вдруг Woo не применил сортировку по цене — принудительно по _price
if (false) add_filter('posts_clauses', function($clauses, $wp_query){
  if ( is_admin() || ! $wp_query->is_main_query() || !( is_shop() || is_product_taxonomy() ) ) return $clauses;

  $orderby = isset($_GET['orderby']) ? wc_clean( wp_unslash($_GET['orderby']) ) : '';
  if ($orderby !== 'price' && $orderby !== 'price-desc') return $clauses;

  global $wpdb;
  $dir = ($orderby === 'price') ? 'ASC' : 'DESC';

  // если уже есть ORDER BY price/_price — выходим
  if (!empty($clauses['orderby']) && (strpos($clauses['orderby'],'price')!==false || strpos($clauses['orderby'],'_price')!==false)) {
    return $clauses;
  }

  // джоиним мету _price и жёстко задаём сортировку
  if (strpos($clauses['join'], 'AS price_meta') === false) {
    $clauses['join'] .= " LEFT JOIN {$wpdb->postmeta} AS price_meta
      ON ({$wpdb->posts}.ID = price_meta.post_id AND price_meta.meta_key = '_price')";
  }
  $clauses['orderby'] = " CAST(price_meta.meta_value AS DECIMAL(20,6)) {$dir} ";
  return $clauses;
}, 30, 2);

// 3) На всякий: уберём старые вмешательства, если где-то остались
remove_action('pre_get_posts', 'videoprojects_custom_sorting', 99);


// functions.php (дочерней темы)
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('checkout', get_stylesheet_directory_uri() . '/style.css', [], '1.0');
});

add_action('wp_enqueue_scripts', function () {
  if ( function_exists('is_checkout') && is_checkout() ) {
    wp_enqueue_style('vp-checkout', get_stylesheet_directory_uri() . '/css/vp-checkout.css', [], '1.0');
  }
});

/**
 * Gravity Forms: add Bootstrap classes to the submit button for form ID 4 (sidebar form)
 */
function vp_gf_add_submit_classes_btn_secondary($button, $form)
{
    if (strpos($button, 'btn btn-secondary') !== false) {
        return $button;
    }
    // Try to append to existing class attribute (double quotes)
    $count = 0;
    $updated = preg_replace('/class\s*=\s*"([^"]*)"/i', 'class="$1 btn btn-secondary"', $button, 1, $count);
    if ($count > 0) {
        return $updated;
    }
    // Try single quotes
    $updated = preg_replace("/class\s*=\s*'([^']*)'/i", "class='$1 btn btn-secondary'", $button, 1, $count);
    if ($count > 0) {
        return $updated;
    }
    // As a fallback, inject class attribute for input or button
    if (stripos($button, '<input') !== false) {
        return str_replace('<input', '<input class="btn btn-secondary"', $button);
    }
    if (stripos($button, '<button') !== false) {
        return str_replace('<button', '<button class="btn btn-secondary"', $button);
    }
    return $button;
}
add_filter('gform_submit_button_4', 'vp_gf_add_submit_classes_btn_secondary', 10, 2);
add_filter('gform_submit_button_2', 'vp_gf_add_submit_classes_btn_secondary', 10, 2);
