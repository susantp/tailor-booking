

jQuery(document).ready(function ($) {
    // wow animation
    function wowAnimation() {
        wow = new WOW({
            boxClass: 'wow',      // default
            animateClass: 'animated', // default
            offset: 0,          // default
            mobile: true,       // default
            live: true        // default
        })
        wow.init();
    }
    //Dropdown Menu
    function dropdownMenu() {
        if ($(window).width() >= 992) {
            $('.navbar .menu-item-has-children, .navbar .dropdown').hover(function () {
                $(this).find('.sub-menu, .dropdown-menu').first().stop(true, true).delay(250).slideDown();

            }, function () {
                $(this).find('.sub-menu, .dropdown-menu').first().stop(true, true).delay(100).slideUp();

            });
        }
        $('.navbar .dropdown > a').click(function () {
            location.href = this.href;
        });
    }
    // 
    function handleNavbarToggler() {
        $('body').on('click', '.navbar-toggler', function () {
            $(this).toggleClass('on');
            $('.navbar-collapse').toggleClass('shown');
            $('.navbar-collapse').slideToggle();
            $('.navbar').toggleClass('open');
        });
    }
    //
    function dropToggler() {
        $('.menu-item-has-children, .dropdown').prepend('<span class="drop-toggler"><i class="fa fa-chevron-down"></i></span>');
        $('body').on('click', '.drop-toggler', function () {
            $(this).parents('.menu-item-has-children, .dropdown').find('.sub-menu, .dropdown-menu').slideToggle();
            $(this).toggleClass('open');
        });
    }
    //
    function matchHeights() {
        var options = {
            byRow: false,
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        };
        $('.product__info, .support__info').matchHeight(options);
        $('.section-news .news__info').matchHeight(options);
    }
    //
    function mainSlider() {
        $('.hero__slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: false,
            dots: false,
            fade: true,
            speed: 2500,
            cssEase: 'ease-in-out'

        });
        // 
        $('.product-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 5000,
            arrows: true,
            dots: false,
            responsive: [
                {
                  breakpoint: 1200,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 992,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                  }
                },
                {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 2,
                      slidesToScroll: 1
                    }
                  },
                {
                  breakpoint: 415,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }

              ]
            
        });

        // brand slider

        $('.brand-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 5000,
            arrows: true,
            dots: false,
            responsive: [
                {
                  breakpoint: 1200,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 992,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                  }
                },
                {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 2,
                      slidesToScroll: 1
                    }
                  },
                {
                  breakpoint: 415,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }

              ]
            
        });

        // single page slider

        $('.slider-lg').slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: true,
          fade: false,
          asNavFor: '.slider-thumb',
        });
       
        $('.slider-thumb').slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          asNavFor: '.slider-lg',
          dots: false,
          focusOnSelect: true
        });

    }
    // img tags converted to svg

    function imgToSvg() {
        $("img.svg").each(function () {
            //console.log('gdg');
            var $img = $(this);
            var imgID = $img.attr("id");
            var imgClass = $img.attr("class");
            var imgURL = $img.attr("src");
            $.get(
                imgURL,
                function (data) {
                    // Get the SVG tag, ignore the rest
                    var $svg = $(data).find("svg");
                    // Add replaced image's ID to the new SVG
                    if (typeof imgID !== "undefined") {
                        $svg = $svg.attr("id", imgID);
                    }
                    // Add replaced image's classes to the new SVG
                    if (typeof imgClass !== "undefined") {
                        $svg = $svg.attr("class", imgClass + " replaced-svg");
                    }
                    // Remove any invalid XML tags as per http://validator.w3.org
                    $svg = $svg.removeAttr("xmlns:a");
                    // Replace image with new SVG
                    $img.replaceWith($svg);
                },
                "xml"
            );
        });
    }

    // call functions
    wowAnimation();
    dropdownMenu();
    imgToSvg();
    handleNavbarToggler();
    dropToggler();
    matchHeights();
    mainSlider();

    $(window).on('resize', function() {
        dropdownMenu();
        dropToggler();
    });


});






