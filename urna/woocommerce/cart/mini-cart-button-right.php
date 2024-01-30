<?php
    global $woocommerce;
    $_id = urna_tbay_random_key();
    
    extract($args);

    $data_dropdown = ( is_checkout() || is_cart() ) ? '' : 'data-offcanvas="offcanvas-right" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0"';
?>
<div class="tbay-topcart">
 <div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown dropdown">
        <a class="dropdown-toggle mini-cart v2" <?php echo $data_dropdown; ?> href="<?php echo ( is_checkout() ) ? wc_get_cart_url() : 'javascript:void(0);'; ?>" title="<?php esc_attr_e('View your shopping cart', 'urna'); ?>">
			<?php  urna_tbay_minicart_button($icon_array, $show_title_mini_cart, $title_mini_cart, $price_mini_cart, $active_elementor_minicart); ?>
        </a>            
    </div>
</div>    

<?php 
    if( !is_checkout() && !is_cart() ) {
        urna_tbay_get_page_templates_parts('offcanvas-cart', 'right');
    }
?>