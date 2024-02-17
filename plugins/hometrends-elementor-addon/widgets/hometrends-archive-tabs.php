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

global $mobile_popup_list;
class Elementor_Hometrends_Archive_Tabs extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'hometrends_archive_tabs';
    }

    public function get_title()
    {
        return esc_html__('Hometrends Archive Tabs', 'hometrends-elementor-addon');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }

    public function get_script_depends()
    {
        return ['hometrends-elementor'];
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
            'no_of_posts',
            array(
                'label' => __('Number fo Posts', 'hometrends-elementor-addon'),
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

        global $mobile_popup_list;

        $hometrends_settings = $this->get_settings_for_display();

        $prod_order = isset($hometrends_settings['prod_order']) && $hometrends_settings['prod_order'] != '' ? $hometrends_settings['prod_order'] : 'DESC';
        $no_of_posts = isset($hometrends_settings['no_of_posts']) && $hometrends_settings['no_of_posts'] != '' ? $hometrends_settings['no_of_posts'] : 10;


        $get_all_cats = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => false,
            'parent' => 0,
            'exclude' => 1,
        ));

        $current_id = get_queried_object_id();
        //$current_id = 47;

        $child_category = get_term($current_id, 'category');

        if ($child_category && !is_wp_error($child_category) && $child_category->parent != 0) {
            $parent_category_id = $child_category->parent;
        } else {
            $parent_category_id = $current_id;
        }

        $parent_list = '';
        $parent_mobile_list = '';
        $mobile_popup_list = '';


        if (!empty($get_all_cats)) {

            $mobile_popup_list .= '<ul class="homeone-cats-popup-selectbox">';

            $parent_list .= '<ul class="homeone-cats-selectbox">';

            foreach ($get_all_cats as $cat_id) {

                $term_parent = get_term_by('id', $cat_id->term_id, 'category');

                $actclass = '';
                $actradio = '';

                if ($parent_category_id == $cat_id->term_id) {
                    $actclass = ' class="active"';
                    $actradio = ' checked="checked"';
                }

                $_cattimage = get_option('z_taxonomy_image' . $cat_id->term_id);
                $_cattimage = isset($_cattimage) ? $_cattimage : '';

                $_cattimage_html = '';
                if ($_cattimage != '') {
                    $_cattimage_html = '<img src="' . $_cattimage . '" alt="category image" height="30" width="30"/>';
                }

                if ($term_parent) {

                    if (!empty($actradio)) {
                        $parent_mobile_list .= '<div class="homeone-mbl-dropdown"><button>' . $_cattimage_html . ' ' . $term_parent->name . ' <svg fill="#fff" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/<svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 330 330" xml:space="preserve">
                   <path id="XMLID_225_" d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393
                       c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393
                       s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"/>
                   </svg> </button></div>';
                    }

                    $parent_list .= '<li' . $actclass . '><a href="' . get_term_link($cat_id->term_id) . '">' . $_cattimage_html . ' ' . $term_parent->name . ' </a></li>';

                    $mobile_popup_list .= '<li' . $actclass . '><a href="' . get_term_link($cat_id->term_id) . '"><input type="radio"' . $actradio . ' />' . $_cattimage_html . ' ' . $term_parent->name . '</a></li>';
                }
            }

            $parent_list .= '</ul>';
            $mobile_popup_list .= '</ul>';
        }


        $child_list_data = get_term_children($parent_category_id, 'category');

        $child_list_data = !empty($child_list_data) ? array_map('intval', $child_list_data) : array();

        $child_list = '';

        if (!empty($child_list_data)) {

            $child_list .= '<ul>';

            foreach ($child_list_data as $term_key) {

                $child_term = get_term_by('id', $term_key, 'category');

                $childactclass = '';
                if ($current_id == $child_term->term_id) {
                    $childactclass = ' class="active"';
                }

                if ($child_term) {
                    $child_list .= '<li' . $childactclass . '><a href="javascript:void(0)" data-target="' . $child_term->term_id . '" data-type="child" > ' . $child_term->name . ' </a></li>';
                }
            }

            $child_list .= '</ul>';
        }
?>



        <div class="hometrends-tabs-wrap" data-parent-id="<?php echo $current_id;?>">
            <?php echo $parent_mobile_list; ?>
            <div class="hometrends-parent-tabs">
                <?php echo $parent_list; ?>
            </div>

            <div class="hometrends-child-tabs">
                <?php echo $child_list; ?>
            </div>

            <div class="hometrends-tabs-content">
                <?php

                $product_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $no_of_posts,
                    'post_status' => 'publish',
                    'order' => $prod_order,
                    'orderby' => 'date',
                    'category__in' => array($current_id),
                );


                $product_array = new WP_Query($product_args);

                if ($product_array->have_posts()) {
                    while ($product_array->have_posts()) : $product_array->the_post();
                        global $post;

                        $product_id = $post->ID;
                        $thumbnail_url = get_the_post_thumbnail_url($product_id, 'full');

                        $content = $post->post_content;
                        $content = apply_filters('the_content', $content);
                        $content = str_replace(']]>', ']]&gt;', $content);

                        $author_id = get_post_field('post_author', $product_id);

                        // Get the author display name
                        $author_name = get_the_author_meta('display_name', $author_id);
                        $product_categories = wp_get_post_terms($product_id, 'category');

                        $social_media_text = '';
                        $social_media_links = '';
                        if (function_exists('get_field')) {
                            $social_media_text = get_field('social_media_text', $product_id);
                            $social_media_links = get_field('social_media_links', $product_id);
                        }

                ?>
                        <div class="hometrends-prod-item">
                            <figure>
                                <i class="fa-solid fa-ellipsis"></i>
                                <a href="<?php echo get_the_permalink($product_id); ?>">
                                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="Product Image">
                                </a>
                                <figcaption>
                                    <div class="hometrnda-caption-top">
                                        <?php
                                        if (!is_wp_error($product_categories) && !empty($product_categories)) {
                                        ?>
                                            <ul>
                                                <?php
                                                foreach ($product_categories as $category) {
                                                    $category_name = $category->name;
                                                    $category_link = get_term_link($category);
                                                ?>
                                                    <li><a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($category_name); ?></a></li>
                                                <?php
                                                }
                                                ?>
                                            </ul>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="hometrnda-caption-bottom">
                                        <h2><a href="<?php echo get_the_permalink($product_id); ?>"> <?php echo get_the_title($product_id); ?></a></h2>
                                        <?php
                                        if ($social_media_text && $social_media_links) {
                                        ?>
                                            <h6><a href="<?php echo esc_html($social_media_links); ?>"><?php echo esc_html($social_media_text); ?></a></h6>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                } else {
                    ?>
                    <div class="hometrends-prod-item">
                        <p>No product fornd</p>
                    </div>
                <?php
                }

                ?>
            </div>
        </div>

<?php

    }
}
add_action('wp_footer', function () {
    global $mobile_popup_list;
    echo '<div class="hometrends-popup-wrap"><section class="popup">
    <div class="popup__content">
        <div class="close">
        <svg fill="#155252" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
        viewBox="0 0 330 330" xml:space="preserve">
   <path id="XMLID_225_" d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393
       c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393
       s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"/>
   </svg>
        </div>
        ' . $mobile_popup_list . '
    </div>
</section></div>';
});
