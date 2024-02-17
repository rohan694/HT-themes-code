<?php

/**
 * Plugin Name: Hometrends Elementor Addon
 * Description: This is a custom plugin to build Hometrends custom elementor widgets.
 * Plugin URI:  https://hometrends.one
 * Version:     1.0
 * Author:      Asif Rasheed
 * Author URI:  https://profiles.wordpress.org/asifrasheed
 * Text Domain: hometrends-elementor-addon
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('HOMETRENDS_ADDON_PLUGIN_URL', plugin_dir_url(__FILE__));
define('HOMETRENDS_ADDON_VERSION', 1.0);



require_once(__DIR__ . '/includes/hometrends-functions.php');

/**
 * Register Custom Widget.
 *
 * Include widget file and register widget class.
 */
function register_hometrends_elements($widgets_manager)
{

    /*
     * Product Tabs
     */

    require_once(__DIR__ . '/widgets/hometrends-product-tabs.php');
    $widgets_manager->register(new Elementor_Hometrends_Product_Tabs());

    /**
     * Single Categories
     */
    require_once(__DIR__ . '/widgets/hometrends-single-categories.php');
    $widgets_manager->register(new Elementor_Hometrends_Single_Categories());

    /**
     * Archive Categories
     */
    require_once(__DIR__ . '/widgets/hometrends-archive-tabs.php');
    $widgets_manager->register(new Elementor_Hometrends_Archive_Tabs());
}

add_action('elementor/widgets/register', 'register_hometrends_elements');

/*
 * Register Elementor widget type
 */

function hometrends_register_widgets_sections($category_manager)
{
    $category_manager->add_category(
        'hometrends_elementor',
        [
            'title' => __('Hometrends Widgets', 'hometrends-supporter'),
            'icon' => 'fa fa-home',
        ]
    );
}

add_action('elementor/elements/categories_registered', 'hometrends_register_widgets_sections');

/**
 * Enqueue styles
 */
function hometrends_addon_enqueue_styles()
{

    wp_register_style('hometrends-elementor', HOMETRENDS_ADDON_PLUGIN_URL . '/assets/css/hometrends-elementor.css');
    wp_register_script('hometrends-elementor', HOMETRENDS_ADDON_PLUGIN_URL . '/assets/js/hometrends-elementor.js', array('jquery'), rand(1,9999), true);

    wp_localize_script('hometrends-elementor', 'hometrends_globals', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}

add_action('wp_enqueue_scripts', 'hometrends_addon_enqueue_styles');
