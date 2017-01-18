jQuery(document).foundation();
/*
 These functions make sure WordPress
 and Foundation play nice together.
 */

var ibizaHubProxy = (function () {
    getCurrentAuction();
    return {
        ibizaHubProxy: jQuery.connection.ibizaHubProxy,
        // Starts connection with Hub and call Hub functions.
        startServer: function () {
            var self = this;
            self.ibizaHubProxy.connection.url = api_location + "/ProductCatalog.Api/signalr";
            self.ibizaHubProxy.connection.start();
        },
        //Register callback listeners to get data from Hub(Server-Side)
        clientEventsListerners: function () {
            var self = this;

            this.ibizaHubProxy.client.auctionUpdate = function (data) {
                getCurrentAuction(1);
            };

            this.ibizaHubProxy.client.todaysProductsRefresh = function () {
                getCurrentAuction(1);
            };

            this.ibizaHubProxy.client.auctionRefresh = function () {
                getCurrentAuction(1);

            };
        },
        init: function () {
            this.startServer();
            this.clientEventsListerners();
        }
    };
})();

function getCurrentAuction(update) {
    jQuery.ajax({
        dataType: "json",
        url: api_location + "/ProductCatalog.api/api/legacy/auction"
    }).done(function (data) {
        if (!data) {
            return;
        }

        for (var i = 0; i < data.length; i++) {
            if ((data[i]["auction"]["price"]) && (data[i]["auction"]["status"] === "inprogress" || data[i]["auction"]["status"] === "complete")) {
                data[i]["data"]["price"] = data[i]["auction"]["price"].toFixed(2);
            } else {
                data[i]["data"]["price"] = data[i]["data"]["price"].toFixed(2);
            }
        }

        if (update == 1) {

            Push.create("Price Update", {
                body: "The price for " + data[0]["data"]["name"].trim() + " is now £" + data[0]["data"]["price"],
                icon: data[0]["data"]["images"][0]["url"],
                timeout: 14000,
                onClick: function () {

                    if (window.location.href.indexOf("todays-products") == -1) {
                        window.location.href = '/todays-products';
                    }
                    this.close();
                }
            });

        }

        if (window.location.href.indexOf("todays-products") > 1) {
            buildTodaysProductsAuction(data);
        } else {
            if (data[0]) {
                jQuery("#triangle").addClass("active-product");
                jQuery("#triangle-outter").addClass("active-product");
                jQuery("#product_0").addClass("active-product");
                jQuery("#productImg_0").attr("src", data[0]["data"]["images"][0]["url"]);
                jQuery("#productName_0").html("<a href=\"/p/" + data[0]["data"]["productcode"] + "\">" + data[0]["data"]["name"].trim() + "</a>");
                jQuery("#productPrice_0").html("<strong>&pound;" + numberWithCommas(data[0]["data"]["price"]) + "</strong>");
            }
            if (data[1]) {
                jQuery("#product_1").addClass("part-sell");
                jQuery("#productImg_1").attr("src", data[1]["data"]["images"][1]["url"]);
                jQuery("#productName_1").html("<a href=\"/p/" + data[1]["data"]["productcode"] + "\">" + data[1]["data"]["name"].trim() + "</a>");
                jQuery("#productPrice_1").html("<strong>&pound;" + numberWithCommas(data[1]["data"]["price"]) + "</strong>");
            } else {
                jQuery("#product_1").removeClass("part-sell");
            }
        }
        getRecentAuctions();
    });
}
;

function getRecentAuctions() {
    jQuery.ajax({
        dataType: "json",
        url: api_location + "/ProductCatalog.api/api/legacy/todaysproducts"
    }).done(function (data) {
        if (!data) {
            return;
        }

        for (var i = 0; i < data.length; i++) {
            if ((data[i]["auction"]["price"]) && (data[i]["auction"]["status"] === "inprogress" || data[i]["auction"]["status"] === "complete")) {
                data[i]["data"]["price"] = data[i]["auction"]["price"].toFixed(2);
            } else {
                data[i]["data"]["price"] = data[i]["data"]["price"].toFixed(2);
            }
        }
        if (window.location.href.indexOf("todays-products") > 1) {
            buildTodaysProducts(data);
        } else {
            var i, j
            for (i = 1, j = 0; i < 4; i++, j++) {
                if (jQuery("#product_" + i).hasClass("part-sell") === true) {
                    j--;
                    continue;
                } else {

                    if (typeof data[j] !== 'undefined') {

                        jQuery("#productImg_" + i).attr("src", (data[j]["data"]["images"][0]["url"] ? data[j]["data"]["images"][0]["url"] : data[j]["data"]["imageUrl"]));
                        jQuery("#productName_" + i).html("<a href=\"/p/" + data[j]["data"]["productcode"] + "\">" + data[j]["data"]["name"].trim() + "</a>");
                        jQuery("#productPrice_" + i).html("<strong>&pound;" + numberWithCommas(data[j]["data"]["price"]) + "</strong>");
                    }
                }
            }
        }
    });
}
;

function buildTodaysProductsAuction(data) {
    var html = "";
    for (var i = 0; i < data.length; i++) {
        html += "<div  class=\"column large-12 small-9 row\">";
        html += "<p>" + data[i]["data"]["name"].trim() + "</p>";
        html += "<p>" + data[i]["data"]["productcode"] + "</p>";
        html += "<img class=\"large-6\" src=\"" + data[i]["data"]["images"][0]["url"] + "\"/>";
        html += "<span id=\"auctionPrice\">&pound;" + numberWithCommas(data[i]["data"]["price"]) + "</span>";
        html += "<p>" + data[i]["data"]["description"] + "</p>";
        html += "<button style=\"background: #00B109\" data-toggle=\"example-dropdown2\" type=\"button\" class=\"button\" class=\"add-basket\" aria-controls=\"example-dropdown2\" data-is-focus=\"false\" data-yeti-box=\"example-dropdown2\" aria-haspopup=\"true\" aria-expanded=\"false\">Add to basket</button>";
        html += "</div>";
    }
    jQuery("#current-product").html(html);
}
;

function buildTodaysProducts(data) {
    var html = "";
    for (var i = 0; i < data.length; i++) {
        html += "<article id=\"" + data[i]["data"]["productcode"] + "\" class=\"columns large-3 small-4 text-center " + (i + 1 === data.length ? "end" : "") + "\">";
        html += "<a href=\"/p/" + data[i]["data"]["productcode"] + "\">";
        html += "<div>";
        html += "<img src=\"" + data[i]["data"]["images"][0]["url"] + "\"/>";
        html += "<p>" + data[i]["data"]["name"] + "</p>";
        html += "<p>" + data[i]["data"]["price"] + "</p>";
        html += "</div>";
        html += "</a>";
        html += "</article>";
    }
    jQuery("#dvDayShowProducts").html(html);
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
;

function toggleFacets(e) {
    console.log(e);
}
;


function updateBasket(title, price, image, productCode) {



    jQuery('.my-basket-prdocut-name').text(title);
    jQuery('.my-basket-price').text(price);
    jQuery('.my-basket-image').attr('src', image);
    jQuery('.header-container .sp-box').fadeIn();


    if (jQuery('#basket-item-' + productCode).length > 0) {

        var quantity = jQuery('.quantity', jQuery('#basket-item-' + productCode)).val();
        quantity += 1;
        var sub_total = quantity * price;
        jQuery('.basket-product-total', jQuery('#basket-item-' + productCode)).text('£' + sub_total);
        jQuery('.basket-product-total', jQuery('#basket-item-' + productCode)).attr('data-sub-total' , sub_total);
         
    } else {

        var item = jQuery('#basket-item').clone();
        jQuery(item).show();
        jQuery(item).attr('id', 'basket-item-' + productCode);
        jQuery('.basket-product-image', item).attr( 'src', image);
        jQuery('.basket-product-title', item).text(title);
        jQuery('.basket-product-price', item).text('£' + price);
        jQuery('.basket-product-price', item).attr('data-product-price' , price);
        jQuery('.basket-product-total', item).text('£' + (price * 1));
        jQuery('.basket-product-total', item).attr('data-sub-total' , (price * 1) );


    }

    jQuery(item).appendTo(".basket-data");


    setTimeout(function () {
        jQuery('.header-container .sp-box').fadeOut();
    }, 4000);

}

function basketTotalUpdate()
{
    
    var total = 0;
    jQuery( ".basket-item" ).each(function( index ) {
 
        // skip template basket
        if(index>0){
            
            var productPrice    = jQuery('.basket-product-price' ,this).attr('data-product-price');
            var quantity        = parseInt( jQuery('.quantity' ,this).val() ) ;
            var subtotal        = productPrice * quantity;

            total = total +  subtotal;
            jQuery('.basket-product-total' ,this).attr('data-sub-total' , subtotal);
            jQuery('.basket-product-total' ,this).text('£' + subtotal.toFixed(2));            
            
        }

    });    
    
    jQuery('#basket-total').text( '£' + total.toFixed(2) );
}


jQuery(document).ready(function () {



    jQuery('.ibiza-menu  > .menus').first().after('<ul style="width: 100%; height: 57px; background: rgb(255, 0, 0) none repeat scroll 0% 0% ! important;"><img src="/wp-content/themes/Ibiza-Theme/assets/images/menu-banner.png" /></ul>');


    jQuery(document).on("click", '#basket-con .add_quantity', function () {

        var container   = jQuery(this).parent().parent();
        var quantity    = parseInt(jQuery('.quantity', container).val()) + 1;
        var basket_id   = container.parent().parent().attr('data-basket-product-basketid');
        var url         = basket_update_url.replace('{basketId}', basket_id).replace('{quantity}', quantity);

        jQuery.ajax({
            dataType: 'json',
            url: url,
            method: 'POST'
        }).done(function (data) {
                
            basketTotalUpdate();

        });

        jQuery('.quantity', container).val(quantity);

    });


    jQuery(document).on("click", '#basket-con .remove_quantity', function () {

        var container = jQuery(this).parent().parent();
        if (parseInt(jQuery('.quantity', container).val()) <= 1) {
            return;
        }


        var quantity = parseInt(jQuery('.quantity', container).val()) - 1;
        var basket_id = container.parent().parent().attr('data-basket-product-basketid');
        var url = basket_update_url.replace('{basketId}', basket_id).replace('{quantity}', quantity);

        jQuery.ajax({
            dataType: 'json',
            url: url,
            method: 'POST'
        }).done(function (data) {
            
            basketTotalUpdate();

        });



        jQuery('.quantity', container).val(quantity);

    });


    jQuery(document).on("click", '.basket-remove-item', function (e) {

        var container = jQuery(this).parent().parent().parent();

        console.log(container);

        var quantity =  0;
        var basket_id = container.attr('data-basket-product-basketid');
        var url = basket_update_url.replace('{basketId}', basket_id).replace('{quantity}', quantity);

        jQuery.ajax({
            dataType: 'json',
            url: url,
            method: 'POST'
        }).done(function (data) {

            jQuery(container).fadeOut();
            basketTotalUpdate();
        });



        jQuery('.quantity', container).val(quantity);

    });


    var grid_arr = new Array();
    var grid_ops = {itemSelector: '#lev-0 > .menu-item-has-children', columnWidth: 315};

    jQuery(".header-container")
            .mouseover(function () {


                if (jQuery('.sp-box').is(":visible")) {
                    return;
                }
                // stop basket pop up from showing

                jQuery('#tri').remove();
                jQuery('#tri').css({margin: '5px auto', 'z-index': '1'});
                jQuery('span', this).first().append('<div id="tri"></div>');
                jQuery('#basket-con', this).show();
                jQuery('.basket-link', this).addClass('active');
                jQuery('.search-link', this).addClass('active');

                if (jQuery('.basket-link', this).hasClass('active')) {
                    jQuery('.main-nav__backdrop').css({'opacity': 1, 'visibility': 'visible'});
                }


            }).mouseleave(function () {
        jQuery('.main-nav__backdrop').css({'opacity': 0, 'visibility': 'hidden'});
        jQuery('.basket-link', this).removeClass('active');
        if (!jQuery('.search-container').is(":visible")) {
            jQuery('.search-link', this).removeClass('active');
            jQuery('#tri').hide().remove();
        }
        jQuery('#basket-con', this).hide();

    });


    jQuery("#tri").mouseleave(function () {
        if (!jQuery('.search-container').is(":visible")) {
            jQuery('.search-link', this).removeClass('active');
            jQuery('#tri').hide().remove();
        }
    });


    jQuery("#menu-main-1 > .menu-item")
            .mouseover(function () {

                jQuery('#tri', '#top-bar-menu').remove();
                jQuery('a', this).first().append('<div id="tri"></div>');

                if (jQuery(' > .ibiza-menu ul', this).length > 0) {

                    jQuery('.main-nav__backdrop').css({'opacity': 1, 'visibility': 'visible'});

                    //
                    var index = jQuery('li', this).index('#menu-main-1 li');
                    if (!jQuery('.menus', this).hasClass('masonry')) {

                        var $grid = jQuery('.menus', this).masonry(grid_ops);
                        grid_arr[index] = $grid;
                        jQuery('.menus', this).addClass('masonry');
                    } else {

                        grid_arr[index].masonry('destroy');
                        grid_arr[index] = jQuery('.menus', this).masonry(grid_ops);
                    }
                } else {
                    jQuery('.ibiza-menu', this).remove();
                    //no needed quick work around
                }

            }).mouseout(function () {

        //jQuery('#tri').remove();
        jQuery('.main-nav__backdrop').css({'visibility': 'hidden', 'opacity': 0});
    });

    jQuery(".ibiza-menu").mouseleave(function () {
        jQuery('#tri', '#top-bar-menu').remove();
        jQuery('.main-nav__backdrop').css({'visibility': 'hidden', 'opacity': 0});
    });


    var basketItem = jQuery("#basket-item").clone();
    var basketTotalOut = 0;
    jQuery.ajax({
        url: basket_url,
        context: document.body
    }).done(function (data) {



        jQuery('#basket-item').hide();
        var count = 0;
        jQuery.each(data, function (index, value) {

            count++;
            console.log(value);
            var basketTotal = value.price * value.quantity;
            basketTotalOut += basketTotal;
            jQuery('#basket-count').text(count);
            jQuery('#basket-count').fadeIn();
            var item = jQuery(basketItem).clone();
            jQuery(item).attr('id', 'basket-item-' + value.productCode);
            jQuery('.basket-product-image', item).attr( 'src', value.imageURL);
            jQuery('.basket-product-title', item).text(value.description);
            jQuery(item).attr('data-basket-product-basketid', value.basketid);
            jQuery('.basket-product-price', item).text('£' + value.price.toFixed(2));
            jQuery('.basket-product-price', item).attr( 'data-product-price', value.price.toFixed(2) );
            jQuery('.basket-product-total', item).text('£' + basketTotal.toFixed(2));
            jQuery('.basket-product-total', item).attr('data-sub-total' , basketTotal.toFixed(2) );
            jQuery('.quantity', item).val(value.quantity);


            jQuery(item).appendTo(".basket-data");

        });
        jQuery('#basket-total').text('£' + basketTotalOut.toFixed(2));

    });


    jQuery(document).on('click', '#add-basket,.add-basket', function () {
        //jQuery('#add-basket,.add-basket').click(function (e) {

        if (jQuery('.lvl2').length > 0 && jQuery('.lvl2.current').length <= 0) {

            e.preventDefault();

            return alert('Please select ' + jQuery('.lvl2_text').text() + ' to continue.');

        }


        var quantity = jQuery('#middle-label').val();
        var productCode = jQuery(this).attr('data-product-code');
        var productDetailID = jQuery(this).attr('data-product-id');
        var productName = jQuery(this).attr('data-product-name');
        var productPrice = jQuery(this).attr('data-product-pice');
        var productImage = jQuery(this).attr('data-product-image');

        updateBasket(productName, productPrice, productImage, productCode);

        jQuery.ajax({
            dataType: 'json',
            url: '/proxy.php?auctionID=-1&productCode=' + productCode + '&productDetailID=' + productDetailID + '&quantity=' + quantity
        }).done(function (data) {



            //jQuery('#basket-total').text('£' + data.basketTotal.toFixed(2));
            //jQuery('#basket-description').text(data.description);

        });

    });




    $window = jQuery(window);
    $window.scroll(function () {
        $scroll_position = $window.scrollTop();
        if ($scroll_position > 50) { // if body is scrolled down by 300 pixels
            jQuery('.header-outter').addClass('sticky');

            jQuery('.ibiza-menu').css('margin-top', '0px');
            jQuery('#basket-con,.main-nav__backdrop').addClass('add-basket-margin');

            // to get rid of jerk
            header_height = jQuery('.header-outter').innerHeight();
            jQuery('.header-outter').css('top', 0);
        } else {
            jQuery('.ibiza-menu').css('margin-top', '0');
            jQuery('#basket-con,.main-nav__backdrop').removeClass('add-basket-margin');
            jQuery('body').css('padding-top', '0');
            jQuery('.header-outter').removeClass('sticky');
        }
    });



    // Remove empty P tags created by WP inside of Accordion and Orbit
    jQuery('.accordion p:empty, .orbit p:empty').remove();


    //initialize swiper when document ready  
    var mySwiper = new Swiper('.swiper-container', {
        // Optional parameters
        loop: true
    });




    // Makes sure last grid item floats left
    jQuery('.archive-grid .columns').last().addClass('end');

    // Adds Flex Video to YouTube and Vimeo Embeds
    jQuery('iframe[src*="youtube.com"], iframe[src*="vimeo.com"]').each(function () {
        if (jQuery(this).innerWidth() / jQuery(this).innerHeight() > 1.5) {
            jQuery(this).wrap("<div class='widescreen flex-video'/>");
        } else {
            jQuery(this).wrap("<div class='flex-video'/>");
        }
    });

    var sliding = 0;
    jQuery('.search-link').click(function (e) {

        jQuery("html, body").animate({scrollTop: 0}, "slow");

        if (sliding == 1)
            return;

        sliding = 1;
        jQuery('.search-container').slideToggle(function () {
            sliding = 0;
            jQuery('.tt-input').focus();
        });
        jQuery(this).toggleClass('active');
    });

    ibizaHubProxy.init();
});

