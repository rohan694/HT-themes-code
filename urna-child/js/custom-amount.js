jQuery(document).ready(function() {
	//alert('loaded');
	var amt = jQuery('.whilist_price');
	var counter = jQuery('.count_wishlist');
	 jQuery.ajax({
		  
		   dataType: "json",
        url: my_ajax_object.ajax_url,
        data: {
			
          action: 'urna_yith_wcwl_ajax_pageload_update_amount'
        },       
            
           success: function(msg){
			 
       counter.html(msg.cnt);
			    amt.html(msg.tot_amount);
    }
		});
});
jQuery(document).on( 'yith_wcwl_init', function(){
 

       var t = jQuery(this);

        t.on( 'click', '.add_to_wishlist', function( ev ) {
			 var t = jQuery(this);
            product_id = t.attr( 'data-product-id' );
			var counter = jQuery('.whilist_price');
			
      jQuery.ajax({
		    type: "post",
		   dataType: "json",
        url: my_ajax_object.ajax_url,
        data: {
			product_id:product_id,
          action: 'urna_yith_wcwl_ajax_update_amount'
        },       
            
           success: function(msg){
			 
       counter.html(msg.tot_amount);
    }
		});
            
        });
	
	
			
			  t.on( 'click', '.delete_item', function( ev ) {
     
   
	 var t = jQuery(this);
            product_did = t.attr( 'data-product-id' );
			var counter = jQuery('.whilist_price');
      jQuery.ajax({
		    type: "post",
		   dataType: "json",
        url: my_ajax_object.ajax_url,
        data: {
			product_did:product_did,
          action: 'urna_yith_wcwl_ajax_update_amount'
        },       
            
           success: function(msg){
			
       counter.html(msg.tot_amount);
    }
            
        
      });
    });
	
	  t.on( 'click', '.remove_from_wishlist', function( ev ) {
     
   
	 var t = jQuery(this);
		   var trid = jQuery(this).closest('tr,li').attr('data-row-id'); // table row ID 
		
			var counter = jQuery('.whilist_price');
      jQuery.ajax({
		    type: "post",
		   dataType: "json",
        url: my_ajax_object.ajax_url,
        data: {
			product_did:trid,
          action: 'urna_yith_wcwl_ajax_update_amount'
        },       
            
           success: function(msg){
			
       counter.html(msg.tot_amount);
    }
            
        
      });
    });
    
	});

 jQuery('.top-wishlist').click(function(){
	    
       jQuery.ajax({
		    type: "post",
		   dataType: "json",
        url: my_ajax_object.ajax_url,
        
        data: {
          action: 'wishlist_total_shortcode_ajax'
        },
      		  
        success: function (data) {
			console.log(data.count);
			
			jQuery('.header_wistlist_products').html(data.count);
         
			
        }
       
      });
	
    });

jQuery('.device-wishlist').click(function(){
	    
       jQuery.ajax({
		    type: "post",
		   dataType: "json",
        url: my_ajax_object.ajax_url,
        
        data: {
          action: 'wishlist_total_shortcode_ajax'
        },
      		  
        success: function (data) {
			console.log(data.count);
			
			jQuery('.header_wistlist_products').html(data.count);
         
			
        }
       
      });
	
    });