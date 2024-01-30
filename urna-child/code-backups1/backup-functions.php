<?php
/**
 * @version    1.0
 * @package    urna
 * @author     Thembay Team <support@thembay.com>
 * @copyright  Copyright (C) 2019 Thembay.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: https://thembay.com
 */

add_action('wp_enqueue_scripts', 'urna_child_enqueue_styles', 10000);
function urna_child_enqueue_styles() {
	$parent_style = 'urna-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'urna-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

function wishlist_total_shortcode()
{
    if (class_exists('YITH_WCWL'))
    {
        $variable = YITH_WCWL()->get_products(['wishlist_id' => 'all']);
        $nm_wishlist_ids = array();
        foreach ($variable as $key => $value)
        {
            $nm_wishlist_ids[] = $value->get_product_id();
        }
        if (!empty($nm_wishlist_ids))
        {
           /* $args = array(
                'post_type' => 'product',
                'order' => 'DESC',
                'orderby' => 'post__in',
                'posts_per_page' => - 1,
                'post__in' => $nm_wishlist_ids
            );*/
            
            $args = array(
    'post_type' => 'product',
    'posts_per_page' => 1,
    'post__in'=> $nm_wishlist_ids
);
            
           

            $nm_wishlist_loop = new WP_Query($args);
          // echo $the_query->request;

        }
        else
        {
            $nm_wishlist_loop = false;
        }
        // echo 'dfdsdsfdsf';
        // print_r($nm_wishlist_loop);
        if ($nm_wishlist_loop && $nm_wishlist_loop->have_posts()):
            $html = '';
            ob_start();
            $html .= '<div class="close-btn-box">
                    <a href="#" class="btn-close"><i class="linear-icon-cross2"></i></a>
                </div><ul>';
            while ($nm_wishlist_loop->have_posts()):
                $nm_wishlist_loop->the_post();

                global $product;
                $product = wc_get_product(get_the_ID());
                $html .= '<li class="minicart-product">
                            
                            <a href="' . get_the_permalink() . '">' . $product->get_image('shop_catalog') . '</a>
                            <div class="product-item_content">
                               <h3 class="woocommerce-loop-product__title"><a href="' . get_the_permalink() . '">' . $product->get_title() . '</a></h3>';
                if (get_post_meta(get_the_ID() , '_price', true))
                {
                    $html .= ' <label class="product-item_quantity">';
                    $html .= '<span>' . get_woocommerce_currency_symbol() . '</span>' . get_post_meta(get_the_ID() , '_price', true);

                    $html .= '</label>';
                }

                $html .= '</div>   
                        </li>';
                //echo '<pre>'; print_r($product);
                $price = 0;
                $price = get_post_meta(get_the_ID() , '_price', true);

                $total_price += $price;

            endwhile;
            $html .= '</ul>';
            $html .= '<div class="minicart-item_total">
                    <span class="font-weight--reguler">Subtotal:</span>
                    <span class="ammount font-weight--reguler"><span>€</span>' . $total_price . '</span>
                </div><div class="minicart-btn_area">
                    <a href="/wishlist">View Wishlist</a>
    </div>
    <div class="global-overlay"></div>';

            ob_end_clean();

        endif;

        return $html;
    }
}
add_shortcode('wishlist_total_shortcode', 'wishlist_total_shortcode');
function add_this_script_footer()
{ ?>

<script>
    jQuery( document ).ready(function() {
           jQuery( document ).ready(function() {
      jQuery(document).on('click','.wishlist-icon',function() {
            event.preventDefault(); 
          //alert('clicked');
      var total_count = jQuery('.count_wishlist').html();
          //console.log(total_count);
      if( total_count > 0){
        jQuery('.header_wistlist_products').toggleClass('show');
      }
          
        });
  });
           jQuery(document).on('click','.close-btn-box a.btn-close',function() {
         event.preventDefault();
           jQuery('.header_wistlist_products').toggleClass('show');
    });
        jQuery(document).mouseup(function(e) 
        {
            var container = jQuery(".header_wistlist_products");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) 
            {
                container.hide();
                jQuery(".header_wistlist_products").removeClass("show");
            }
        });
  });
</script>

<?php
}

add_action('wp_footer', 'add_this_script_footer', 9999);
function wishlist_total_shortcode_ajax()
{
    if (class_exists('YITH_WCWL'))
    {
        $variable = YITH_WCWL()->get_products(['wishlist_id' => 'all']);
        $nm_wishlist_ids = array();
        foreach ($variable as $key => $value)
        {
            $nm_wishlist_ids[] = $value->get_product_id();
        }
        if (!empty($nm_wishlist_ids))
        {
            $args = array(
                'post_type' => 'product',
                'order' => 'DESC',
                'orderby' => 'post__in',
                'posts_per_page' => - 1,
                'post__in' => $nm_wishlist_ids
            );

            $nm_wishlist_loop = new WP_Query($args);

        }
        else
        {
            $nm_wishlist_loop = false;
        }
        // echo 'dfdsdsfdsf';
        // print_r($nm_wishlist_loop);die;
        if ($nm_wishlist_loop && $nm_wishlist_loop->have_posts()):
            $html = '';
            ob_start();
            $html .= '<div class="close-btn-box">
                    <a href="#" class="btn-close"><i class="linear-icon-cross2"></i></a>
                </div><ul>';
            while ($nm_wishlist_loop->have_posts()):
                $nm_wishlist_loop->the_post();

                global $product;
                $product = wc_get_product(get_the_ID());
                $html .= '<li class="minicart-product">
                            
                            <a href="' . get_the_permalink() . '">' . $product->get_image('shop_catalog') . '</a>
                            <div class="product-item_content">
                               <h3 class="woocommerce-loop-product__title"><a href="' . get_the_permalink() . '">' . $product->get_title() . '</a></h3>';
                if (get_post_meta(get_the_ID() , '_price', true))
                {
                    $html .= ' <label class="product-item_quantity">';
                    $html .= '<span>' . get_woocommerce_currency_symbol() . '</span>' . get_post_meta(get_the_ID() , '_price', true);

                    $html .= '</label>';
                }

                $html .= '</div>   
                        </li>';

                //echo '<pre>'; print_r($product);
                $price = 0;
                $price = get_post_meta(get_the_ID() , '_price', true);

                $total_price += $price;

            endwhile;
            $html .= '</ul>';
            $html .= '<div class="minicart-item_total">
                    <span class="font-weight--reguler">Subtotal:</span>
                    <span class="ammount font-weight--reguler"><span>€</span>' . $total_price . '</span>
                </div><div class="minicart-btn_area">
                    <a href="/wishlist">View Wishlist</a>
    </div>
    <div class="global-overlay"></div>';

            ob_end_clean();

        endif;
        if ($total_price == null &&  $html == null  ) {
            $total_price = '0.00';
            $html = '';
        }
        $wishlist_array = array(
            "message" => 'Erfolgreich hinzugefügt',
            "result" => $html,
            "total_price" => $total_price
        );
        echo json_encode($wishlist_array);
        wp_die();
    }
    else
    {

        $wishlist_array = array(
            "message" => 'Erfolgreich hinzugefügt',
            "result" => '',
            "total_price" => '0,00'
        );
        echo json_encode($wishlist_array);
        wp_die();
    }
}

add_action('wp_ajax_wishlist_total_shortcode_ajax', 'wishlist_total_shortcode_ajax');
add_action('wp_ajax_nopriv_wishlist_total_shortcode_ajax', 'wishlist_total_shortcode_ajax');
function urna_tbay_get_icon_wishlist_footer_mobile_new()
{
    $output = '';

    if (!class_exists('YITH_WCWL'))
    {
        return $output;
    }

    $wishlist_url = YITH_WCWL()->get_wishlist_url();
    $wishlist_count = YITH_WCWL()->count_products();
    $output .= '<div class="Wishlist_main_top Wishlist_main_bottom"><div class="header_wistlist_products ">';
    $output .= do_shortcode('[wishlist_total_shortcode]');
    $output .= '</div></div>';
    echo $output;
}
add_action('wp_footer', 'urna_tbay_get_icon_wishlist_footer_mobile_new');

add_action('woocommerce_after_bid_button','decor');
function decor(){
   global $product;
   echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $product->get_id() . '"]');
}