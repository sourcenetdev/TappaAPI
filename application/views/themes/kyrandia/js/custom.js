jQuery(document).ready(function($) {

    // Date-time picker
    if ($('.date-time-ss-picker')[0]) {
        $('.date-time-ss-picker').each(function(index){
            if ($(this).hasClass('dp-now')) {
                $('.date-time-ss-picker').datetimepicker({
                    minDate: moment(),
                    format: 'YYYY-MM-DD HH:mm:ss'
                });
            } else {
                $('.date-time-ss-picker').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm:ss'
                });
            }
        });
    }

    if ($('.date-time-picker')[0]) {
        $('.date-time-picker').each(function(index){
            if ($(this).hasClass('dp-now')) {
                $('.date-time-picker').datetimepicker({
                    minDate: moment(),
                    format: 'YYYY-MM-DD HH:mm'
                });
            } else {
                $('.date-time-picker').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm'
                });
            }
        });
    }

    //Time
    if ($('.time-picker')[0]) {
        $('.time-picker').each(function(index){
            if ($(this).hasClass('dp-now')) {
                $('.time-picker').datetimepicker({
                    minDate: moment(),
                    format: 'HH:mm'
                });
            } else {
                $('.time-picker').datetimepicker({
                    format: 'HH:mm'
                });
            }
        });
    }

    if ($('.time-ss-picker')[0]) {
        $('.time-ss-picker').each(function(index){
            if ($(this).hasClass('dp-now')) {
                $('.time-ss-picker').datetimepicker({
                    minDate: moment(),
                    format: 'HH:mm:ss'
                });
            } else {
                $('.time-ss-picker').datetimepicker({
                    format: 'HH:mm:ss'
                });
            }
        });
    }

    //Date
    if ($('.date-picker')[0]) {
        $('.date-picker').each(function(index){
            if ($(this).hasClass('dp-now')) {
                $('.date-picker').datetimepicker({
                    minDate: moment(),
                    format: 'YYYY-MM-DD'
                });
            } else {
                $('.date-picker').datetimepicker({
                    format: 'YYYY-MM-DD'
                });
            }
        })
    }

    // Preloader
    $(window).on('load', function() {
        $('#preloader').delay(100).fadeOut('slow', function() {
            $(this).remove();
        });
    });

    if ($('.collapse')[0]) {

        // Add active class for opened items
        $('.collapse').on('show.bs.collapse', function (e) {
            $(this).closest('.panel').find('.panel-heading').addClass('active');
        });

        $('.collapse').on('hide.bs.collapse', function (e) {
            $(this).closest('.panel').find('.panel-heading').removeClass('active');
        });

        // Add active class for pre opened items
        $('.collapse.in').each(function(){
            $(this).closest('.panel').find('.panel-heading').addClass('active');
        });
    }

    // Mobile Navigation
    if ($('#nav-menu-container').length) {
        var $mobile_nav = $('#nav-menu-container').clone().prop({ id: 'mobile-nav'});
        $mobile_nav.find('> ul').attr({'class': '', 'id': '' });
        $('body').append($mobile_nav);
        $('body').prepend('<button type="button" id="mobile-nav-toggle"><i class="fa fa-bars"></i></button>');
        $('body').append('<div id="mobile-body-overly"></div>');
        $('#mobile-nav').find('.menu-has-children').prepend('<i class="fa fa-chevron-down"></i>');
        $(document).on('click', '.menu-has-children i', function(e) {
            $(this).next().toggleClass('menu-item-active');
            $(this).nextAll('ul').eq(0).slideToggle();
            $(this).toggleClass("fa-chevron-up fa-chevron-down");
        });
        $(document).on('click', '#mobile-nav-toggle', function(e){
            $('body').toggleClass('mobile-nav-active');
            $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
            $('#mobile-body-overly').toggle();
        });
        $(document).click(function (e) {
            var container = $("#mobile-nav, #mobile-nav-toggle");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                if ( $('body').hasClass('mobile-nav-active') ) {
                    $('body').removeClass('mobile-nav-active');
                    $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
                    $('#mobile-body-overly').fadeOut();
                }
            }
        });
    } else if ($("#mobile-nav, #mobile-nav-toggle").length) {
        $("#mobile-nav, #mobile-nav-toggle").hide();
    }

    // Stick the header at top on scroll
    $("#header").sticky({
        topSpacing: 0,
        zIndex: '50'
    });

    // Smooth scroll on page hash links
    $('a[href*="#"]').on('click', function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            if (target.length) {
                var top_space = 0;
                if ($('#header').length) {
                    top_space = $('#header').outerHeight();
                }
                $('html, body').animate({
                    scrollTop: target.offset().top - top_space
                }, 1500, 'easeInOutExpo');
                if ($(this).parents('.nav-menu').length) {
                    $('.nav-menu .menu-active').removeClass('menu-active');
                    $(this).closest('li').addClass('menu-active');
                }
                if ($('body').hasClass('mobile-nav-active')) {
                    $('body').removeClass('mobile-nav-active');
                    $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
                    $('#mobile-body-overly').fadeOut();
                }
                location.href = this.href;
                return false;
            }
        }
    });

    // Back to top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 1500, 'easeInOutExpo');
        return false;
    });
});
