<?php
/**
 * @author Rehan Lodhi <rehanlodhi@live.com>
 */

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style( 'woo-flexslider', get_stylesheet_directory_uri() . '/assets/css/flexslider/flexslider.css', array(), CHILD_THEME_ASTRA_HOMETRENDS_VERSION, 'all' );
    wp_enqueue_style( 'woo-slick', get_stylesheet_directory_uri() . '/assets/slick/slick.css', array(), CHILD_THEME_ASTRA_HOMETRENDS_VERSION, 'all' );
    wp_enqueue_style( 'woo-slick-theme', get_stylesheet_directory_uri() . '/assets/slick/slick-theme.css', array(), CHILD_THEME_ASTRA_HOMETRENDS_VERSION, 'all' );
    wp_enqueue_style( 'woo-accordion-style', get_stylesheet_directory_uri() . '/assets/css/accordion/accordion.min.css', array(), CHILD_THEME_ASTRA_HOMETRENDS_VERSION, 'all' );

    wp_enqueue_script( 'woo-accordion-js', get_stylesheet_directory_uri() . '/assets/js/accordion/accordion.min.js', array(), CHILD_THEME_ASTRA_HOMETRENDS_VERSION, false );
    wp_enqueue_script( 'woo-slick-js', get_stylesheet_directory_uri() . '/assets/slick/slick.min.js', array(), CHILD_THEME_ASTRA_HOMETRENDS_VERSION, true );
    wp_enqueue_script( 'woo-child-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), CHILD_THEME_ASTRA_HOMETRENDS_VERSION, true );
});

add_filter( 'woocommerce_single_product_carousel_options', 'filter_single_product_carousel_options' );
function filter_single_product_carousel_options( $options ) {
        $options['controlNav'] = true;
        $options['slideshow'] = true;
        $options['directionNav'] = true;
        $options['touch'] = true;

        return $options;
}

add_filter( 'wc_product_sku_enabled', '__return_false' );

add_action('woocommerce_after_add_to_cart_button', function () {
    echo do_shortcode('[yith_wcwl_add_to_wishlist]');
});




add_filter('woocommerce_product_tabs', function ($tabs) {
    global $product;

    $tabs[ 'description' ][ 'title' ] = 'Beschreibung';
    $tabs[ 'additional_information' ][ 'title' ] = 'Zusätzliche Informationen';
    $tabs[ 'reviews' ][ 'title' ] = 'Bewertungen (' . $product->get_review_count() . ')';

    return $tabs;
});

add_filter( 'woocommerce_output_related_products_args', function ($args) {
    $args['posts_per_page'] = 8;

    return $args;
}, 20);

add_filter('yith_wcwl_create_wishlist_title_label', function () {
    echo '';
}, 20);

remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product_summary','woocommerce_output_related_products', 8);




