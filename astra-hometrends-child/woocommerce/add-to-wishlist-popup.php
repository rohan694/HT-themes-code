<?php
/**
 * Add to wishlist popup template
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Wishlist\Templates\AddToWishlist
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $base_url                  string Current page url
 * @var $lists                     YITH_WCWL_Wishlist[]
 * @var $show_exists               bool Whether to show Exists message or not
 * @var $product_id                int Current product id
 * @var $parent_product_id         int Parent for current product
 * @var $show_count                bool Whether to show count of times item was added to wishlist
 * @var $exists                    bool Whether the product is already in list
 * @var $already_in_wishslist_text string Already in wishlist message
 * @var $browse_wishlist_text      string Browse wishlist message
 * @var $wishlist_url              string View wishlist url
 * @var $link_classes              string Classes for the Add to Wishlist link
 * @var $link_popup_classes        string Classes for Open Add to Wishlist Popup link
 * @var $label_popup               string Label for Open Add to Wishlist Popup link
 * @var $popup_title               string Popup title
 * @var $product_image             string Product image url (not is use)
 * @var $icon                      string Icon HTML tag
 * @var $heading_icon              string Heading icon HTML tag
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

$unique_id = wp_rand();
?>

<div class="yith-wcwl-add-button">
	<!-- WISHLIST POPUP OPENER -->
	<?php
	/**
	 * APPLY_FILTERS: yith_wcwl_add_to_wishlist_title
	 *
	 * Filter the 'Add to wishlist' label.
	 *
	 * @param string $label Label
	 *
	 * @return string
	 */
	?>
	<a
		href="#add_to_wishlist_popup_<?php echo esc_attr( $product_id ); ?>_<?php echo esc_attr( $unique_id ); ?>"
		class="<?php echo esc_attr( $link_classes ); ?>"
		data-product-id="<?php echo esc_attr( $product_id ); ?>"
		data-product-type="<?php echo esc_attr( $product_type ); ?>"
		data-original-product-id="<?php echo esc_attr( $parent_product_id ); ?>"
		data-title="<?php echo esc_attr( apply_filters( 'yith_wcwl_add_to_wishlist_title', $label ) ); ?>"
		open-pretty-photo" data-rel="prettyPhoto[add_to_wishlist_<?php echo esc_attr( $product_id ); ?>_<?php echo esc_attr( $unique_id ); ?>]"
		rel="nofollow"
	>
		<?php echo yith_wcwl_kses_icon( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<span><?php echo wp_kses_post( $label ); ?></span>
	</a>

	<!-- WISHLIST POPUP -->
	<div id="add_to_wishlist_popup_<?php echo esc_attr( $product_id ); ?>_<?php echo esc_attr( $unique_id ); ?>" class="yith-wcwl-popup">
           <h3><?php echo esc_html( $popup_title ); ?></h3>
			<select  class="change_wishlist_select<?php echo $wishlist['id'] ?> change-wishlists selectBox" product_id="<?php echo $product_id;  ?>" wishlist_id="<?php echo $wishlist['id'] ?>">
			   
				<option value="Dekorationen" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Dekorationen'){ echo 'selected'; } } ?>>Dekorationen</option>
				<option value="Wohnzimmer" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Wohnzimmer'){ echo 'selected'; } } ?>>Wohnzimmer</option>
				<option value="Badezimmer" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Badezimmer'){ echo 'selected'; } } ?>>Badezimmer</option>
				<option value="Schlafzimmer" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Schlafzimmer'){ echo 'selected'; } } ?>>Schlafzimmer</option>
				<option value="Küche" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Küche'){ echo 'selected'; } } ?>>Küche</option> 
				<option value="Kinderzimmer" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Kinderzimmer'){ echo 'selected'; } } ?>>Kinderzimmer</option>
				<option value="Draußen" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Draußen'){ echo 'selected'; } } ?>>Draußen</option>
				
			</select>
			<script type="text/javascript">
				jQuery(document).ready(function($){
				jQuery(".change_wishlist_select<?php echo $wishlist['id'] ?>").on('change', function(e){
				   e.preventDefault();
				   var currentwishlist = jQuery(this).val();
				   var product_id = jQuery(this).attr('product_id');
				   var user_id = <?php echo get_current_user_id(); ?>;
				   var wishlist_id = jQuery(this).attr('wishlist_id');
				   jQuery.ajax({
					  url: "/wp-admin/admin-ajax.php",
					  type:"POST",
					  dataType:"type",
					  data: {
						 action:'change_wishlist_selected',
						 wishlist:currentwishlist,
						 product_id:product_id,
						 user_id:user_id,
						 wishlist_id:wishlist_id,
					},   success: function(response){
					   jQuery(".success_msg").css("display","block");
					 }, error: function(data){
						 jQuery(".error_msg").css("display","block");      }
				   });
				  });
				});
				</script>
	</div>
</div>
