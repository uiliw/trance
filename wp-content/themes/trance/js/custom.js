var $ = jQuery.noConflict();

particlesJS("particles-js", {
    "particles": {
        "number": {"value": 142, "density": {"enable": false, "value_area": 800}},
        "color": {"value": "#ffffff"},
        "shape": {
            "type": "circle",
            "stroke": {"width": 0, "color": "#000000"},
            "polygon": {"nb_sides": 5},
            "image": {"src": "img/github.svg", "width": 100, "height": 100}
        },
        "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {"enable": false, "speed": 1, "opacity_min": 0.1, "sync": false}
        },
        "size": {"value": 3, "random": true, "anim": {"enable": false, "speed": 40, "size_min": 0.1, "sync": false}},
        "line_linked": {"enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1},
        "move": {
            "enable": true,
            "speed": 6,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {"enable": false, "rotateX": 600, "rotateY": 1200}
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
            "onhover": {"enable": true, "mode": "repulse"},
            "onclick": {"enable": true, "mode": "push"},
            "resize": true
        },
        "modes": {
            "grab": {"distance": 400, "line_linked": {"opacity": 1}},
            "bubble": {"distance": 400, "size": 40, "duration": 2, "opacity": 8, "speed": 3},
            "repulse": {"distance": 200, "duration": 0.4},
            "push": {"particles_nb": 4},
            "remove": {"particles_nb": 2}
        }
    },
    "retina_detect": true
});

jQuery(document).ready(function ($) {

    $('.widget_shopping_mini_cart').on('click', '.dropdown-total', function ($e) {
        $(this).next().slideToggle();

        return false;
    });

    $('body').bind('adding_to_cart', function () {
        $('.widget_shopping_mini_cart').show();
    });

    $('body').bind('added_to_cart', function () {
        $('.widget_shopping_mini_cart').addClass('loading');
        var this_page = window.location.toString();
        this_page = this_page.replace('add-to-cart', 'added-to-cart');
        if (this_page.indexOf('?') >= 0) {
            this_page += '&t=' + new Date().getTime();
        } else {
            this_page += '?t=' + new Date().getTime();
        }

        $('.widget_shopping_mini_cart_content').load(this_page + ' .dropdown-cart-button', function () {
            $('.widget_shopping_mini_cart').removeClass('loading');
        });
    });

    $('.widget_shopping_mini_cart').on('click', function ($e) {
        $e.stopPropagation();
    });

    $(document).on('click', function () {
        $('.widget_shopping_mini_cart .dropdown').hide();
    });


    $(function () {

        $(window).scroll(function () {
            //var $(window).scrollTop(); 為 scroll
            var scroll = $(window).scrollTop();
            if (scroll >= 120) {

                $(".navbar-scroll").addClass("fixed-top");

            } else {

                $(".navbar-scroll").removeClass("fixed-top")

            }

        });

    })

});
/**
 * requestAnimationFrame polyfill by Erik Möller. fixes from Paul Irish and Tino Zijdel
 * @see: http://paulirish.com/2011/requestanimationframe-for-smart-animating/
 * @see: http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
 * @license: MIT license
 */
(function () {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame']
            || window[vendors[x] + 'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function (callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function () {
                    callback(currTime + timeToCall);
                },
                timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function (id) {
            clearTimeout(id);
        };
}());

(function () {
    var $searchOverlay = document.querySelector(".search-overlay");
    var $search = document.querySelector(".search");
    var $clone, offsetX, offsetY;

    $search.addEventListener("click", function () {
        var $original = this;
        $clone = this.cloneNode(true);

        $searchOverlay.classList.add("s--active");

        $clone.classList.add("s--cloned", "s--hidden");
        $searchOverlay.appendChild($clone);

        var triggerLayout = $searchOverlay.offsetTop;

        var originalRect = $original.getBoundingClientRect();
        var cloneRect = $clone.getBoundingClientRect();

        offsetX = originalRect.left - cloneRect.left;
        offsetY = originalRect.top - cloneRect.top;

        $clone.style.transform = "translate(" + offsetX + "px, " + offsetY + "px)";
        $original.classList.add("s--hidden");
        $clone.classList.remove("s--hidden");

        var triggerLayout = $searchOverlay.offsetTop;

        $clone.classList.add("s--moving");

        $clone.setAttribute("style", "");

        $clone.addEventListener("transitionend", openAfterMove);
    });

    function openAfterMove() {
        $clone.classList.add("s--active");
        $clone.querySelector("input").focus();

        addCloseHandler($clone);
        $clone.removeEventListener("transitionend", openAfterMove);
    };

    function addCloseHandler($parent) {
        var $closeBtn = $parent.querySelector(".search__close");
        $closeBtn.addEventListener("click", closeHandler);
    };

    /* close handler functions */
    function closeHandler(e) {
        $clone.classList.remove("s--active");
        e.stopPropagation();

        var $cloneBg = $clone.querySelector(".search__bg");

        $cloneBg.addEventListener("transitionend", moveAfterClose);
    };

    function moveAfterClose(e) {
        e.stopPropagation(); // prevents from double transitionend even fire on parent $clone

        $clone.classList.add("s--moving");
        $clone.style.transform = "translate(" + offsetX + "px, " + offsetY + "px)";
        $clone.addEventListener("transitionend", terminateSearch);
    };

    function terminateSearch(e) {
        $search.classList.remove("s--hidden");
        $clone.remove();
        $searchOverlay.classList.remove("s--active");
    };
}());




