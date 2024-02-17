<?php

/**
 * Responsible for elementor functions
 */


add_filter('hometrends_get_product_categories', 'hometrends_get_product_categories', 10, 2);


function hometrends_get_product_categories($cats_arr = array(), $parent = 0)
{


    $product_categories = get_terms(array(
        'taxonomy' => 'category',
        'hide_empty' => false,
        'parent' => $parent,
    ));

    if ($product_categories && !is_wp_error($product_categories)) {
        foreach ($product_categories as $category) {

            $cats_arr[$category->term_id] = wp_specialchars_decode($category->name);
        }
    }


    return $cats_arr;
}


add_action('wp_ajax_hometrends_load_cat_products', 'hometrends_load_cat_products');
add_action('wp_ajax_nopriv_hometrends_load_cat_products', 'hometrends_load_cat_products');



function hometrends_load_cat_products($hometrends_settings = array(), $active_parent_id = 0)
{

    $cat_id = isset($_POST['cat_id']) && $_POST['cat_id'] != '' ? $_POST['cat_id'] : '';
    $settings = isset($_POST['settings']) && $_POST['settings'] != '' ? $_POST['settings'] : '';
    $type = isset($_POST['type']) && $_POST['type'] != '' ? $_POST['type'] : '';


    if ($cat_id != '') {
        $active_parent_id = explode(',',$cat_id);
    }

    if ($settings != '') {
        $hometrends_settings = json_decode($settings);
    }


    $prod_order = isset($hometrends_settings['prod_order']) && $hometrends_settings['prod_order'] != '' ? $hometrends_settings['prod_order'] : 'DESC';
    $no_of_posts = isset($hometrends_settings['no_of_posts']) && $hometrends_settings['no_of_posts'] != '' ? $hometrends_settings['no_of_posts'] : 10;

    // $child_list_data = get_term_children($active_parent_id, 'category');

    // $child_list_data = !empty($child_list_data) ? array_map('intval', $child_list_data) : array();

    // $child_list = '';

    // if (!empty($child_list_data)) {

    //     $child_list .= '<ul>';

    //     foreach ($child_list_data as $term_key) {

    //         $child_term = get_term_by('id', $term_key, 'category');

    //         if ($child_term) {
    //             $child_list .= '<li><a href="javascript:void(0)" data-target="' . $child_term->term_id . '" data-type="child"> ' . $child_term->name . ' </a></li>';
    //         }
    //     }

    //     $child_list .= '</ul>';
    // }


    $product_args = array(
        'post_type' => 'post',
        'posts_per_page' => $no_of_posts,
        'post_status' => 'publish',
        'order' => $prod_order,
        'orderby' => 'date',
        'category__in' => $active_parent_id,
    );

    // echo '<pre>';
    // print_r($product_args);
    // echo '</pre>';


    $product_array = new WP_Query($product_args);

    $prod_html_content_ = '';

    ob_start();

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


    $prod_html_content_ = ob_get_contents();
    ob_get_clean();


    if ($cat_id != '') {

        $return_data = array(
            'content' => $prod_html_content_,
            'child_list' => $child_list,
        );

        echo json_encode($return_data);
        wp_die();
    } else {

        $return_data = array(
            'content' => $prod_html_content_,
            'child_list' => $child_list,
        );
        return $return_data;
    }
}