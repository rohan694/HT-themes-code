<?php

/**
 * Astra HomeTrends Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra HomeTrends
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define('CHILD_THEME_ASTRA_HOMETRENDS_VERSION', '1.0.0');

/**
 * Enqueue styles
 */
function child_enqueue_styles()
{

  wp_enqueue_style('astra-hometrends-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_HOMETRENDS_VERSION, 'all');

  if (is_product()) {
    wp_enqueue_style('swiper', get_stylesheet_directory_uri() . '/assets/css/swiper.css');
    wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/assets/js/swiper.js', array('jquery'), CHILD_THEME_ASTRA_HOMETRENDS_VERSION, false);

    wp_dequeue_script('astra-sticky-add-to-cart-js');

  }

  wp_enqueue_script('hometrends-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), CHILD_THEME_ASTRA_HOMETRENDS_VERSION, true);
}

add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);

if (!function_exists('astra_child_single_post_class')) {

  function astra_child_single_post_class($classes)
  {

    if (is_product()) {

      if (!in_array('ast-related-post', $classes)) {
        $classes[] = 'swiper-slide';
      }
    }

    return $classes;
  }
}

add_filter('post_class', 'astra_child_single_post_class');




// Code Albert
// Disable Plugin update for Woocommerce External Products and Doofinder - Both should not be updated
function disable_plugin_update_notifications($transient)
{
  if (isset($transient->response) && is_object($transient)) {
    // List of plugins to disable updates for
    $plugins_to_disable = array(
      'improved-external-products-pro/wc-improved-external-products-pro.php',
      'doofinder-for-woocommerce/doofinder-for-woocommerce.php'
    );

    foreach ($plugins_to_disable as $plugin) {
      if (isset($transient->response[$plugin])) {
        unset($transient->response[$plugin]);
      }
    }
  }
  return $transient;
}
add_filter('site_transient_update_plugins', 'disable_plugin_update_notifications');


// Wishlist functionality 
// Rohan is working on it here
function wishlist_add_short()
{

  $html = '
         <div class="menu-click wishlist_setup">
                <div class="top-wishlist">
                        <a class="text-skin wishlist-icon">
             [yith_wcwl_items_count]
        </a>
                </div>
                <div class="Wishlist_main_top">
                        <div class="whilist_price_Section">
                                <h4 class="whilist_price_heading">Wunschliste   
                                </h4>
                                <div class="whilist_price_tab">
                                                        <span class="whilist_price">[tnc-wishlist-counter]</span>
                                </div>
                        </div>
                </div>
        </div>
  <div class="opabg"></div>
        <div class="menu-wishlist">
         <div class="heading_section">
         <h3>Wunschliste</h3>
          <a class="btn menu-click">X
          </a>
          </div>
      <div class="abox">
            [yith_wcwl_wishlist]
          </div>
    <div class="tottl" style="display: none;">
      <h4>Total</h4>
      <p class="price">€2,208.00</p>
    </div>
</div>
        <style>
  .wishlist-items-wrapper .woocommerce-Price-amount.amount {
    color: #C5283D;
  }
  .opabg.open {
    content: """";
    width: 100%;
    height: 100%;
    background: #0000007d;
    left: 0;
    right: auto;
    top: 0;
    bottom: 0;
    position: fixed;
    z-index: 99;
}
.wishlist_table .product-add-to-cart a.button {
        padding: 6px 17px 9px !important;
        width: 100%;
        max-width: 196px;
}
a.btn.menu-click {
        color: #000;
}
        .top-wishlist .count_wishlist {
  background-color: #000 !important;
  transition: all 0.3s;
}
.top-wishlist i {
        font-size: 20px;
        vertical-align: middle;
}
.top-wishlist a {
        line-height: 23px;
        position: relative;
        display: block;
        margin-bottom: 20px;
}
.Wishlist_main_top {
        display: inline-block;
        vertical-align: middle;
        padding: 0 8px;
}
.whilist_price_Section h4 {
        display: block;
}
.whilist_price_tab span {
        color: #CA0815;
        font-size: 15px;
        font-weight: 500;
}

.whilist_price_tab {
  margin-left: auto !important;
  text-align: right;
}



.menu-wishlist {
  background-color: #ffffff;
  width: 480px;
  height: 100vh;
  position: fixed;
  right: -480px;
  transition: all 0.5s linear;
  top:0px;
  left: auto !important;
  z-index:9999!important;
}
.menu-wishlist .btn {
  color: white;
}
.menu-wishlist .btn .fa {
  margin-left: 8px;
}
.menu-wishlist ul {
  margin-top: 0;
  padding-top: 0;
  padding: 0;
}
.menu-wishlist ul li:first-child {
  border-top: 1px solid #008bad;
}
.menu-wishlist ul li {
  color: #fff;
  border-bottom: 1px solid #008bad;
  list-style: none;
  margin-left: 0;
  padding-left: 0;
  line-height: 44px;
  padding-left: 12px;
  cursor: pointer;
}
.menu-wishlist ul li:hover {
  background-color: #007793;
}

.open {
  right: 0 !important;
  z-index: 2;
}

.menu-click {
  color: #00a0c6;
  cursor: pointer;
}
.menu-click .fa {
  cursor: pointer;
  font-size: 2em;
  padding: 6px;
  margin-right: 8px;
}

.content {
  position: relative;
}
.content .menu-click {
  position: absolute;
  right: 0;
}

table.wishlist_table tr>td.product-name a {
  color: #000 !important;
}



.back-to-all-wishlists {
  position: absolute;
  top: 26px;
  right: 40px;
  font-size: 0;
}

.menu-wishlist .link {
  position: absolute;
  bottom: 15px;
  right: 15px;
  display: none;
}


.menu-wishlist .link a {
  color: #004e60;
  text-decoration: none;
}
.link a:hover {
  text-decoration: underline;
}

.ui-loader {
  display: none;
}
.menu-wishlist .wishlist-title-container {
        display: none;
}
.menu-wishlist .wishlist_table thead {
        display: none;
}


.menu-wishlist .woocommerce table.wishlist_table tr td.product-remove {
        padding: .7em 0.3em;
}

a.text-skin.wishlist-icon h3 {
  font-size: 20px !important;
}

.menu-wishlist.open {
  width: auto !important;
  max-width: 480px !important;
}
table.shop_table.cart.wishlist_table.wishlist_view {
  padding: 0 20px;
  border: none;
}

table.wishlist_table tr td.product-arrange {
  display: none;
}

table.wishlist_table tr {
  display: flex;
  flex-wrap: wrap;
  border-bottom: 1px solid #ddd;
  justify-content: end;
  align-items: center;
  padding-bottom: 15px;
  margin-bottom: 15px;
}

.tottl {
  display: flex;
  justify-content: space-between;
  padding-inline: 20px;
  // padding-top: 20px;
  align-items: center;
}


.shop_table ~ p {
  padding-inline: 20px !important;
  display: flex;
  justify-content: space-between;
  position: absolute;
  bottom: 140px;
  width: 100%;
}

.shop_table ~ p b {
  font-size: 24px !important;
  color: #155252 !IMPORTANT;
}

.woocommerce a.remove {
  line-height: 18px !important;
}

table.wishlist_table tr>td {
  border: none !important;
}

.menu-wishlist.open::-webkit-scrollbar {
  display: none;
}
.heading_section ~ .abox {
  height: 100%;
  overflow-y: auto;
  max-height: 70% !important;
}

.tottl p.price, .shop_table ~ p span.woocommerce-Price-amount.amount {
  font-size: 20px;
  font-weight: 700;
  color: #C5283D;
}

.wishlist-page-links {
  position: absolute;
  z-index: 9999;
  bottom: 10px;
  left: 20px;
  right: 20px;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-between;
}

.wishlist-page-links a {
  background: #155252;
  padding: 6px 15px;
  font-size: 13px;
  border-radius: 10px;
  color: #fff;
  margin-bottom: 10px;
  display: inline-block;
}
.menu-click.wishlist_setup {
  display: flex;
  align-items: center;
  border-radius: 10px;
  width: 200px;
}

a.text-skin.wishlist-icon .whilist_price_Section {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-direction: column;
}


.whilist_price_tab span {
  font-size: 16px;
  font-weight: 700;
  color: #e3a428 !important;
}

.whilist_price_Section h4.whilist_price_heading {
  margin-bottom: 5px !important;
  font-size: 16px !important;
}

.menu-click.wishlist_setup a.text-skin.wishlist-icon {
  margin-bottom: 10px;
}

span.yith-wcwl-items-count i {
  color: #e4a428 !important;
  font-size: 20px !important;
}

.wishlist-page-links a.create {
  background: #15525238 !important;
  color: #000;
}

.wishlist-page-links a.search {
  width: 100%;
  text-align: center;
  padding-block: 10px;
  font-size: 14px;
}

.yith_wcwl_wishlist_footer, #create_new_wishlist, span.wishlist-page-links-separator {
  display: none;
}

.heading_section ~ .abox::-webkit-scrollbar {
  display: none;
}

table.wishlist_table tr td.product-remove {
  position: absolute;
  right: 0;
  top: 35%;
}

table.wishlist_table tr>td.product-thumbnail {
  width: 25% !important;
  max-width: 25%;
  position: absolute;
  left: 0;
}

table.wishlist_table tr>td.product-name {
  width: 75%;
  max-width: 75%;
  padding-right: 30px !important;
}

table.wishlist_table tr>td.product-price {
  width: 75% !important;
  text-align: left;
}


table.wishlist_table tr>td.product-add-to-cart {
  width: 75% !important;
  max-width: 100% !important;
  text-align: left;
}


.heading_section {
  padding-top: 20px;
  padding-left: 20px;
  position: relative;
  border-bottom: 1px solid #ddd;
  margin-bottom: 20px;
}

table.wishlist_table tr td {
  padding: 2px !important;
}

.menu-wishlist h3, .menu-wishlist a {
  font-weight: 900;
  border: 0 !important;
  text-decoration: none !important;
}

table.wishlist_table tr>td.product-add-to-cart a {
  display: block !important;
  width: 121px;
  margin-left: 0 !important;
  margin-top: 10px !important;
}

.cont {
  position: absolute;
  top: 0;
  right: 0;
  width: 20px;
  height: 20px;
  background: #000;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 12px;
  color: #fff;
}

span.yith-wcwl-items-count i {
  font-size: 25px !important;
}

a.btn.menu-click {position: absolute;right: 60px;top: 40%;}

.heading_section i.linear-icon-cross {
  position: relative;
}
@media screen and (min-width: 768px) {
.heading_section i.linear-icon-cross:before {
  content: "×";
  position: absolute;
  top: 0;
  width: 100%;
  height: 100%;
  font-size: 40px;
  z-index: 20;
  left: 0;
  text-align: end;
  color: #155252;
  font-family: "Font Awesome 5 Free";
}
.btnboxcart a.boxWunschliste {
  width: 100%;
  display: block;
  background: #155252;
  padding: 0px 0px;
  color: #fff;
  text-align: center;
  height: 45px;
  line-height: 45px;
  border-radius: 15px;
  margin-bottom: 7px;
  font-weight: 500;
}
.btnboxcart {
  display: block;
  float: left;
  width: 100%;
  margin-top: 14px;
}
.menu-wishlist.open .wishlist-page-links {
  display: none;
}
.menu-wishlist.open .abox {
  padding: 0px 15px;
}
p.totlapffsdfsfs b {
  font-size: 24px !important;
  color: #155252 !IMPORTANT;
}
p.totlapffsdfsfs 
 span.woocommerce-Price-amount.amount {
    font-size: 23px !important;
    font-weight: 700;
    color: #C5283D;
    float: right;
}
.box_prixcessd {
  padding: 4px 15px;
  background: #fff;
}
.box_prixcessd {
        padding: 15px 15px 5px;
        background: #fff;
        display: block;
        float: left;
        width: 100%;
        position: absolute;
  bottom: 0;
}
}
@media screen and (max-width: 767px) {

.menu-wishlist.open .menu-wishlist h3, .menu-wishlist.open .menu-wishlist a {
    font-weight: 900;
    border: 0 !important;
    text-decoration: none !important;
    color: #000 !important;
    font-size: 15px;
    line-height: 26px;
}
.menu-wishlist.open span.woocommerce-Price-amount.amount {
  color: #C5283D;
  font-size: 16px;
  font-weight: 600;
}
.menu-wishlist.open table.item-details-table tr td.label {
  display: none !important;
}
.menu-wishlist.open table.item-details-table tr td.value {
  float: left !important;
}
.menu-wishlist.open .item-details .product-name h3 a {
  font-weight: 900;
  border: 0 !important;
  text-decoration: none !important;
  color: #000 !important;
  font-size: 15px;
  line-height: 26px;
}
.menu-wishlist.open .shop_table ~ p {
        background: #fff;
}
.menu-wishlist.open .wishlist-page-links {
  display: none;
}
p.totlapffsdfsfs b {
  font-size: 24px !important;
  color: #155252 !IMPORTANT;
}
p.totlapffsdfsfs 
 span.woocommerce-Price-amount.amount {
    font-size: 23px !important;
    font-weight: 700;
    color: #C5283D;
    float: right;
}
.box_prixcessd {
  padding: 4px 15px;
  background: #fff;
}
.box_prixcessd {
  padding: 15px 15px 5px;
  background: #fff;
  display: block;
  float: left;
  width: 94%;
  position: fixed;
  bottom: 0;
}
.btnboxcart a.boxWunschliste {
  width: 100%;
  display: block;
  background: #155252;
  padding: 0px 0px;
  color: #fff;
  text-align: center;
  height: 45px;
  line-height: 45px;
  border-radius: 15px;
  margin-bottom: 7px;
  font-weight: 500;
}
.btnboxcart a.boxWunschliste_new {
  width: 100%;
  display: block;
  background: #155252;
  padding: 0px 0px;
  color: #fff;
  text-align: center;
  height: 45px;
  line-height: 45px;
  border-radius: 15px;
  margin-bottom: 7px;
  font-weight: 500;
}
.btnboxcart {
  display: block;
  float: left;
  width: 100%;
  margin-top: 14px;
}
.menu-wishlist ul li {
  border-bottom: 2px solid #d5d5d5;
}
.menu-wishlist.open .abox {
  padding: 0px 15px;
}
.menu-wishlist.open ul li:first-child {
  border-top: 1px solid #008bad;
  border-top: none;
}
.menu-wishlist.open ul li {
  position: relative;
}
.menu-wishlist.open ul li .product-remove {
  position: absolute;
  right: 0;
  top: 0;
}
.menu-wishlist.open ul li {
  position: relative;
}
.menu-wishlist.open ul li .product-remove a {
  color: #B3B3B3;
  border: 2px solid #B3B3B3 !important;
  border-radius: 100%;
  display: block;
  padding: 0px 5px;
  height: 25px;
  line-height: 20px;
}
.menu-wishlist.open ul li .product-remove a .fa.fa-trash:before {
  content: "×";
  font-size: 19px;
}
.menu-wishlist.open ul.shop_table.cart.wishlist_table.wishlist_view.responsive.mobile {
  padding-bottom: 70px;
}
}
        </style>
    <script>
jQuery(function() {
  jQuery(".menu-click").click( function() {
   jQuery(".menu-wishlist , .opabg").toggleClass("open");
   jQuery(".back-to-all-wishlists").addClass("show");
  });

  jQuery(".back-to-all-wishlists").click( function() {
    jQuery(".menu-wishlist").removeClass("open");
   });
 

  jQuery("body").on("swipeleft", function() {
    jQuery(".menu-wishlist , .opabg").addClass("open");
  });
  jQuery(".menu-wishlist , .opabg").on("swiperight", function() {
    jQuery(".menu-wishlist , .opabg").toggleClass("open");
  });

  jQuery(".clside").click(function() {
    jQuery(".menu-wishlist").css("right","-480px");
  });
  jQuery(".opabg").click(function() {
    jQuery(".menu-wishlist").css("right","-480px");
	jQuery(".opabg").removeClass("open");
  });
  jQuery(".wishlist_setup").click(function(){
    jQuery(".opabg, body").addClass("open");
  });

  jQuery(".clside, .btn.menu-click").click(function() {
    jQuery(".opabg").removeClass("open");
  });

});



        </script>
        ';

  return $html;

  // if ( is_active_sidebar( 'header_widgets_wishlist' ) ) :
  // dynamic_sidebar( 'header_widgets_wishlist' ); 
  // endif; 
}
add_shortcode('wishlist_new', 'wishlist_add_short');

if (defined('YITH_WCWL') && !function_exists('yith_wcwl_get_items_count')) {
  function yith_wcwl_get_items_count()
  {
    ob_start();

    $heart_class = yith_wcwl_count_all_products() > 0 ? 'fa-heart' : 'fa-heart-o';

?>
    <a>
      <span class="yith-wcwl-items-count count_wishlists">
        <i class="yith-wcwl-icon fa <?php echo $heart_class; ?>">
        </i>
        <div class="cont"><?php echo esc_html(yith_wcwl_count_all_products()); ?></div>
      </span>
    </a>
  <?php
    return ob_get_clean();
  }

  add_shortcode('yith_wcwl_items_count', 'yith_wcwl_get_items_count');
}

if (defined('YITH_WCWL') && !function_exists('yith_wcwl_ajax_update_count')) {
  function yith_wcwl_ajax_update_count()
  {
    wp_send_json(array(
      'count' => yith_wcwl_count_all_products()
    ));
  }

  add_action('wp_ajax_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count');
  add_action('wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count');
}

if (defined('YITH_WCWL') && !function_exists('yith_wcwl_enqueue_custom_script')) {
  function yith_wcwl_enqueue_custom_script()
  {
    wp_add_inline_script(
      'jquery-yith-wcwl',
      "
        jQuery( function( $ ) {
          $( document ).on( 'added_to_wishlist removed_from_wishlist', function() {
            $.get( yith_wcwl_l10n.ajax_url, {
              action: 'yith_wcwl_update_wishlist_count'
            }, function( data ) {
              $('.yith-wcwl-items-count .cont').html( data.count );
              if(data.count == 0){
                $('.whilist_price_Section .whilist_price .woocommerce-Price-amount').html('<bdi>0.00 €</bdi>');

                $('.yith-wcwl-items-count i').removeClass('fa-heart').addClass('fa-heart-o');
              }else{
                var updatprices =   $('.totlapffsdfsfs .woocommerce-Price-amount').html();
                $('.whilist_price_Section .whilist_price .woocommerce-Price-amount').html(updatprices);
                $('.yith-wcwl-items-count i').removeClass('fa-heart-o').addClass('fa-heart');
              }
            } );
          } );
        } );
      "
    );
  }

  add_action('wp_enqueue_scripts', 'yith_wcwl_enqueue_custom_script', 20);
}

if (!function_exists('yith_wcwl_items_total')) {
  function yith_wcwl_items_total($args)
  {
    /**
     * @var $wishlist YITH_WCWL_Wishlist
     */
    $wishlist = isset($args['wishlist']) ? $args['wishlist'] : false;

    if (!$wishlist || !$wishlist instanceof YITH_WCWL_Wishlist) {
      return;
    }

    $total = 0;

    if ($wishlist->has_items()) {
      foreach ($wishlist->get_items() as $item) {
        $total += $item->get_product_price();
      }
    }

    if ($total) {
      echo '<div class="box_prixcessd"><p class="totlapffsdfsfs"><b>Summe :</b> ' . wc_price($total) . '</p>
          <div class="btnboxcart">
              <a class="boxWunschliste_new" href="https://hometrends.one/wunschliste/">Zur Wunschliste</a>
              <a class="boxWunschliste clside" role="button">Zurück</a>
          </div>
          </div>';
    }
  }
}
add_action('yith_wcwl_wishlist_after_wishlist_content', 'yith_wcwl_items_total', 5, 1);
if (!function_exists('yith_wcwl_wishlist_cost_summary')) {
  function yith_wcwl_wishlist_cost_summary()
  {
    if (yith_wcwl_get_wishlist(false)) {
      $default_wishlist = yith_wcwl_get_wishlist(false);
      $total_price = 0;
      if ($default_wishlist->has_items()) {
        foreach ($default_wishlist->get_items() as $item) {
          $total_price += $item->get_product_price();
        }
      }

      $output = wc_price($total_price);
      return $output;
    }
  }
}
add_shortcode('tnc-wishlist-counter', 'yith_wcwl_wishlist_cost_summary');


function wpai_pmxi_saved_post($post_id)
{
  global $import_id; // Get the global variable

  // Make sure this is a WooCommerce Product or Product Variation
  $post_type = get_post_type($post_id);
  if ('product' !== $post_type && 'product_variation' !== $post_type) {
    return;
  }

  // Do your logging here.
  $log_message = sprintf('WP All Import has saved a %s with ID %d for Import ID %d.', $post_type, $post_id, $import_id);
  error_log($log_message);
}
add_action('pmxi_saved_post', 'wpai_pmxi_saved_post', 10, 1);


add_action('woocommerce_after_shop_loop_item_title', 'ht3_show_woocommerce_brands_loop', 8);

function ht3_show_woocommerce_brands_loop()
{
  global $post, $product;

  $brands = wp_get_post_terms($post->ID, 'product_brand');
  if ($brands)
    $brand = $brands[0];
  if (!empty($brand)) {
    $thumbnail = get_brand_thumbnail_url($brand->term_id);
    $url = get_term_link($brand->slug, 'product_brand');
    echo '<div class="ht3-brandimg"><a href="' . $url . '"><img class="woocommerce-brand-image-single" src="' . $thumbnail . '"/></a></div>';
  }
}
if (!function_exists('yith_wcwl_add_default_wishlist_feature')) {

  function yith_wcwl_add_default_wishlist_feature()
  {

    if (isset($_GET['yith_wcwl_set_default'])) {

      $all_user_wishlists = YITH_WCWL_Wishlist_Factory::get_wishlists(array("user_id" => get_current_user_id()));
      foreach ($all_user_wishlists as $user_wishlist) {
        $user_wishlist->set_is_default(0);
        $user_wishlist->save();
      }

      $token = $_GET['yith_wcwl_set_default'];
      $wishlist = yith_wcwl_get_wishlist($token);
      $wishlist->set_is_default(1);
      $wishlist->save();
    }
  }

  add_action('init', 'yith_wcwl_add_default_wishlist_feature');
}


function register_custom_widget_area()
{
  register_sidebar(
    array(
      'id' => 'header_widgets_wishlist',
      'name' => esc_html__('Header Wishlist area', 'theme-domain'),
      'description' => esc_html__('A new widget area made for testing purposes', 'theme-domain'),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
      'after_title' => '</h3></div>'
    )
  );
}
add_action('widgets_init', 'register_custom_widget_area');
function footer_jquery_function()
{
  ?>

  <?php
}
add_action('wp_footer', 'footer_jquery_function');
function change_wishlist_selected()
{
  global $wpdb;

  $wishlist = $_POST['wishlist'];
  $product_id = $_POST['product_id'];
  $user_id = $_POST['user_id'];
  $wishlist_id = $_POST['wishlist_id'];
  $wishlistold = $wpdb->get_results("SELECT * FROM ht3_yith_wcwl_wishlist WHERE (wishlist_id = '" . $wishlist_id . "' AND product_id = '" . $product_id . "')");
  $wish_id = $wishlistold[0]->ID;
  if ($wishlistold[0]->wishlist_id == $wishlist_id) {
    $result = $wpdb->update('ht3_yith_wcwl_wishlist', array('wishlist_name' => $wishlist, 'product_id' => $product_id, 'user_id' => $user_id, 'wishlist_id' => $wishlist_id), array('ID' => $wish_id), array('%s', '%s', '%s', '%s'), array('%d'));
    if ($result == true) {
      $add_wishlist_gn = get_transient('add_wishlist_codes');
      wp_send_json(
        apply_filters(
          'yith_wcwl_ajax_add_return_params',
          $add_wishlist_gn
        )
      );
    }
  } else {
    if ($wpdb->insert('ht3_yith_wcwl_wishlist', array(
      'wishlist_name' => $wishlist,
      'product_id' => $product_id,
      'user_id' => $user_id,
      'wishlist_id' => $wishlist_id
    )) === false) {
      echo 'Error';
    } else {
      $add_wishlist_gn = get_transient('add_wishlist_codes');
      wp_send_json(
        apply_filters(
          'yith_wcwl_ajax_add_return_params',
          $add_wishlist_gn
        )
      );
    }
  }
}
add_action('wp_ajax_change_wishlist_selected', 'change_wishlist_selected');
add_action('wp_ajax_nopriv_change_wishlist_selected', 'change_wishlist_selected');


// Albert 
function wprocketpurge_after_xml_import($import_id, $import)
{
  // Only run if import ID is 25 Ralawise Import.
  if ($import_id == 25) {
    // Clear cache.
    // Also preload the cache if the Preload is enabled.
    if (function_exists('rocket_clean_domain')) {
      rocket_clean_domain();
    }
    // Clear minified CSS and JavaScript files.
    if (function_exists('rocket_clean_minify')) {
      rocket_clean_minify();
    }
  }
}
add_action('pmxi_after_xml_import', 'wprocketpurge_after_xml_import', 10, 2);

// SVG Support for WordPRess
function add_file_types_to_uploads($file_types)
{
  $new_filetypes = array();
  $new_filetypes['svg'] = 'image/svg+xml';
  $file_types = array_merge($file_types, $new_filetypes);
  return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');


remove_action('wp_footer', array('Astra_Woocommerce', 'single_product_sticky_add_to_cart'), 10);

add_action('wp_footer', 'single_product_sticky_add_to_cart_child', 0);

function single_product_sticky_add_to_cart_child()
{

  if (is_product() && astra_get_option('single-product-sticky-add-to-cart')) {
    /** @psalm-suppress InvalidGlobal */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
    global $post;

    $product          = wc_get_product($post->ID);
    $sticky_position  = astra_get_option('single-product-sticky-add-to-cart-position');
    $add_to_cart_ajax = astra_get_option('single-product-ajax-add-to-cart');
    // @codingStandardsIgnoreStart
    /**
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress PossiblyFalseReference
     */
    if (($product->is_purchasable() && ($product->is_in_stock() || $product->backorders_allowed())) || $product->is_type('external')) {
      // @codingStandardsIgnoreEnd
      if (is_customize_preview()) {
        echo '<div class="ast-sticky-add-to-cart customizer-item-block-preview customizer-navigate-on-focus ' . esc_attr($sticky_position) . '" data-section="astra-settings[single-product-sticky-add-to-cart]" data-type="control">';
        /** @psalm-suppress TooManyArguments */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
        Astra_Builder_UI_Controller::render_customizer_edit_button('row-editor-shortcut');
      } else {
        echo '<div class="ast-sticky-add-to-cart ' . esc_attr($sticky_position) . '">';
      }
      echo '<div class="ast-container">';
      echo '<div class="ast-sticky-add-to-cart-content homeone-child-stick">';
      echo '<div class="ast-sticky-add-to-cart-title-wrap">';
      // sticky media product image
      echo '<div class="homeone-sticky-media">';
      echo wp_kses_post(woocommerce_get_product_thumbnail());
      echo '</div>';
      // sticky content data
      echo '<div class="homeone-sticky-content">';

      echo '<span class="ast-sticky-add-to-cart-title">' . wp_kses_post(get_the_title()) . '</span>';

      echo '<div class="homeone-sticky-rating-brand">';

      $average_rating = get_post_meta(get_the_ID(), '_wc_average_rating', true);
      $total_reviews = get_post_meta(get_the_ID(), '_wc_review_count', true);
      if ($average_rating) {
        echo '<div class="hmo-rate-block">';
        echo wc_get_rating_html($average_rating, $total_reviews);
        echo '<span>(' . $total_reviews . ')</span>';
        echo '</div>';
      }

      $brands = wp_get_post_terms(get_the_ID(), 'product_brand');
      if ($brands)
        $brand = $brands[0];
      if (!empty($brand)) {
        $thumbnail = get_brand_thumbnail_url($brand->term_id);
        $url = get_term_link($brand->slug, 'product_brand');
        echo '<div class="ht3-brandimg"><a href="' . $url . '"><img class="woocommerce-brand-image-single" src="' . $thumbnail . '"/></a></div>';
      }

      echo '</div>'; // close rating and brand

      // start content scroll to

      echo '<ul class="homeone-stickty-scroll-to">';
      echo '<li><a href="#ast-sticky-row-summary">' . __('Übersicht', 'astra-hometrends') . '</a></li>';
      echo '<li><a href="#tab-description">' . __('Produktdetails', 'astra-hometrends') . '</a></li>';
      echo '<li><a href="#homeone-last-viewed">' . __('Zuletzt angeschaut', 'astra-hometrends') . '</a></li>';
      echo '</ul>';


      echo '</div>'; // close content

      echo '</div>';
      echo '<div class="ast-sticky-add-to-cart-action-wrap">';
      // @codingStandardsIgnoreStart
      /**
       * @psalm-suppress PossiblyNullReference
       * @psalm-suppress PossiblyFalseReference
       */
      if ($product->is_type('simple') || $product->is_type('external') || $product->is_type('subscription')) {
        // @codingStandardsIgnoreEnd
        /** @psalm-suppress PossiblyFalseReference   */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
        echo '<span class="ast-sticky-add-to-cart-action-price price">' . wp_kses_post($product->get_price_html()) . '</span>';
        /** @psalm-suppress PossiblyFalseReference   */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
        echo '<div class="menu-click wishlist_setup">
              <div class="top-wishlist">
                      <a class="text-skin wishlist-icon">
                        ' . do_shortcode("[yith_wcwl_items_count]") . '
                      </a>
              </div>
            </div>';
        if ($add_to_cart_ajax) {
          echo '<div id="sticky-add-to-cart">';
        }
        woocommerce_template_single_add_to_cart();
        if ($add_to_cart_ajax) {
          echo '</div>';
        }
      } else {
        /** @psalm-suppress PossiblyNullReference */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
        echo '<span class="ast-sticky-add-to-cart-action-price price">' . wp_kses_post($product->get_price_html()) . '</span>';

        echo '<div class="menu-click wishlist_setup">
              <div class="top-wishlist">
                      <a class="text-skin wishlist-icon">
                        ' . do_shortcode("[yith_wcwl_items_count]") . '
                      </a>
              </div>
            </div>';

        /** @psalm-suppress InvalidScalarArgument */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
        echo '<a href="#product-' . esc_attr($product->get_ID()) . '" class="single_link_to_cart_button button alt">' . esc_html($product->add_to_cart_text()) . '</a>';
        /** @psalm-suppress InvalidScalarArgument */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
      }

      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }
  }
  if (is_product()) {
    global $product;

    $array_classs = wc_get_product_class('ast-woocommerce-container', $product->get_ID() );

    $array_classs__ = implode(' ',$array_classs);

  ?>
    <script>
      jQuery(document).ready(function($) {


        $("main").contents().unwrap();

        $(".ast-woocommerce-container").wrap('<div class="hometrends-container-1"></div>');

        var container_2 = $("<div>").attr("class", "hometrends-container-2").appendTo("#primary");
        $("#products-slider").appendTo(container_2).wrap("<div class='ast-woocommerce-container'></div>");

        var container_3 = $("<div>").attr("class", "hometrends-container-3").appendTo("#primary");
        $(".ast-woocommerce-accordion").appendTo(container_3).wrap("<div class='<?php echo $array_classs__; ?>'></div>");

        var container_4 = $("<div>").attr("class", "hometrends-container-4").appendTo("#primary");
        $("section.related.products:not([id])").appendTo(container_4).wrap("<div class='ast-woocommerce-container'></div>");


      });
    </script>


<?php
  }
}
