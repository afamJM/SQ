/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var mySwiperTvProducts = null;

function doPoll() {
    jQuery.getJSON(api_location + '/ProductCatalog.api/api/productsontv/6', function (data) {
        jQuery.each(data, function (i, l) {
            if (data.length - 1 == i) {
                var slide = jQuery('.swiper-container-tv-products .swiper-slide').last().clone();
                jQuery('img', slide).attr('href', data.imageUrl);
                jQuery('p', slide).text('New - ' + data['description']);
                jQuery('a', slide).text(data.name);
                mySwiperTvProducts.prependSlide(slide);
                console.log(slide);

                mySwiperTvProducts.slideTo(0);
            }
        });
        setTimeout(doPoll, 25000);
    });
}



jQuery(document).ready(function () {
    //initialize swiper when document ready  
    mySwiperTvProducts = new Swiper('.swiper-container-tv-products', {
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev'
    });
    setTimeout(doPoll, 25000);
});