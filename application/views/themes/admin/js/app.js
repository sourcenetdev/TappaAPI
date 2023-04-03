$(document).ready(function(){
    $('body').on('click', '[data-ma-action]', function(e){
        e.preventDefault();
        var $this = $(this);
        var action = $(this).data('ma-action');
        switch (action) {

            /*-------------------------------------------
                Sidebar & Chat Open/Close
            ---------------------------------------------*/
            case 'sidebar-open':
                var target = $this.data('ma-target');
                var backdrop = '<div data-ma-action="sidebar-close" class="ma-backdrop" />';
                $('body').addClass('sidebar-toggled');
                $('#header, #header-alt, #main').append(backdrop);
                $this.addClass('toggled');
                $(target).addClass('toggled');
                break;
            case 'sidebar-close':
                $('body').removeClass('sidebar-toggled');
                $('.ma-backdrop').remove();
                $('.sidebar, .ma-trigger').removeClass('toggled')
                break;

            /*-------------------------------------------
                Profile Menu Toggle
            ---------------------------------------------*/
            case 'profile-menu-toggle':
                $this.parent().toggleClass('toggled');
                $this.next().slideToggle(200);
                break;

            /*-------------------------------------------
                Mainmenu Submenu Toggle
            ---------------------------------------------*/
            case 'submenu-toggle':
                $this.next().slideToggle(200);
                $this.parent().toggleClass('toggled');
                break;

            /*-------------------------------------------
                Fullscreen Browsing
            ---------------------------------------------*/
            case 'fullscreen':
                function launchIntoFullscreen(element) {
                    if (element.requestFullscreen) {
                        element.requestFullscreen();
                    } else if (element.mozRequestFullScreen) {
                        element.mozRequestFullScreen();
                    } else if (element.webkitRequestFullscreen) {
                        element.webkitRequestFullscreen();
                    } else if (element.msRequestFullscreen) {
                        element.msRequestFullscreen();
                    }
                }
                function exitFullscreen() {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    }
                }
                launchIntoFullscreen(document.documentElement);
                break;

            /*-------------------------------------------
                Action Header Open/Close
            ---------------------------------------------*/
            case 'action-header-open':
                ahParent = $this.closest('.action-header').find('.ah-search');
                ahParent.fadeIn(300);
                ahParent.find('.ahs-input').focus();
                break;
            case 'action-header-close':
                ahParent.fadeOut(300);
                setTimeout(function(){
                    ahParent.find('.ahs-input').val('');
                }, 350);
                break;

            /*-------------------------------------------
                Change Header Skin
            ---------------------------------------------*/
            case 'change-skin':
                var skin = $this.data('ma-skin');
                $('[data-ma-theme]').attr('data-ma-theme', skin);
                break;
        }
    });
});

$(document).ready(function () {
    /*-------------------------------------------
        Sparkline
    ---------------------------------------------*/
    function sparklineBar(id, values, height, barWidth, barColor, barSpacing) {
        $('.'+id).sparkline(values, {
            type: 'bar',
            height: height,
            barWidth: barWidth,
            barColor: barColor,
            barSpacing: barSpacing
        })
    }

    function sparklineLine(id, values, width, height, lineColor, fillColor, lineWidth, maxSpotColor, minSpotColor, spotColor, spotRadius, hSpotColor, hLineColor) {
        $('.'+id).sparkline(values, {
            type: 'line',
            width: width,
            height: height,
            lineColor: lineColor,
            fillColor: fillColor,
            lineWidth: lineWidth,
            maxSpotColor: maxSpotColor,
            minSpotColor: minSpotColor,
            spotColor: spotColor,
            spotRadius: spotRadius,
            highlightSpotColor: hSpotColor,
            highlightLineColor: hLineColor
        });
    }

    function sparklinePie(id, values, width, height, sliceColors) {
        $('.'+id).sparkline(values, {
            type: 'pie',
            width: width,
            height: height,
            sliceColors: sliceColors,
            offset: 0,
            borderWidth: 0
        });
    }

    /* Mini Chart - Bar Chart 1 */
    if ($('.stats-bar')[0]) {
        sparklineBar('stats-bar', [6,4,8,6,5,6,7,8,3,5,9,5,8,4], '35px', 3, '#fff', 2);
    }

    /* Mini Chart - Bar Chart 2 */
    if ($('.stats-bar-2')[0]) {
        sparklineBar('stats-bar-2', [4,7,6,2,5,3,8,6,6,4,8,6,5,8], '35px', 3, '#fff', 2);
    }

    /* Mini Chart - Line Chart 1 */
    if ($('.stats-line')[0]) {
        sparklineLine('stats-line', [9,4,6,5,6,4,5,7,9,3,6,5], 68, 35, '#fff', 'rgba(0,0,0,0)', 1.25, 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 3, '#fff', 'rgba(255,255,255,0.4)');
    }

    /* Mini Chart - Line Chart 2 */
    if ($('.stats-line-2')[0]) {
        sparklineLine('stats-line-2', [5,6,3,9,7,5,4,6,5,6,4,9], 68, 35, '#fff', 'rgba(0,0,0,0)', 1.25, 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.4)', 3, '#fff', 'rgba(255,255,255,0.4)');
    }

    /* Mini Chart - Pie Chart 1 */
    if ($('.stats-pie')[0]) {
        sparklinePie('stats-pie', [20, 35, 30, 5], 45, 45, ['#fff', 'rgba(255,255,255,0.7)', 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.2)']);
    }

    /* Dash Widget Line Chart */
    if ($('.dash-widget-visits')[0]) {
        sparklineLine('dash-widget-visits', [9,4,6,5,6,4,5,7,9,3,6,5], '100%', '70px', 'rgba(255,255,255,0.7)', 'rgba(0,0,0,0)', 2, '#fff', '#fff', '#fff', 5, 'rgba(255,255,255,0.4)', 'rgba(255,255,255,0.1)');
    }



    /*-------------------------------------------
        Easy Pie Charts
    ---------------------------------------------*/
    function easyPieChart(id, trackColor, scaleColor, barColor, lineWidth, lineCap, size) {
        $('.'+id).easyPieChart({
            trackColor: trackColor,
            scaleColor: scaleColor,
            barColor: barColor,
            lineWidth: lineWidth,
            lineCap: lineCap,
            size: size
        });
    }

    /* Main Pie Chart */
    if ($('.main-pie')[0]) {
        easyPieChart('main-pie', 'rgba(255,255,255,0.2)', 'rgba(255,255,255,0)', 'rgba(255,255,255,0.7)', 2, 'butt', 148);
    }

    /* Others */
    if ($('.sub-pie-1')[0]) {
        easyPieChart('sub-pie-1', 'rgba(255,255,255,0.2)', 'rgba(255,255,255,0)', 'rgba(255,255,255,0.7)', 2, 'butt', 90);
    }

    if ($('.sub-pie-2')[0]) {
        easyPieChart('sub-pie-2', 'rgba(255,255,255,0.2)', 'rgba(255,255,255,0)', 'rgba(255,255,255,0.7)', 2, 'butt', 90);
    }
});

/*----------------------------------------------------------
    Detect Mobile Browser
-----------------------------------------------------------*/
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
   $('html').addClass('ismobile');
}

$(window).load(function(){

    /*----------------------------------------------------------
        Page Loader
     -----------------------------------------------------------*/
    if (!$('html').hasClass('ismobile')) {
        if($('.page-loader')[0]) {
            setTimeout (function () {
                $('.page-loader').fadeOut();
            }, 500);
        }
    }
});

$(document).ready(function(){

    /*----------------------------------------------------------
        Scrollbar
    -----------------------------------------------------------*/
    function scrollBar(selector, theme, mousewheelaxis) {
        $(selector).mCustomScrollbar({
            theme: theme,
            scrollInertia: 100,
            axis:'yx',
            mouseWheel: {
                enable: true,
                axis: mousewheelaxis,
                preventDefault: true
            }
        });
    }
    if (!$('html').hasClass('ismobile')) {
        if ($('.c-overflow')[0]) {
            scrollBar('.c-overflow', 'minimal-dark', 'y');
        }
    }

    /*----------------------------------------------------------
        Dropdown Menu
    -----------------------------------------------------------*/
    if ($('.dropdown')[0]) {
	    $('body').on('click', '.dropdown.open .dropdown-menu', function(e){
	        e.stopPropagation();
	    });
        $('.dropdown').on('shown.bs.dropdown', function (e) {
            if($(this).attr('data-animation')) {
                $animArray = [];
                $animation = $(this).data('animation');
                $animArray = $animation.split(',');
                $animationIn = 'animated '+$animArray[0];
                $animationOut = 'animated '+ $animArray[1];
                $animationDuration = ''
                if(!$animArray[2]) {
                    $animationDuration = 500; //if duration is not defined, default is set to 500ms
                }
                else {
                    $animationDuration = $animArray[2];
                }

                $(this).find('.dropdown-menu').removeClass($animationOut)
                $(this).find('.dropdown-menu').addClass($animationIn);
            }
        });
        $('.dropdown').on('hide.bs.dropdown', function (e) {
            if($(this).attr('data-animation')) {
                e.preventDefault();
                $this = $(this);
                $dropdownMenu = $this.find('.dropdown-menu');

                $dropdownMenu.addClass($animationOut);
                setTimeout(function(){
                    $this.removeClass('open')
                }, $animationDuration);
            }
        });
    }

    /*----------------------------------------------------------
        Calendar Widget
    -----------------------------------------------------------*/
    if ($('#calendar-widget')[0]) {
        (function(){
            $('#cw-body').fullCalendar({
                contentHeight: 'auto',
                theme: true,
                header: {
                    right: 'next',
                    center: 'title, ',
                    left: 'prev'
                },
                defaultDate: '2016-06-01',
                editable: true,
                events: [
                    {
                        title: 'All Day',
                        start: '2016-06-01',
                        className: 'bgm-cyan'
                    }
                ]
            });
        })();
        var mYear = moment().format('YYYY');
        var mDay = moment().format('dddd, MMM D');
        $('#calendar-widget .cwh-year').html(mYear);
        $('#calendar-widget .cwh-day').html(mDay);
    }

    /*----------------------------------------------------------
        Auto Size Textarea
    -----------------------------------------------------------*/
    if ($('.auto-size')[0]) {
	   autosize($('.auto-size'));
    }

    /*----------------------------------------------------------
        Text Field
    -----------------------------------------------------------*/
    if ($('.fg-line')[0]) {
        $('body').on('focus', '.fg-line .form-control', function() {
            $(this).closest('.fg-line').addClass('fg-toggled');
        })
        $('body').on('blur', '.form-control', function() {
            var p = $(this).closest('.form-group, .input-group');
            var i = p.find('.form-control').val();
            if (p.hasClass('fg-float')) {
                if (i.length == 0) {
                    $(this).closest('.fg-line').removeClass('fg-toggled');
                }
            } else {
                $(this).closest('.fg-line').removeClass('fg-toggled');
            }
        });
    }
    if($('.fg-float')[0]) {
        $('.fg-float .form-control').each(function(){
            var i = $(this).val();
            if (!i.length == 0) {
                $(this).closest('.fg-line').addClass('fg-toggled');
            }
        });
    }

    /*----------------------------------------------------------
        Audio and Video Player
    -----------------------------------------------------------*/
    if($('audio, video')[0]) {
        $('video,audio').mediaelementplayer();
    }

    /*----------------------------------------------------------
        Chosen
    -----------------------------------------------------------*/
    if ($('.chosen')[0]) {
        $('.chosen').chosen({
            width: '100%',
            allow_single_deselect: true
        });
    }

    /*----------------------------------------------------------
        NoUiSlider (Input Slider)
    -----------------------------------------------------------*/
    if ($('#input-slider')[0]) {
        var slider = document.getElementById ('input-slider');
        noUiSlider.create (slider, {
            start: [20],
            connect: 'lower',
            range: {
                'min': 0,
                'max': 100
            }
        });
    }
    if ($('#input-slider-range')[0]) {
        var sliderRange = document.getElementById ('input-slider-range');
        noUiSlider.create (sliderRange, {
            start: [40, 70],
            connect: true,
            range: {
                'min': 0,
                'max': 100
            }
        });
    }
    if ($('#input-slider-value')[0]) {
        var sliderRangeValue = document.getElementById('input-slider-value');
        noUiSlider.create(sliderRangeValue, {
            start: [10, 50],
            connect: true,
            range: {
                'min': 0,
                'max': 100
            }
        });
        sliderRangeValue.noUiSlider.on('update', function( values, handle ) {
            document.getElementById('input-slider-value-output').innerHTML = values[handle];
        });
    }

    /*----------------------------------------------------------
        Input Mask
    -----------------------------------------------------------*/
    if ($('input-mask')[0]) {
        $('.input-mask').mask();
    }

    /*----------------------------------------------------------
        Farbtastic Color Picker
    -----------------------------------------------------------*/
    if ($('.color-picker')[0]) {
	    $('.color-picker').each(function(){
            var colorOutput = $(this).closest('.cp-container').find('.cp-value');
            $(this).farbtastic(colorOutput);
        });
    }


    /*-----------------------------------------------------------
        Summernote HTML Editor
    -----------------------------------------------------------*/
    if ($('.html-editor')[0]) {
	   $('.html-editor').summernote({
            height: 150
        });
    }
    if ($('.html-editor-click')[0]) {
        //Edit
        $('body').on('click', '.hec-button', function(){
            $('.html-editor-click').summernote({
                focus: true
            });
            $('.hec-save').show();
        })
        $('body').on('click', '.hec-save', function(){
            $('.html-editor-click').code();
            $('.html-editor-click').destroy();
            $('.hec-save').hide();
            notify('Content Saved Successfully!', 'success');
        });
    }
    if ($('.html-editor-airmod')[0]) {
        $('.html-editor-airmod').summernote({
            airMode: true
        });
    }

    /*-----------------------------------------------------------
        Date Time Picker
    -----------------------------------------------------------*/
    if ($('.date-time-ss-picker')[0]) {
        $('.date-time-ss-picker').each(function(index){
            var setdate = $(this).val();
            if (setdate == '' || typeof(setdate) == 'undefined') {
                setdate = moment(new Date()).format('YYYY-MM-DD HH:mm:ss');
            }
            if ($(this).hasClass('dp-now')) {
                $('.date-time-ss-picker').datetimepicker({
                    defaultDate: moment(setdate).format('YYYY-MM-DD HH:mm:ss'),
                    minDate: moment(setdate),
                    format: 'YYYY-MM-DD HH:mm:ss'
                });
            } else {
                $('.date-time-ss-picker').datetimepicker({
                    defaultDate: moment(setdate).format('YYYY-MM-DD HH:mm:ss'),
                    format: 'YYYY-MM-DD HH:mm:ss'
                });
            }
        });
    }
    if ($('.date-time-picker')[0]) {
        $('.date-time-picker').each(function(index){
            var setdate = $(this).val();
            if (setdate == '' || typeof(setdate) == 'undefined') {
                setdate = moment(new Date()).format('YYYY-MM-DD HH:mm');
            }
            if ($(this).hasClass('dp-now')) {
                $('.date-time-picker').datetimepicker({
                    defaultDate: moment(setdate).format('YYYY-MM-DD HH:mm'),
                    minDate: moment(setdate),
                    format: 'YYYY-MM-DD HH:mm'
                });
            } else {
                $('.date-time-picker').datetimepicker({
                    defaultDate: moment(setdate).format('YYYY-MM-DD HH:mm'),
                    format: 'YYYY-MM-DD HH:mm'
                });
            }
        });
    }
    if ($('.time-picker')[0]) {
        $('.time-picker').each(function(index){
            var setdate = $(this).val();
            if (setdate == '' || typeof(setdate) == 'undefined') {
                setdate = moment(new Date()).format('HH:mm');
            }
            if ($(this).hasClass('dp-now')) {
                $('.time-picker').datetimepicker({
                    defaultDate: moment(setdate).format('HH:mm'),
                    minDate: moment(setdate),
                    format: 'HH:mm'
                });
            } else {
                $('.time-picker').datetimepicker({
                    defaultDate: moment(setdate).format('HH:mm'),
                    format: 'HH:mm'
                });
            }
        });
    }
    if ($('.time-ss-picker')[0]) {
        $('.time-ss-picker').each(function(index){
            var setdate = $(this).val();
            if (setdate == '' || typeof(setdate) == 'undefined') {
                setdate = moment(new Date()).format('HH:mm:ss');
            }
            if ($(this).hasClass('dp-now')) {
                $('.time-ss-picker').datetimepicker({
                    defaultDate: moment(setdate).format('HH:mm:ss'),
                    minDate: moment(setdate),
                    format: 'HH:mm:ss'
                });
            } else {
                $('.time-ss-picker').datetimepicker({
                    defaultDate: moment(setdate).format('HH:mm:ss'),
                    format: 'HH:mm:ss'
                });
            }
        });
    }
    if ($('.date-picker')[0]) {
        $('.date-picker').each(function(index){
            var setdate = $(this).val();
            var format = $(this).data('date-format');
            if (typeof(format) == 'undefined' || format == '') {
                format = 'YYYY-MM-DD';
            }
            if (setdate == '' || typeof(setdate) == 'undefined') {
                setdate = moment(new Date()).format('YYYY-MM-DD');
            }
            if ($(this).hasClass('dp-now')) {
                $('.date-picker').datetimepicker({
                    defaultDate: moment(setdate).format('YYYY-MM-DD'),
                    minDate: moment(setdate),
                    format: format
                });
            } else {
                $('.date-picker').datetimepicker({
                    defaultDate: moment(setdate).format('YYYY-MM-DD'),
                    format: format
                });
            }
        })
    }
    $('.date-picker').on('dp.hide', function(){
        $(this).closest('.dtp-container').removeClass('fg-toggled');
        $(this).blur();
    })

    /*-----------------------------------------------------------
        Form Wizard
    -----------------------------------------------------------*/
    if ($('.form-wizard-basic')[0]) {
    	$('.form-wizard-basic').bootstrapWizard({
    	    tabClass: 'fw-nav',
            'nextSelector': '.next',
            'previousSelector': '.previous'
    	});
    }

    /*-----------------------------------------------------------
        Waves
    -----------------------------------------------------------*/
    (function(){
         Waves.attach('.btn:not(.btn-icon):not(.btn-float)');
         Waves.attach('.btn-icon, .btn-float', ['waves-circle', 'waves-float']);
        Waves.init();
    })();

    /*----------------------------------------------------------
        Lightbox
    -----------------------------------------------------------*/
    if ($('.lightbox')[0]) {
        $('.lightbox').lightGallery({
            enableTouch: true
        });
    }

    /*-----------------------------------------------------------
        Link prevent
    -----------------------------------------------------------*/
    $('body').on('click', '.a-prevent', function(e){
        e.preventDefault();
    });

    /*----------------------------------------------------------
        Bootstrap Accordion Fix
    -----------------------------------------------------------*/
    if ($('.collapse')[0]) {
        $('.collapse').on('show.bs.collapse', function (e) {
            $(this).closest('.panel').find('.panel-heading').addClass('active');
        });
        $('.collapse').on('hide.bs.collapse', function (e) {
            $(this).closest('.panel').find('.panel-heading').removeClass('active');
        });
        $('.collapse.in').each(function(){
            $(this).closest('.panel').find('.panel-heading').addClass('active');
        });
    }

    /*-----------------------------------------------------------
        Tooltips
    -----------------------------------------------------------*/
    if ($('[data-toggle="tooltip"]')[0]) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    /*-----------------------------------------------------------
        Popover
    -----------------------------------------------------------*/
    if ($('[data-toggle="popover"]')[0]) {
        $('[data-toggle="popover"]').popover();
    }

    /*-----------------------------------------------------------
        IE 9 Placeholder
    -----------------------------------------------------------*/
    if($('html').hasClass('ie9')) {
        $('input, textarea').placeholder({
            customClass: 'ie9-placeholder'
        });
    }
});
