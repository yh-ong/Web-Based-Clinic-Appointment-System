(function($) {
    "use strict";

    /*================================
    Preloader
    ==================================*/
    // $(window).on('load', function () {
    //     $('#preloader').fadeOut('slow', function () {
    //         $(this).remove();
    //     });
    // });

    // $(window).on('load', function () {
    //     $('#load-bar').fadeOut('slow', function () {
    //         $(this).remove();
    //     });
    // });

    // window.addEventListener('load', () => {
    //     const loader = document.getElementById('loader');
    //     setTimeout(() => {
    //       loader.classList.add('fadeOut');
    //     }, 300);
    //   });

    /*================================
    sidebar collapsing
    ==================================*/
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
    });

    /*================================
    Start Footer resizer
    ==================================*/
    var e = function() {
        var e = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 5;
        (e -= 67) < 1 && (e = 1), e > 67 && $(".main-content").css("min-height", e + "px")
    };
    $(window).ready(e), $(window).on("resize", e);

    /*================================
    sidebar menu
    ==================================*/
    $("#metismenu").metisMenu();

    /*================================
    slimscroll activation
    ==================================*/
    // $('.menu-inner').slimScroll({
    //     height: 'auto'
    // });
    // $('.nofity-list').slimScroll({
    //     height: '435px'
    // });
    // $('.timeline-area').slimScroll({
    //     height: '500px'
    // });
    // $('.recent-activity').slimScroll({
    //     height: 'calc(100vh - 114px)'
    // });
    // $('.settings-list').slimScroll({
    //     height: 'calc(100vh - 158px)'
    // });

    /*================================
    stickey Header
    ==================================*/
    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop(),
            mainHeader = $('#sticky-header'),
            mainHeaderHeight = mainHeader.innerHeight();

        // console.log(mainHeader.innerHeight());
        if (scroll > 1) {
            $("#sticky-header").addClass("sticky-menu");
        } else {
            $("#sticky-header").removeClass("sticky-menu");
        }
    });

    /*================================
    form bootstrap validation
    ==================================*/
    $('[data-toggle="popover"]').popover()

    /*------------- Start form Validation -------------*/
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
    
    /*================================
    select with search form
    ==================================*/
    // $(function () {
    //     $('select').selectpicker();
    // });
    
    /*================================
    datepicker
    ==================================*/
    $('#datepicker').datetimepicker({
        format: 'YYYY-MM-DD',
    });

    /*================================
    datatable active
    ==================================*/
    $('#datatable').DataTable({
        responsive: true
    });

    /*================================
    Slicknav mobile menu
    ==================================*/
    // $('ul#nav_menu').slicknav({
    //     prependTo: "#mobile_menu"
    // });

    /*================================
    login form
    ==================================*/
    $('.form-gp input').on('focus', function() {
        $(this).parent('.form-gp').addClass('focused');
    });
    $('.form-gp input').on('focusout', function() {
        if ($(this).val().length === 0) {
            $(this).parent('.form-gp').removeClass('focused');
        }
    });

    /*================================
    slider-area background setting
    ==================================*/
    $('.settings-btn, .offset-close').on('click', function() {
        $('.offset-area').toggleClass('show_hide');
        $('.settings-btn').toggleClass('active');
    });

    /*================================
    Right Click Disable
    ==================================*/
    // $(document).bind("contextmenu",function(e){
    //         return false;
    // });

    /*================================
    Owl Carousel
    ==================================*/
    // function slider_area() {
    //     var owl = $('.testimonial-carousel').owlCarousel({
    //         margin: 50,
    //         loop: true,
    //         autoplay: false,
    //         nav: false,
    //         dots: true,
    //         responsive: {
    //             0: {
    //                 items: 1
    //             },
    //             450: {
    //                 items: 1
    //             },
    //             768: {
    //                 items: 2
    //             },
    //             1000: {
    //                 items: 2
    //             },
    //             1360: {
    //                 items: 1
    //             },
    //             1600: {
    //                 items: 2
    //             }
    //         }
    //     });
    // }
    // slider_area();

    /*================================
    Fullscreen Page
    ==================================*/

    if ($('#full-view').length) {

        var requestFullscreen = function(ele) {
            if (ele.requestFullscreen) {
                ele.requestFullscreen();
            } else if (ele.webkitRequestFullscreen) {
                ele.webkitRequestFullscreen();
            } else if (ele.mozRequestFullScreen) {
                ele.mozRequestFullScreen();
            } else if (ele.msRequestFullscreen) {
                ele.msRequestFullscreen();
            } else {
                console.log('Fullscreen API is not supported.');
            }
        };

        var exitFullscreen = function() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else {
                console.log('Fullscreen API is not supported.');
            }
        };

        var fsDocButton = document.getElementById('full-view');
        var fsExitDocButton = document.getElementById('full-view-exit');

        fsDocButton.addEventListener('click', function(e) {
            e.preventDefault();
            requestFullscreen(document.documentElement);
            $('body').addClass('expanded');
        });

        fsExitDocButton.addEventListener('click', function(e) {
            e.preventDefault();
            exitFullscreen();
            $('body').removeClass('expanded');
        });
    }
})(jQuery);