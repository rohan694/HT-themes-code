<?php

if (!urna_is_Woocommerce_activated()) {
    return;
}
        

if (! function_exists('urna_woocommerce_setup_size_image')) {
    add_action('after_setup_theme', 'urna_woocommerce_setup_size_image');
    function urna_woocommerce_setup_size_image()
    {
        $thumbnail_width = 480;
        $main_image_width = 600;
        $cropping_custom_width = 96;
        $cropping_custom_height = 123;

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
