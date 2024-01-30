<?php

   $icon 			= 'https://hometrends.one/wp-content/uploads/2023/06/HomeTrends-Heart-Vector.svg';

    $enable_text 	= urna_tbay_get_config('enable_woo_wishlist_text', true);
    $text 			= urna_tbay_get_config('woo_wishlist_text', esc_html__('My Wishlist', 'urna'));

?>

<?php if (class_exists('YITH_WCWL')) { ?>
<div class="top-wishlist">
	<a class="text-skin wishlist-icon" href="<?php $wishlist_url = YITH_WCWL()->get_wishlist_url(); echo esc_url($wishlist_url); ?>">
	<?php if (!empty($icon)) : ?>
    <img src="<?php echo esc_url($icon); ?>" alt="wishlist-icon" />
<?php endif; ?>
	<span class="count_wishlist"><?php $wishlist_count = YITH_WCWL()->count_products(); echo esc_html($wishlist_count);  ?></span>
	<?php
        if (isset($enable_text) && $enable_text) {
            echo '<span class="text">'. trim($text) . '</span>';
        }
    ?>
	</a>
</div>
<div class="Wishlist_main_top"><div class="header_wistlist_products ">

<?php //echo do_shortcode( '[wishlist_total_shortcode]' ); 
						 
       $variable = YITH_WCWL()->get_products( [ 'wishlist_id' => 'all' ] );
		$nm_wishlist_ids = array();
		foreach ($variable as $key => $value) {
			 $the_product = wc_get_product($value->get_product_id());
             $product_price += $the_product->get_price();
		}
	?></div>
<div class="whilist_price_Section">
	<h4 class="whilist_price_heading"><?php echo esc_html__('Wunschliste') ?>	
	</h4>
	<div class="whilist_price_tab">
		<?php if ( $product_price ) { 
            $total_price_whil = $product_price;
        }else{
		 $total_price_whil = '0.00';
     	}
		 $total_price_whil =	number_format($total_price_whil, 2, '.', ',');
		?>
		<span class="whilist_price"><?php echo  $total_price_whil; ?></span><span class="whilist_price_symbol"><?php echo get_woocommerce_currency_symbol(); ?></span>
	</div>
</div>
</div>
<?php } 