//Tabber
function initTabs(){
    jQuery('.tabber').each(function(){
        var papa = jQuery(this);
        if(papa.find('.tab-house').is(':visible')){
            papa.addClass('is-active');
            papa.find('[data-tabbed]').off('click');//clear any old listeners
            papa.find('[data-tabbed]').on('click', function(){
                papa.find('.tabber-content.active').removeClass('active');
                papa.find('.tabber-tab.active').removeClass('active');
                jQuery('[data-content='+jQuery(this).data('tabbed')+']').addClass('active');
                jQuery('[data-tabbed='+jQuery(this).data('tabbed')+']').addClass('active');
                papa.addClass('active');
            });
        }else{
            papa.removeClass('is-active');
        };
    });
};

//quantity buttons
function initQtyBtn(){
    jQuery('.quantity-sq').each(function() {
        var spinner = jQuery(this),
        input = spinner.find('input.primary');
        
        if(spinner.find('.quantity-sq-button').length == 0){
            jQuery('<div class="quantity-sq-button quantity-sq-up">+</div>').insertAfter(input);
            jQuery('<div class="quantity-sq-button quantity-sq-down">-</div>').insertBefore(input);
        }

        var btnUp = spinner.find('.quantity-sq-up'),
        btnDown = spinner.find('.quantity-sq-down');

        input.val(1);

        btnUp.off('click');
        btnUp.on('click', function() {
            var min = input.attr('min'),
            max = input.attr('max');
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find('.hiddenVal').val(newVal);
            spinner.find('.hiddenVal').trigger("change");
        });

        btnDown.off('click');
        btnDown.on('click', function() {
            var min = input.attr('min'),
            max = input.attr('max');
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find('.hiddenVal').val(newVal);
            spinner.find('.hiddenVal').trigger("change");
        });

    });
};

jQuery('.show-details').click(function(){
    var noJump = setInterval(function(){
        mySwiperTvS.update();
    },40);
    jQuery(this).next('.show-details-content').slideToggle(function(){
        clearInterval(noJump);
    });
});

var mySwiperTvS = null;
jQuery( document ).ready(function() {
    window.isAuctionPage = true;
    setTimeout(function(){
        //Renaming to prevent a clash with the Angular use of 'Swiper'
        var SwiperX = Swiper;
        Swiper = null;
        mySwiperTvS = new SwiperX('.swiper-container-tv-schedule', {
            autoHeight: true,
            nextButton : '.swiper-button-next',
            prevButton : '.swiper-button-prev',
            observer: true,
            observeParents: true,
            onSlideChangeEnd: function(){
                jQuery('.pg-day-and-date:not(.hide)').addClass('hide');
                jQuery('.pg-day-and-date').eq(jQuery('.swiper-container-tv-schedule .swiper-slide-active').index()).removeClass('hide');

            }
        });
        jQuery('.pg-day-and-date').each(function(){
            jQuery(this).children('h4, small').removeClass('hide');
            if(jQuery(this).children('h4').text() != ''){
                var pgDate = new Date(jQuery(this).children('h4').text());
                var pgDays = ['Sunday','Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday'];
                var pgMonths = ['January','February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                jQuery(this).children('h4').text(pgDays[pgDate.getDay()]);
                jQuery(this).children('small').text(pgDate.getDate() + ' ' + pgMonths[pgDate.getMonth()] + ' ' +pgDate.getFullYear());
            }else{
                jQuery(this).children('small').text('We\'re having problems connecting to the TV schedule.');
            }
        });
    }, 500);
});

jQuery(function () {

    initTabs();

    jQuery('[id$="dvVideoHolderHome"]').Video({
        container: 'dvVideoHolderHome',
        channel: 'JEWELLERYMAKER',
        autoStart: true,
        controls: false,
        mute: true,
        //quality: 'thumbnail',
        pageIdentifier: 'homepage',
        edge: '',
     });



    jQuery("a#single_image").fancybox({
        padding: 0,
        nextEffect: 'none',
        prevEffect: 'none',
        helpers: {
            overlay: {
              locked: false
            }
        }
    });

    jQuery("a#single_image_OC").fancybox({
        padding: 0,
        nextEffect: 'none',
        prevEffect: 'none',
        helpers: {
            overlay: {
              locked: false
            }
        }
    });

    jQuery(".login-window-popup").fancybox({
        padding: 0,
        nextEffect: 'none',
        prevEffect: 'none',
        helpers: {
            overlay: {
              locked: false
            }
        }
    });

});

jQuery(window).resize(function(){
    initTabs();
});

var loginInterval;
var userIsLoggedIn = false;