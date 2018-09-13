/**
 * kpsm short for kp site modification
 */
var kpsm = {
    //初始化商品分类页的筛选器功能
    initCategoryFilter: function () {
        $("#category-filter-switch").click(function () {
            $(".category-filters-box").toggleClass("shown");
        });
    },
    //商品分类页的购物车按键功能
    initCartBtns: function () {
        $(".qty-contrl").on("click", ".qty-reduce", function (e) {
            e.stopPropagation();
            e.preventDefault();
            var ctr = $(this).parent();
            var qty = parseInt(ctr.find(".qty-text").text());

            if (qty <= 1) {
                return;
            } else {
                ctr.find(".qty-text").text(qty - 1);
            }
        });

        $(".qty-contrl").on("click", ".qty-add", function (e) {
            e.stopPropagation();
            e.preventDefault();
            var ctr = $(this).parent();
            var qty = parseInt(ctr.find(".qty-text").text());
            ctr.find(".qty-text").text(qty + 1);
        });

        $(".over-cart .btn-addToCart").click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            var product_id = $(this).data("product-id"),
                    qty = $(this).siblings(".qty-contrl").find(".qty-text").text();
            addToCart(product_id, parseInt(qty));
        });
    },
    //商品详情页的图片轮播控件
    galleryResizer: function () {
        
        if($("#product-gallery img").length<5){
            $(".kp-side-buttons").addClass("hidden");
        }

        $(window).resize(function () {
            var box_width = $(".left .image").width();
            var thumb_width = $(".left #product-gallery").width() - 10;
            var margin = (box_width - thumb_width * 4) / 3;
            //console.log({box_width:box_width, thumb_width:thumb_width, margin:margin});

            $(".left .image #image").css("height", box_width + "px");
            $("#product-gallery").css("height", box_width + "px");
            $("#product-gallery img").css("height", thumb_width + "px").css("margin-bottom", margin + "px");
            $(".gallery-wrapper").css('top', "0px");
        }).resize();
        
        var gallery_index = 0;

        $(".kp-side-buttons .kp-prev").click(function () {
            var top = $(".gallery-wrapper").position().top;
            //console.log({'event': 'kp-prev', 'top': top});

            if (top < 0 && gallery_index>0) {
                gallery_index--;
                var newTop = $(".left #product-gallery a").height();
                $(".gallery-wrapper").animate({'top': "+=" + newTop + "px"});
            }
        });

        $(".kp-side-buttons .kp-next").click(function () {
            var top = $(".gallery-wrapper").position().top;
            var wrapper_height = $(".gallery-wrapper").height();
            var gallery_height = $(".left #product-gallery").height();
            var newTop = $(".left #product-gallery a").height();
            var items_length = $(".gallery-wrapper > a").length;
            //console.log({'event': 'kp-next', 'top': top, 'wrapper_height': wrapper_height, 'gallery_height': gallery_height});

            if ( ((wrapper_height + top - gallery_height) > newTop) && (gallery_index<items_length) ) {
                gallery_index++;
                $(".gallery-wrapper").animate({'top': "-=" + newTop + "px"});
            }
        });
    },
    //商品详情页的右侧部分悬浮显示
    stickProductDetail: function () {
        
        var html_height = $("html").height(),
            right_height = $(".product-info .right").height() - $(".product-info .right .short-desc").height(),
            footer_height = $(".fullwidth-footer").height();
        
        var window_width = $(window).width();
        if(window_width>=940){
            $(".product-info .right").addClass("sticky-right");
        }
        
        var status_short_desc = true;
        
        $(window).scroll(function () {
            window_width = $(window).width();
            if (window_width >= 940) {
                var scrollTop = $(window).scrollTop();
                //console.log({scrollTop:scrollTop, html_height:html_height, right_height:right_height, footer_height:footer_height})
                if (scrollTop > 40) {
                    if(status_short_desc){
                        $(".product-info .right").addClass("scrolling");
                        status_short_desc = false;
                    }
                    
                    if (scrollTop < (html_height - right_height - footer_height - 150)) {
                        $(".product-info .right").css({"top": scrollTop - 40 + "px"});
                    } else {
                        $(".product-info .right").css({"top": (html_height - right_height - footer_height - 150) + "px"});
                    }
                } else {
                    if(!status_short_desc){
                        $(".product-info .right").removeClass("scrolling");
                        status_short_desc = true;
                    }
                    
                    $(".product-info .right").css({"top": "20px"});
                }
            }
        });
        
        $(window).resize(function () {
            html_height = $("html").height(),
            right_height = $(".product-info .right").height(),
            footer_height = $(".fullwidth-footer").height(),
            window_width = $(window).width();
            if (window_width >= 940) {
                $(".product-info .right").addClass("sticky-right");
            }else{
                $(".product-info .right").removeClass("sticky-right");
            }
        });
    },
    //初始化商品详情页的功能
    productPageInit: function(){
        var that = this;
        $(".post-module").appendTo(".product-info .left");
        $(".related-products").appendTo(".product-info .left");
        setTimeout(function(){
            that.galleryResizer();
            that.stickProductDetail();
        }, 1000);
        
    },
    
    jump: function(eleId){
        var target = $("#"+eleId);
        
        if(target.length>0){
            var top =target.offset().top;
            //$(window).scrollTop(top-80);
            $('html, body').animate({ scrollTop: top-60 }, 'slow');
        }
        return false;
    },
    
    //初始化博客主页的筛选器功能
    initPostFilter: function () {
        $("#post-filter-switch").click(function () {
            $(".post-filters-box").toggleClass("shown");
        });
    },
    
    //顶部菜单悬停时的效果设置
    initHeaderTopMenu: function(){
        $(".journal-header-center .links > a, .currency-symbol").on('mouseenter', function(){
            if(!$(".journal-header-center").hasClass("sticky-header-center")){
                var link = $(this).hasClass("currency-symbol") ?  $(this).siblings(".top-menu-link") : $(this).find(".top-menu-link");
                var width = 0-link.width();
                //console.log(width);
                link.css({'left': width/2+20, 'visibility': 'visible'});
            }
        });

        $(".journal-header-center .links > a, .currency-symbol").on('mouseleave ', function(){
            var link = $(this).hasClass("currency-symbol") ?  $(this).siblings(".top-menu-link") : $(this).find(".top-menu-link");
            link.css({'visibility': 'hidden'});
        });
    },
    
    //初始化页面时，获取购物车的商品数量
    initCartQty: function(){
        $.get("index.php?route=common/cart/getCartProductsTotal", function(json){
            $(".top-menu-link").each(function(){
                if($(this).text()=="Shopping Cart"){
                    var obj = $(this);
                    var qty = json.cart_qty ? json.cart_qty : 0;
                    var showCls = qty>0 ? "show" : "";
                    $(this).after("<span class='cart-qty-badge " + showCls + "'>" + qty + "</span>");
                    return;
                }
            });
            
        });
    },
    
    //初始化顶部菜单“Account”
    initTopMenuAccount: function(){
        $('#account-dropdown-group').unbind('click').unbind('hoverIntent').hoverIntent(function () {
            $('#account-dropdown-menu').fadeIn(150);
        },  function () {
            $('#account-dropdown-menu').fadeOut(150);
        });
    }
   
};

$(document).ready(function(){
    kpsm.initHeaderTopMenu();
    kpsm.initCartQty();
    kpsm.initTopMenuAccount();
});