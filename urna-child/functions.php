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

add_action( 'wp_loaded', function() {
  remove_action( 'wp_ajax_woocommerce_prl_print_location', 'woocommerce_prl_print_location' );
} );

function disable_image_sizes($sizes) {
    unset($sizes['thumbnail']);    // Disable thumbnail size
    unset($sizes['medium']);       // Disable medium size
    unset($sizes['medium_large']); // Disable medium-large size
    unset($sizes['large']);        // Disable large size
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'disable_image_sizes', 9998);

function disable_woocommerce_image_sizes($sizes) {
    unset($sizes['woocommerce_thumbnail']);     // Disable WooCommerce thumbnail size
    unset($sizes['woocommerce_single']);        // Disable WooCommerce single product size
    unset($sizes['woocommerce_gallery_thumbnail']); // Disable WooCommerce gallery thumbnail size
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'disable_all_image_sizes', 9999);


function disable_all_image_sizes($sizes) {
    foreach ($sizes as $size => $value) {
        unset($sizes[$size]);
    }
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'disable_all_image_sizes', 9997);

function disable_all_image_sizes_metadata($metadata) {
    if (isset($metadata['sizes'])) {
        $metadata['sizes'] = [];
    }
    return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'disable_all_image_sizes_metadata', 9999);




$heading = apply_filters('woocommerce_product_related_products_heading', esc_html__('Zugehörige Produkte', 'urna'));

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
        $variable = '';
        $variable = YITH_WCWL()->get_products(['wishlist_id' => 'all']);
        $nm_wishlist_ids = array();		
			 
		
		
        foreach ($variable as $key => $value)
        {
			
				  $nm_wishlist_ids[] = $value->get_product_id();
				 
	    }
		
	$products    = array_map( 'wc_get_product', $nm_wishlist_ids );
$final_wishlist_ids = array();
foreach ( $products as $product ) {
	
		
		$final_wishlist_ids[] = $product->get_id();
	
}
			          
  if (!empty($final_wishlist_ids))
        {
            $args =array(
    'post_type' => array('product', 'product_variation'),
    'posts_per_page'=> -1,
                'post__in' => $final_wishlist_ids
                );
          
            $nm_wishlist_loop = new WP_Query($args);         

        }
        else
        {
            $nm_wishlist_loop = false;
        }
		
        
		var_dump($wishlist_loop);
		
        
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
		        echo get_the_ID();
                $html .= '<li class="minicart-product">
                
                            <a href="' . get_the_permalink() . '">' . $product->get_image('shop_catalog') . '</a>
                            <div class="product-item_content">
                               <h3 class="woocommerce-loop-product__title"><a href="' . get_the_permalink() . '">' . $product->get_title() . '</a></h3>';
                if (get_post_meta(get_the_ID() , '_price', true))
                {
                    $html .= ' <label class="product-item_quantity">';
                    $html .= '<span>' . get_woocommerce_currency_symbol() . '</span>' . get_post_meta(get_the_ID() , '_sale_price', true);

                    $html .= '</label>';
                }

                $html .= '</div>   
                        </li>';				
		
                // '<pre>'; print_r($product);
                $price = 0;
		       if(!empty($product->get_title())) {
				   $price = get_post_meta(get_the_ID() , '_sale_price', true);
			   }
                

            $product_price += $the_product->get_price();

            endwhile;
            $total_price =	number_format($total_price, 2, '.', ',');

            $html .= '</ul>';
            $html .= '<div class="minicart-item_total">
                    <span class="font-weight--reguler">Summe:</span>
                    <span class="ammount font-weight--reguler"><span>€</span>' . $total_price . '</span>
                </div>
				<div class="minicart-btn_area">
                    <a href="/wishlist">Zur Wunschliste</a>
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
	
           
      jQuery(document).on('click','.wishlist-icon',function() {
            event.preventDefault(); 
         
            //var total_count = jQuery('.count_wishlist').html();
            
            var total_count = jQuery('.count_wishlist').eq(1).text();
      if( total_count > 0){
        jQuery('.header_wistlist_products').toggleClass('show');
      }

  });
		
           jQuery(document).on('click','.close-btn-box a.btn-close',function() {
         event.preventDefault();
           jQuery('.header_wistlist_products').toggleClass('show');
    });
	           jQuery(document).on('click','.new-close-btn-box a.popup-btn-close',function() {
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
 
</script>

<?php
}

add_action('wp_footer', 'add_this_script_footer', 9999);
function wishlist_total_shortcode_ajax()
{
	    $htmlnwq = '';
    $total_price = 0.00;

     if (class_exists('YITH_WCWL'))
    {
        $variable = '';
        $variable = YITH_WCWL()->get_products(['wishlist_id' => 'all']);
        $nm_wishlist_ids = array();		
			 
		
		
        foreach ($variable as $key => $value)
        {
			
				  $nm_wishlist_ids[] = $value->get_product_id();
				 
	    }
		
	$products    = array_map( 'wc_get_product', $nm_wishlist_ids );
$final_wishlist_ids = array();
foreach ( $products as $product ) {
	
		
		$final_wishlist_ids[] = $product->get_id();
	
}
			          
  if (!empty($final_wishlist_ids))
        {
            $args =array(
    'post_type' => array('product', 'product_variation'),
    'posts_per_page'=> -1,
                'post__in' => $final_wishlist_ids
                );
          
            $nm_wishlist_loop = new WP_Query($args);         

        }
        else
        {
            $nm_wishlist_loop = false;
        }
		
        
		//var_dump($wishlist_loop);
		 
		
        
        if ($nm_wishlist_loop && $nm_wishlist_loop->have_posts()):
            $html = '';
            ob_start();
            $htmlnwq .= '<div class="close-btn-box"> <a href="#" class="btn-close"><i class="linear-icon-cross2"></i></a>';
            $htmlnwq .= do_shortcode('[yith_wcwl_wishlist]');
            $htmlnwq .='</div>';
            $html .= '<div class="close-btn-box">
                    <a href="#" class="btn-close"><i class="linear-icon-cross2"></i></a>
                </div><ul>';
                
            while ($nm_wishlist_loop->have_posts()):
                $nm_wishlist_loop->the_post();

                global $product;
                $product = wc_get_product(get_the_ID());
		        
                $html .= '<li class="minicart-product">
                      <tr id="yith-wcwl-row-461665" data-row-id="461665">
                       <span class="product-remove icon">
                                <a href="/wishlist/?remove_from_wishlist=' . get_the_ID() . '" class="remove_from_wishlist" title="Remove this product"><i class="linear-icon-cross2"></i></a>
                        </span>
                        </tr>
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
		
                // '<pre>'; print_r($product);
                $price = 0;
		       if(!empty($product->get_title())) {
				   $price = get_post_meta(get_the_ID() , '_price', true);
			   }
                

                $total_price += $price;

            endwhile;
            $total_price =	number_format($total_price, 2, '.', ',');

            $html .= '</ul>';
            $htmlnwq .= '
			<div class="wishlist-popup-footer-container">
			<div class="minicart-item_total">
		
                    <span class="font-weight--reguler">Summe:</span>
                    <span class="ammount font-weight--reguler"><span>€</span><span class="whilist_price">' . $total_price . '</span></span>
                </div>

				<div class="minicart-btn_area">
                    <a href="/wishlist" class="popup-go-to-wishlist-btn">Zur Wunschliste</a>
    </div>
				<div class="new-close-btn-box minicart-btn_area">
                    <a href="#" class="popup-btn-close">Zurück</a>
                </div>

				</div>
</div>
    <div class="global-overlay"></div>';

            ob_end_clean();

        endif;
 wp_send_json(array(
		
    'count' => $htmlnwq
    ));
	}
	exit;
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
    //$output .= do_shortcode('[wishlist_total_shortcode]');
    $output .= '</div></div>';
    echo $output;
}
add_action('wp_footer', 'urna_tbay_get_icon_wishlist_footer_mobile_new');

add_action('woocommerce_after_bid_button','decor');
function decor(){
   global $product;
  echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $product->get_id() . '"]');
}

function yith_wcwl_get_items_count()
	{
		ob_start();
		$count = yith_wcwl_count_all_products();
		
		if ($count > 0) {
		?>
			
			<span class="wishlist-header yith-wcwl-items-count"><?php echo esc_html($count); ?></span>
		
		<?php
		}
		
		return ob_get_clean();
	}
		
	add_shortcode( 'yith_wcwl_items_count', 'yith_wcwl_get_items_count' );


function urna_mobile_add_btn_after_add_to_cart_form()
    {
        if (!is_product() || urna_catalog_mode_active()) {
            return;
        }

        if (urna_get_mobile_form_cart_style() === 'default') {
            return;
        }

        global $product;

        if ($product->get_type() == 'external') {
            return;
        }

        $class = '';
        if (urna_tbay_get_config('enable_buy_now', false)) {
            $class .= 'has-buy-now';
        } ?>
		<div id="mobile-close-infor-wrapper"></div>
		<div class="mobile-btn-cart-click <?php echo esc_attr($class); ?>">
			<div id="tbay-click-addtocart">Jetzt Angebot Suchen</div>
			<?php if (urna_tbay_get_config('enable_buy_now', false)) : ?>
				<div id="tbay-click-buy-now"><?php esc_html_e('Buy Now', 'urna') ?></div>
			<?php endif; ?> 
		</div>
		<?php
    }
    add_action('woocommerce_after_add_to_cart_form', 'urna_mobile_add_btn_after_add_to_cart_form', 10, 1);

add_action( 'woocommerce_after_shop_loop_item_title', 'ht3_show_woocommerce_brands_loop', 8 );
 
function ht3_show_woocommerce_brands_loop() {
   global $post, $product;
	 
 $brands = wp_get_post_terms( $post->ID, 'product_brand' );
	if ( $brands )
		$brand = $brands[0];
	if ( ! empty( $brand ) ) {
		$thumbnail = get_brand_thumbnail_url( $brand->term_id );
		$url = get_term_link( $brand->slug, 'product_brand' );
		echo '<div class="ht3-brandimg"><a href="' . $url . '"><img class="woocommerce-brand-image-single" src="'. $thumbnail . '"/></a></div>';
	}
	
}

/* Text for Desktop English to German */
if (!function_exists('urna_woo_product_single_one_page')) {
    function urna_woo_product_single_one_page()
    {
        $menu_bar   =  apply_filters('woo_product_menu_bar', 10, 2);

        if (isset($menu_bar) && $menu_bar) {
            global $product;
            $id = $product->get_id();
            wp_enqueue_script('jquery-onepagenav'); ?>

          <ul id="onepage-single-product" class="nav nav-pills">
            <li class="onepage-overview"><a href="<?php echo (urna_tbay_get_config('select-header-page', 'default') === 'default') ? '#tbay-header' : '#tbay-customize-header' ?>"><?php esc_html_e('Übersicht', 'urna'); ?></a></li>
            <li class="onepage-description"><a href="#woocommerce-tabs"><?php esc_html_e('Produktdetails', 'urna'); ?></a></li>   
 
            <?php if (urna_tbay_get_config('enable_product_releated', true)) : ?>
              <li><a href="#product-related"><?php esc_html_e('Weitere Produkte', 'urna'); ?></a></li>  
            <?php endif; ?>         
          </ul>

          <?php
        }
    }
}

/* Display Add to cart button on archives */ 

//add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10);

/**/
function remove_parent_function() {
    remove_action( 'urna_sticky_menu_bar_product_price_cart', 'urna_sticky_menu_bar_custom_add_to_cart', 5);
	//remove_action( 'urna_sticky_menu_bar_product_price_cart', 'woocommerce_template_single_price', 5);
}
add_action( 'wp_loaded', 'remove_parent_function');

 add_action('urna_sticky_menu_bar_product_price_cart', 'urna_sticky_menu_bar_custom_add_to_cart_new', 10);

function urna_sticky_menu_bar_custom_add_to_cart_new() {

    global $product;
	
	 $product_id = $product->get_id();
	
    if (!$product->is_in_stock()) {
        echo wc_get_stock_html($product);
    } else {
        ?>
<?php echo do_shortcode("[yith_wcwl_add_to_wishlist]");
$url = get_permalink($product_id)?>
     <a id="sticky-custom-add-to-cart cstmfn" class="single_add_to_cart_button external" href="<?php echo $product->add_to_cart_url();?>"><?php echo esc_html($product->single_add_to_cart_text()); ?></a>
    <?php
    }
}

/**/

if (!function_exists('urna_mobile_add_add_to_cart_button_content')) {
    function urna_mobile_add_add_to_cart_button_content()
    {
        if (urna_catalog_mode_active()) {
            return;
        }

        global $product; ?>
		<div id="mobile-close-infor"><i class="linear-icon-cross2"></i></div>
		<div class="mobile-infor-wrapper">
			<div class="media">
				<div class="media-left">
          <?php echo trim($product->get_image('woocommerce_gallery_thumbnail', array('class' => 'mobile-infor-img'))); ?>
				</div>
				<div class="media-body">
					<div class="infor-body">
						<?php echo '<p class="price">'. trim($product->get_price_html()) . '</p>'; ?>
						<?php echo wc_get_stock_html($product); ?>
					</div> 
				</div>
			</div>
			<div class="popup-wishlistbtn"><?php echo do_shortcode("[yith_wcwl_add_to_wishlist]");?></div>
		</div>
		<?php
    }
}

if (defined('YITH_WCWL') && ! function_exists('urna_yith_wcwl_ajax_update_count')) {
    function urna_yith_wcwl_ajax_update_count()
    {
		
      
        $wishlist_count = YITH_WCWL()->count_products();
		
		

        wp_send_json(array(
    'count' => $wishlist_count,
		
			
    ));
    }
   
}
 add_action('wp_ajax_yith_wcwl_update_wishlist_count', 'urna_yith_wcwl_ajax_update_count', 10);
    add_action('wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'urna_yith_wcwl_ajax_update_count', 10);

function mytheme_custom_scripts(){
    
            $scriptSrc = get_stylesheet_directory_uri() . '/js/custom-amount.js';
            wp_enqueue_script( 'camt', $scriptSrc , array(), '1.0',  true );
	
	wp_localize_script( 'camt', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
   
}
add_action( 'wp_enqueue_scripts', 'mytheme_custom_scripts' );

function urna_yith_wcwl_ajax_update_amount()
{
	if (class_exists('YITH_WCWL'))
    {
		$total_price = 0;
        $variable = '';
        $variable = YITH_WCWL()->get_products(['wishlist_id' => 'all']);
        $nm_wishlist_ids = array();		
			 
		
		
        foreach ($variable as $key => $value)
        {
			
				  $nm_wishlist_ids[] = $value->get_product_id();
				 
	    }
		
	$products    = array_map( 'wc_get_product', $nm_wishlist_ids );
$final_wishlist_ids = array();
foreach ( $products as $product ) {
	
		
		$final_wishlist_ids[] = $product->get_id();
	
}
			          
  if (!empty($final_wishlist_ids))
        {
            $args =array(
    'post_type' => array('product', 'product_variation'),
    'posts_per_page'=> -1,
                'post__in' => $final_wishlist_ids
                );
          
            $nm_wishlist_loop = new WP_Query($args);         

        }
        else
        {
            $nm_wishlist_loop = false;
        }
		
        
		//var_dump($wishlist_loop);
		
        
        if ($nm_wishlist_loop && $nm_wishlist_loop->have_posts()):
           
            while ($nm_wishlist_loop->have_posts()):
                $nm_wishlist_loop->the_post();

                global $product;
                $product = wc_get_product(get_the_ID());
		         $productid = $product->get_id();
                $price = 0;
		       if(!empty($product->get_title()) || ($productid !== $_POST['product_id'])) {
				   $price = get_post_meta(get_the_ID() , '_price', true);
			   }
                

                $total_price += $price;

            endwhile;
		 endif;
        

              
              if(isset($_POST['product_id'])) {
				   $cost = get_post_meta($_POST['product_id'] , '_price', true);
				 
				   $total_price += $cost;
				 
			  }
		 if(isset($_POST['product_did'])) {
				   $deleteCost = get_post_meta($_POST['product_did'] , '_price', true);
			
				   $total_price = $total_price - $deleteCost;
				 
			 
			  }
			  

               
	$total_price =	number_format($total_price, 2, '.', ',');

      
	  wp_send_json(array(
		
    'tot_amount' => $total_price
    ));
	}
	exit;
}

add_action('wp_ajax_urna_yith_wcwl_ajax_update_amount', 'urna_yith_wcwl_ajax_update_amount', 15, 1);
 add_action('wp_ajax_nopriv_urna_yith_wcwl_ajax_update_amount', 'urna_yith_wcwl_ajax_update_amount', 15, 1);


add_action('wp_ajax_urna_yith_wcwl_ajax_pageload_update_amount', 'urna_yith_wcwl_ajax_pageload_update_amount');
 add_action('wp_ajax_nopriv_urna_yith_wcwl_ajax_pageload_update_amount', 'urna_yith_wcwl_ajax_pageload_update_amount');
function urna_yith_wcwl_ajax_pageload_update_amount() {
if (class_exists('YITH_WCWL'))
    {
		$total_price = 0;
        $variable = '';
        $variable = YITH_WCWL()->get_products(['wishlist_id' => 'all']);
        $nm_wishlist_ids = array();		
			 
		
		
        foreach ($variable as $key => $value)
        {
			
				  $nm_wishlist_ids[] = $value->get_product_id();
				 
	    }
		
	$products    = array_map( 'wc_get_product', $nm_wishlist_ids );
$final_wishlist_ids = array();
foreach ( $products as $product ) {
	
		
		$final_wishlist_ids[] = $product->get_id();
	
}
			          
  if (!empty($final_wishlist_ids))
        {
            $args =array(
    'post_type' => array('product', 'product_variation'),
    'posts_per_page'=> -1,
                'post__in' => $final_wishlist_ids
                );
          
            $nm_wishlist_loop = new WP_Query($args);         

        }
        else
        {
            $nm_wishlist_loop = false;
        }
		
        
		//var_dump($wishlist_loop);
		
        
        if ($nm_wishlist_loop && $nm_wishlist_loop->have_posts()):
           
            while ($nm_wishlist_loop->have_posts()):
                $nm_wishlist_loop->the_post();

                global $product;
                $product = wc_get_product(get_the_ID());
		        
                $price = 0;
		       if(!empty($product->get_title())) {
				   $price = get_post_meta(get_the_ID() , '_price', true);
			   }
                

                $total_price += $price;

            endwhile;
		 endif;

              

               
	$total_price =	number_format($total_price, 2, '.', ',');
  $wishlist_cnt = YITH_WCWL()->count_products();
    
	  wp_send_json(array(
	'cnt' => $wishlist_cnt,	
    'tot_amount' => $total_price
    ));
	}
	exit;
}


add_action('wp_enqueue_scripts', 'child_theme_js_file_override');
function child_theme_js_file_override(){
	   wp_dequeue_script( 'urna_script_js' );

    wp_enqueue_script( 'child_theme_script_handle', get_theme_file_uri() . '/js/functions.js', array('jquery' ) );
}
function shortcode_wishlist(){
	?>
<div class="wishlist_custom top-wishlist">
	<?php
	urna_tbay_get_page_templates_parts('wishlist');
	?> 
</div>
   <?php 
}
add_shortcode('topmenuwishlist','shortcode_wishlist');

