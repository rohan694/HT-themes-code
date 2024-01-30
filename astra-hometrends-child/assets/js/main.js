jQuery(document).ready(function ($) {



    // Triggers sticky add to cart on scroll.
    const astraStickyAddToCart = document.querySelector(".ast-sticky-add-to-cart");

    if (astraStickyAddToCart) {


        let scrollOffset = document.querySelector('.hometrends-container-2').offsetTop - 30;


        window.addEventListener("scroll", function () {

            if (window.scrollY >= scrollOffset) {
                astraStickyAddToCart.classList.add('is-active');
            } else {
                astraStickyAddToCart.classList.remove('is-active');
            }
        });

    }

    // Smooth scrolls if select option button is active.
    const AstraSmoothScrollBtn = document.querySelector(".ast-sticky-add-to-cart-action-wrap .single_link_to_cart_button");
    const element = document.querySelector(".single_add_to_cart_button");

    if (AstraSmoothScrollBtn && element) {
        const headerOffset = 230;
        const elementPosition = element.getBoundingClientRect().top;
        if (elementPosition) {
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            if (offsetPosition) {
                AstraSmoothScrollBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                });
            }
        }
    }








    /**
     * Related Products
     */

    if (jQuery('.hometrendsone-related-prod').length > 0) {


        var home_trends = new Swiper(".hometrendsone-related-prod", {
            slidesPerView: 4,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                576: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
            },
        });


    }


    if (jQuery('body.single-product').length > 0) {

        jQuery('.related.products:eq(1)').attr('id', 'homeone-last-viewed');


        jQuery('.homeone-stickty-scroll-to a').on('click', function (event) {
            if (this.hash !== "") {
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Animate smooth scroll
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function () {
                    // Add hash to URL after scrolling
                    window.location.hash = hash;
                });
            }
        });


    }

    // $('#related_product_slider').slick({
    //     arrows: true,
    //     vertical: false,
    //     slide: 'li',
    //     slidesToShow: 4,
    //     slidesToScroll: 1,
    //     adaptiveHeight: true,
    //     variableWidth: true,
    //     /*prevArrow: $('.ca_goUp'),
    //     nextArrow: $('.ca_goDown'),*/
    //     infinite: false,
    // });
});

/*
jQuery(document).ready(function($){
    function start_slick(){
        $('#related_product_slider').slick({
            arrows: false,
            vertical: false,
            slide: 'li',
            slidesToShow:3,
            slidesToScroll:1,
            /!*prevArrow: $('.ca_goUp'),
            nextArrow: $('.ca_goDown'),*!/
            infinite:false,
        });
    }
    window.setTimeout( start_slick, 2000 );
});*/
