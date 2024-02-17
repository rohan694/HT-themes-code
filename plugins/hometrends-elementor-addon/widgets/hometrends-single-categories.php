<?php

/**
 * Elementor Currency Widget.
 *
 * Elementor widget that uses the currency control.
 *
 * @since 1.0.0
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Elementor_Hometrends_Single_Categories extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'hometrends_single_cats';
    }

    public function get_title()
    {
        return esc_html__('Hometrends Single Categories', 'hometrends-elementor-addon');
    }

    public function get_icon()
    {
        return 'eicon-button';
    }

    public function get_categories()
    {
        return ['hometrends_elementor'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'hometrends-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {

        $singlecat_list = '';
        if (is_single()) {

            $post_id = get_the_ID();

            $categories = get_the_category($post_id);

            if ($categories) {
                $singlecat_list .= '<ul>';
                foreach ($categories as $category) {

                    $_cattimage = get_option('z_taxonomy_image' . $category->term_id);
                    $_cattimage = isset($_cattimage) ? $_cattimage : '';

                    $_cattimage_html = '';

                    if ($_cattimage != '') {
                        $_cattimage_html = '<img src="' . $_cattimage . '" alt="category image" height="30" width="30"/>';
                    }

                    $singlecat_list .= '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . $_cattimage_html . '' . esc_html($category->name) . '</a></li>';
                }
                $singlecat_list .= '</ul>';
            }
        }
        if (!empty($singlecat_list)) {
            ?>
            <div class="hometrends-single-categories">
                <?php echo $singlecat_list; ?>
            </div>
            <?php
        }
    }
}
