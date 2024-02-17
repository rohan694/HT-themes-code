jQuery(document).ready(function ($) {

   /***
    * Hometrends Elementor js Functions
    */



   $(document).ready(function () {

      jQuery(document).on('click', '.hometrends-child-tabs a', function (e) {


         let current_obj = jQuery(this);
         let cat_id = jQuery(this).attr('data-target');
         let cat_type = jQuery(this).attr('data-type');

         let settings = jQuery('.hometrends-tabs-wrap').attr('data-par-id');

         //let parent_ul = jQuery(this).parent().parent();
         //jQuery(parent_ul).children('li').removeClass('active');

         if (current_obj.parent().hasClass('active')) {
            current_obj.parent().removeClass('active');
         } else {
            current_obj.parent().addClass('active');
         }


         var activeListItems = jQuery('.hometrends-child-tabs ul li.active');
         var parentItem = $(this).closest('.hometrends-tabs-wrap').data('parent-id');
         var dataTargets = [];

         activeListItems.each(function () {
            var dataTarget = $(this).find('a').data('target');
            dataTargets.push(dataTarget);
         });

         if (dataTargets.length === 0) {
            dataTargets.push(parentItem);
         }


         var commaSeparatedValues = dataTargets.join(',');

         jQuery('.hometrends-tabs-content').html('<div class="overlay"><div class="overlay__inner"><div class="overlay__content"><span class="spinner"></span></div></div></div>');

         let ajax_url = hometrends_globals.ajax_url;

         var request = $.ajax({
            url: ajax_url,
            method: "POST",
            data: {
               action: 'hometrends_load_cat_products',
               type: cat_type,
               cat_id: commaSeparatedValues
            },
            dataType: "json"
         });
         request.done(function (response) {

            if (cat_type !== 'undefined' && cat_type == 'parent') {
               jQuery('.hometrends-child-tabs').html(response.child_list);
            }

            jQuery('.hometrends-tabs-content').html(response.content);

            return false;

         });
      });


      $(".homeone-mbl-dropdown button").click(function () {
         $(".popup").fadeIn(500);

      });
      $(".hometrends-popup-wrap .close").click(function () {
         $(".popup").fadeOut(500);
      });



   });


});