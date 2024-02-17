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

class Elementor_Hometrends_Product_Tabs extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'hometrends_prod_tabs';
    }

    public function get_title()
    {
        return esc_html__('Hometrends Product Tabs', 'hometrends-elementor-addon');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }

    public function get_categories()
    {
        return ['hometrends_elementor'];
    }

    public function get_script_depends()
    {
        return ['hometrends-elementor'];
    }

    public function get_style_depends()
    {
        return ['hometrends-elementor'];
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

        $this->add_control(
            'prod_cats',
            array(
                'label' => __('Select Categories', 'hometrends-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => apply_filters('hometrends_get_product_categories', array()),
            )
        );

        $this->add_control(
            'prod_order',
            array(
                'label' => __('Order By', 'hometrends-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'ASC' => __('Oldest', 'hometrends-elementor-addon'),
                    'DESC' => __('Latest', 'hometrends-elementor-addon'),
                ),
                'default' => 'DESC',
            )
        );

        $this->add_control(
            'no_of_prod',
            array(
                'label' => __('Number fo Products', 'hometrends-elementor-addon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 10,
                'min' => 1,
                'max' => 50,
            )
        );

        $this->end_controls_section();
    }

    protected function render()
    {

        $hometrends_settings = $this->get_settings_for_display();

        $product_cat = isset($hometrends_settings['prod_cats']) && $hometrends_settings['prod_cats'] != '' ? $hometrends_settings['prod_cats'] : array();


        $active_parent_id = 0;

        $parent_list = '';

        if (!empty($product_cat)) {


            $parent_list .= '<ul class="homeone-cats-selectbox">';

            $actclass = ' class="active"';

            foreach ($product_cat as $term_slug) {

                $term_parent = get_term_by('id', $term_slug, 'category');

                $_cattimage = get_option('z_taxonomy_image' . $term_slug);
                $_cattimage = isset($_cattimage) ? $_cattimage : '';

                $_cattimage_html = '';

                if ($_cattimage != '') {
                    $_cattimage_html = '<img src="' . $_cattimage . '" alt="category image" height="30" width="30"/>';
                }

                if ($term_parent) {
                    $parent_list .= '<li' . $actclass . '><a href="javascript:void(0)" data-target="' . $term_slug . '" data-type="parent">' . $_cattimage_html . ' ' . $term_parent->name . ' </a></li>';
                    $actclass = '';
                }
            }

            $parent_list .= '</ul>';

            $active_parent_id =  $product_cat[0];
        }


        $prod_html_content = hometrends_load_cat_products($hometrends_settings, $active_parent_id);

?>



        <div class="hometrends-tabs-wrap" data-hometrend-settings='<?php echo json_encode($hometrends_settings) ?>'>

            <div class="hometrends-parent-tabs hometrends-general-tab">
                <?php echo $parent_list; ?>
            </div>

            <div class="hometrends-child-tabs hometrends-general-tab">
                <?php echo $prod_html_content['child_list']; ?>
            </div>

            <div class="hometrends-tabs-content">
                <?php echo $prod_html_content['content']; ?>
            </div>

        </div>


<?php
        wp_reset_postdata();
    }
}
