<?php

if (!urna_is_Woocommerce_activated()) {
    return;
}

if (! function_exists('urna_woocommerce_setup_size_image')) {
    add_action('after_setup_theme', 'urna_woocommerce_setup_size_image');
    function urna_woocommerce_setup_size_image()
    {
        $thumbnail_width = 414;
        $main_image_width = 600;
        $cropping_custom_width = 1;
        $cropping_custom_height = 1;

        // Image sizes
        update_option('woocommerce_thumbnail_image_width', $thumbnail_width);
        update_option('woocommerce_single_image_width', $main_image_width);

        update_option('woocommerce_thumbnail_cropping', 'custom');
        update_option('woocommerce_thumbnail_cropping_custom_width', $cropping_custom_width);
        update_option('woocommerce_thumbnail_cropping_custom_height', $cropping_custom_height);
    }
}

if (urna_tbay_get_global_config('config_media', false)) {
    remove_action('after_setup_theme', 'urna_woocommerce_setup_size_image');
}

if (! function_exists('urna_change_label_sale')) {
    function urna_change_label_sale()
    {
        $layout = apply_filters('urna_woo_config_product_layout', 10, 2);
        if ($layout !== 'v5') {
            return;
        }
        add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
    }
    add_action('urna_woocommerce_before_product_block_grid', 'urna_change_label_sale', 15);
}