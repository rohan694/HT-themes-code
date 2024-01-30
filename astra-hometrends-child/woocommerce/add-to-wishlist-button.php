<?php
/**
 * Add to wishlist button template
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Wishlist\Templates\AddToWishlist
 * @version 3.0.12
 */

/**
 * Template variables:
 *
 * @var $base_url string Current page url
 * @var $wishlist_url              string Url to wishlist page
 * @var $exists                    bool Whether current product is already in wishlist
 * @var $show_exists               bool Whether to show already in wishlist link on multi wishlist
 * @var $show_count                bool Whether to show count of times item was added to wishlist
 * @var $product_id                int Current product id
 * @var $parent_product_id         int Parent for current product
 * @var $product_type              string Current product type
 * @var $label                     string Button label
 * @var $browse_wishlist_text      string Browse wishlist text
 * @var $already_in_wishslist_text string Already in wishlist text
 * @var $product_added_text        string Product added text
 * @var $icon                      string Icon for Add to Wishlist button
 * @var $link_classes              string Classed for Add to Wishlist button
 * @var $available_multi_wishlist  bool Whether add to wishlist is available or not
 * @var $disable_wishlist          bool Whether wishlist is disabled or not
 * @var $template_part             string Template part
 * @var $container_classes         string Container classes
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

global $product;
$unique_id = wp_rand();
?>

<div class="yith-wcwl-add-button modelpopps">
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
	<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'add_to_wishlist', $product_id, $base_url ), 'add_to_wishlist' ) ); ?>"
		class="<?php echo esc_attr( $link_classes ); ?>"
		data-product-id="<?php echo esc_attr( $product_id ); ?>"
		data-product-type="<?php echo esc_attr( $product_type ); ?>"
		data-original-product-id="<?php echo esc_attr( $parent_product_id ); ?>"
		data-title="<?php echo esc_attr( apply_filters( 'yith_wcwl_add_to_wishlist_title', $label ) ); ?>"
		openmobel="#add_to_wishlist_popup_<?php echo esc_attr( $product_id ); ?>_<?php echo esc_attr( $unique_id ); ?>"
		rel="nofollow"
	>
		<?php echo yith_wcwl_kses_icon( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<span><?php echo wp_kses_post( $label ); ?></span>
	</a>

	<!-- WISHLIST POPUP -->
	<div id="add_to_wishlist_popup_<?php echo esc_attr( $product_id ); ?>_<?php echo esc_attr( $unique_id ); ?>" class="yith-wcwl-popup">
        <div class="body_iner_posrt">         
		 <h3><?php echo esc_html( $popup_title );  ?></h3>
			<select  class="change_wishlist_select change-wishlists selectBox" value="" id="addwishlist_popup_<?php echo esc_attr( $product_id ); ?>_<?php echo esc_attr( $unique_id ); ?>" onchange="loadDynamicDdl('#addwishlist_popup_<?php echo esc_attr( $product_id ); ?>_<?php echo esc_attr( $unique_id ); ?>');" openmodel="add_to_wishlist_popup_<?php echo esc_attr( $product_id ); ?>_<?php echo esc_attr( $unique_id ); ?>" product_id="<?php echo $product_id;  ?>" wishlist_id="<?php echo $wishlist['id'] ?>" arrdeo="">
				<option value="">Select Wishlist</option>
				<option value="Decor" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Decor'){ echo 'selected'; } } ?>>Decor</option>
				<option value="Wohnzimmer" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Wohnzimmer'){ echo 'selected'; } } ?>>Wohnzimmer</option>
				<option value="Badezimmer" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Badezimmer'){ echo 'selected'; } } ?>>Badezimmer</option>
				<option value="Kinderzimmer" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Kinderzimmer'){ echo 'selected'; } } ?>>Kinderzimmer</option>
				<option value="Schlafzimmer" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Schlafzimmer'){ echo 'selected'; } } ?>>Schlafzimmer</option>
				<option value="Draußen" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Draußen'){ echo 'selected'; } } ?>>Draußen</option>
				<option value="Küche" <?php if(!empty($wishlistold)){ if($wishlistold[0]->wishlist_name == 'Küche'){ echo 'selected'; } } ?>>Küche</option> 
			</select> 
			<script type="text/javascript">
               function loadDynamicDdl(ddlId) {
				   var currentwishlist = jQuery(ddlId).val();
				   var product_id = jQuery(ddlId).attr('product_id');
				   var user_id = <?php echo get_current_user_id(); ?>;
				   var wishlist_id = jQuery(ddlId).attr('wishlist_id');
				   jQuery.ajax({ 
					  url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
					  type:"POST",
					  dataType:"json",
					  data: {
						 action:'change_wishlist_selected',
						 wishlist:currentwishlist,
						 product_id:product_id,
						 user_id:user_id,
						 wishlist_id:wishlist_id,
					},   success: function(response){
						location.reload(true);
						$("#add_to_wishlist_popup_<?php echo esc_attr( $product_id ); ?>_<?php echo esc_attr( $unique_id ); ?>").hide();
						$(".modelpopps a[data-product-id='"+response.prod_id+"']").html('<i class="yith-wcwl-icon fa fa-heart"></i>		<span>Add to wishlist</span>');
						 
					     var response_result = response.result,
                        response_message = response.message;
                    if( yith_wcwl_l10n.multi_wishlist ) {
                        // close PrettyPhoto popup
                        close_pretty_photo( response_message, response_result );
                        // update options for all wishlist selects
                        if( typeof( response.user_wishlists ) !== 'undefined' ) {
                            update_wishlists( response.user_wishlists );
                        }
                    }
                    else {
                        print_message(response_message);
                    }

                    if( response_result === 'true' || response_result === 'exists' ) {
                        if( typeof response.fragments !== 'undefined' ) {
                            replace_fragments(response.fragments); 
                        }

                        if( ! yith_wcwl_l10n.multi_wishlist || yith_wcwl_l10n.hide_add_button ) {
                            //el_wrap.find('.yith-wcwl-add-button').remove();
                        }

                        el_wrap.addClass('exists');
                    } 

                    init_handling_after_ajax();

                    $('body').trigger('added_to_wishlist', [ t, el_wrap ] );
					
					 }, error: function(data){
						 jQuery(".error_msg").css("display","block");      }
				   });
				  }
		    function print_message( response_message ) {
        var msgPopup = $( '#yith-wcwl-popup-message' ),
            msg = $( '#yith-wcwl-message' ),
            timeout = typeof yith_wcwl_l10n.popup_timeout !== 'undefined' ? yith_wcwl_l10n.popup_timeout : 3000;

        if( typeof yith_wcwl_l10n.enable_notices !== 'undefined' && ! yith_wcwl_l10n.enable_notices ){
            return;
        }

        msg.html( response_message );
        msgPopup.css( 'margin-left', '-' + $( msgPopup ).width() + 'px' ).fadeIn();
        window.setTimeout( function() {
            msgPopup.fadeOut();
        }, timeout );
    }
	    function replace_fragments( fragments ) {
       $.each( fragments, function( i, v ){
           var itemSelector = '.' + i.split( yith_wcwl_l10n.fragments_index_glue ).filter( ( val ) => { return val.length && val !== 'exists' && val !== 'with-count'; } ).join( '.' ),
               toReplace = $( itemSelector );

           // find replace tempalte
           var replaceWith = $(v).filter( itemSelector );

           if( ! replaceWith.length ){
               replaceWith = $(v).find( itemSelector );
           }

           if( toReplace.length && replaceWith.length ){
               toReplace.replaceWith( replaceWith );
           }
       } ) ;
    }
		</script>
	</div>
	</div>
</div>
