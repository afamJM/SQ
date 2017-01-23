var auctionApp = angular.module('ibiza-auction', ['ui.swiper']);


auctionApp.controller('AuctionPage', ['$scope', '$http', 'signalRHubProxy', '$window', 'getTheSpec', '$interval', '$timeout', function ($scope, $http, signalRHubProxy, $window, getTheSpec, $interval, $timeout) {

    $http.get( end_points.auction ).then(function (response) {
        $scope.productData = response.data[0];
        
        //for the quantity selector
        $scope.hiddenVal = 1;

        if(response.data[1] && response.data[1].auction.partsell){
            $scope.partSell = response.data[1];
        }

        $timeout( initQtyBtn, 500);
        if($scope.productData.auction.variant){
            $scope.mainItemAuctionLegacyId = $scope.productData.auction.variation[0].legacycode;
        }else{
            $scope.mainItemAuctionLegacyId = $scope.productData.data.legacycode;
        }

        //get the spec
        var myDataPromise = getTheSpec.getIt(response.data[0].$schema, $scope.productData.data);
        myDataPromise.then(function(result) {
            $scope.productDataSpec = result;
        });

        $scope.mainPhoto = response.data[0].data.images[0].url;

    });

    $http.get( end_points.todaysproducts ).then(function (response) {
      $scope.todaysProductsData = response;
    });

    $http.get("/wp-content/themes/Ibiza-Theme/logged-in-checker.php").then(function (response) {
      $scope.isLoggedIn = response.data;
    });

    $http.get(end_points.tvschedule).then(function (response) {
        var theD = new Date();
        var theISO = theD.toISOString();
        var noInfo = {
                fromDate: "",
                synopsis: "Please check the programme guide for information about our upcoming schedule.",
                title:"Close",
                toDate:"",
                fromTo:""
            }
        for (var i = 0; i < response.data.length; i++) {
            if(theISO.slice(0,13) == response.data[i].fromDate.slice(0,13)){
                $scope.onNow = response.data[i];
                $scope.onNow['fromTo'] = response.data[i].fromDate.slice(11,16)+' - '+response.data[i].toDate.slice(11,16);
                //if no programme next
                if(response.data[(i+1)]){
                    $scope.onNext = response.data[(i+1)];
                    $scope.onNext['fromTo'] = response.data[(i+1)].fromDate.slice(11,16)+' - '+response.data[(i+1)].toDate.slice(11,16);
                }else{
                    $scope.onNext = noInfo;
                }
            }
        }
        //if the for loop was fruitless
        if(!$scope.onNow){
            $scope.onNow = noInfo;
        }
        if(!$scope.onNext){
            $scope.onNext = noInfo;
        }
    });

    $scope.mtsFormData = {};
    $scope.mtsSubmit = function() {
        if ($scope.mtsFormData.mtsTextarea) {
            var sendObj = {customerId: $scope.mtsFormData.mtsCustomerId, channelId: 82, message: $scope.mtsFormData.mtsTextarea, anon: $scope.mtsFormData.mtsAnon};
            $http.post(end_points.message, sendObj).then(function (response) {
                //clear boxes
                $scope.mtsFormData.mtsTextarea = '';
                $scope.mtsFormData.mtsAnon = '';
            });
        }
    };

    $scope.pollForLogin = function(){
        var thePoll = $interval(function () {
            if($scope.isLoggedIn == 'false'){
                $http.get("/wp-content/themes/Ibiza-Theme/logged-in-checker.php").then(function (response) {
                  $scope.isLoggedIn = response.data;
                  if(response.data == 'true'){
                    $interval.cancel(thePoll);
                  }
                });
            }else{
                return;
            }
        }, 500);
    };

    $scope.messages = [];

    var auctionClient = signalRHubProxy('crystalHubProxy', { logging: true });

    auctionClient.on('auctionUpdate', function(auction) {
        $scope.messages.push(auction);
        
        if($scope.productData === undefined || auction.id !== $scope.productData._id)        
        {
            $state.reload();
        }
        else {
            $scope.productData.auction = auction.auction;
        }        
    });

    auctionClient.on('auctionRefresh', function() {
        $state.reload();
    });

    auctionClient.start();

    $scope.changeMainPhoto = function(newImg){
        $scope.mainPhoto = newImg;
    };

    $scope.mobileGalleryIndex = 0;
     $scope.changeMainPhotoMobTab = function(direction){
        for (var i = $scope.productData.data.images.length - 1; i >= 0; i--) {
            if($scope.productData.data.images[i].url == $scope.mainPhoto){
                if(direction == 'plus' && (i+1) < $scope.productData.data.images.length){
                    $scope.mainPhoto = $scope.productData.data.images[(i+1)].url;
                    $scope.mobileGalleryIndex = (i+1);
                }else if(direction == 'minus' && (i-1) >= 0){
                    $scope.mainPhoto = $scope.productData.data.images[(i-1)].url;
                    $scope.mobileGalleryIndex = (i-1);
                }
                break;
            }
        }
     };

     $scope.changeOffCanvas = function(dataSource){
        $scope.titleOC = eval(dataSource).data.name;
        $scope.productcodeOC = eval(dataSource).data.productcode;
        $scope.maxQtyOC = eval(dataSource).data.quantity;
        $scope.priceOC = eval(dataSource).auction.price;
        $scope.mainPhotoOC = eval(dataSource).data.images[0].url;
        $scope.allPhotos = eval(dataSource).data.images;
        $scope.descOC = eval(dataSource).data.description;
        $scope.prodDetailOC = eval(dataSource).data.legacycode;
        $scope.auctionIdOC = eval(dataSource).auction.id;

        var myDataPromise = getTheSpec.getIt(eval(dataSource).$schema, eval(dataSource).data);
        myDataPromise.then(function(result) {   
            $scope.specOC = result;
        });

        var body = jQuery('.off-canvas-wrapper');
        var newOffCanvas = jQuery('.auction-off-canvas');
        if(jQuery(window).width() <= 1024){
            var moveAmount = '83.33333';
        }else{
            var moveAmount = '41.66667';
        }

        body.wrap('<div style="overflow:hidden;"></div>');

        jQuery('.aoc-darken-body').addClass('active');
        newOffCanvas.addClass('aoc-fixed');
        newOffCanvas.css('margin-left', -moveAmount+'%');

        body.animate({
            'margin-left': moveAmount+'%',
            'margin-right': -moveAmount+'%'
        }, 300, "swing");
        newOffCanvas.animate({
            'margin-left': '0'
        }, 300, "swing");

        jQuery('.aoc-darken-body').off('click');
        jQuery('.aoc-darken-body, .aoc-cancel, [data-toggle="off-canvas"]').on('click', function(){
            body.animate({
                'margin-left': '0',
                'margin-right': '0'
            }, 300, "swing");
            newOffCanvas.animate({
                'margin-left': -moveAmount+'%'
            }, 300, "swing", function(){
                body.unwrap();
                newOffCanvas.removeClass('aoc-fixed');
            });
            jQuery('.aoc-darken-body').removeClass('active');
            $scope.swiperOC.slideTo(0, 0);
        });

        if(initQtyBtn){
            $scope.qtyOC = 1;
            $timeout( initQtyBtn ,500);
            $scope.AOChiddenVal = 1;
        };

        $timeout( initTabs ,500);

     };

}]);



'use strict';
auctionApp.factory('signalRHubProxy', ['$rootScope', function ($rootScope) {
    function signalRHubProxyFactory(hubName, startOptions, done, fail) {
        var connection = jQuery.hubConnection(api_location + "");
        var proxy = connection.createHubProxy(hubName);

        return {
            start: function(done, fail) {
                connection.start(startOptions)
                    .done(function() {
                        if (done) done();
                    })
                    .fail(function() {
                        if (fail) fail();
                    });
            },
            on: function (eventName, callback) {
                proxy.on(eventName, function (result) {
                    $rootScope.$apply(function () {
                        if (callback) {
                            callback(result);
                        }
                    });
                });
            },
            off: function (eventName, callback) {
                proxy.off(eventName, function (result) {
                    $rootScope.$apply(function () {
                        if (callback) {
                            callback(result);
                        }
                    });
                });
            },
            invoke: function (methodName, callback) {
                proxy.invoke(methodName)
                    .done(function (result) {
                        $rootScope.$apply(function () {
                            if (callback) {
                                callback(result);
                            }
                        });
                    });
            },
            connection: connection
        };
    };

    return signalRHubProxyFactory;    
}]);

auctionApp.factory('getTheSpec', ['$http', function ($http) {
        var getIt = function(theSchema, theProductData){
            return $http.get(api_url + "/ProductCatalog.api/schema/title/Product").then(function (response) {
                var prod = response.data.properties;
                return $http.get(api_url + "/ProductCatalog.api/schema/title/"+theSchema).then(function (response) {

                    var refineThese = response.data.properties;
                    var superObj = {};
                    for (var key in refineThese) {
                        if(!prod[key]){
                            superObj[key] = refineThese[key];
                        }
                    }

                    //format the results in a useful way
                    var specArr = [];
                    for (var key in superObj) {
                        specArr.push({
                            name: superObj[key].title,
                            value: theProductData[key]
                        });
                    }

                    return specArr;

                });
            });
        }
        return { getIt: getIt };
}]);

auctionApp.directive('convertToNumber', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(val) {
        return val != null ? parseInt(val, 10) : null;
      });
      ngModel.$formatters.push(function(val) {
        return val != null ? '' + val : null;
      });
    }
  };
});

// Vertilize Container
auctionApp.directive('vertilizeContainer', [
function(){
  return {
    restrict: 'EA',
    controller: [
      '$scope', '$window',
      function($scope, $window){
        // Alias this
        var _this = this;

        // Array of children heights
        _this.childrenHeights = [];

        // API: Allocate child, return index for tracking.
        _this.allocateMe = function(){
          _this.childrenHeights.push(0);
          return (_this.childrenHeights.length - 1);
        };

        // API: Update a child's height
        _this.updateMyHeight = function(index, height){
          _this.childrenHeights[index] = height;
        };

        // API: Get tallest height
        _this.getTallestHeight = function(){
          var height = 0;
          for (var i=0; i < _this.childrenHeights.length; i=i+1){
            height = Math.max(height, _this.childrenHeights[i]);
          }
          return height;
        };

        // Add window resize to digest cycle
        angular.element($window).bind('resize', function(){
          return $scope.$apply();
        });
      }
    ]
  };
}
]);

// Vertilize Item
auctionApp.directive('vertilize', [
function(){
  return {
    restrict: 'EA',
    require: '^vertilizeContainer',
    link: function(scope, element, attrs, parent){
      // My index allocation
      var myIndex = parent.allocateMe();

      // Get my real height by cloning so my height is not affected.
      var getMyRealHeight = function(){
        var clone = element.clone()
          .removeAttr('vertilize')
          .css({
            height: '',
            width: element.outerWidth(),
            position: 'fixed',
            top: 0,
            left: 0,
            visibility: 'hidden'
          });
        element.after(clone);
        var realHeight = clone.height();
        clone['remove']();
        return realHeight;
      };

      // Watch my height
      scope.$watch(getMyRealHeight, function(myNewHeight){
        if (myNewHeight){
          parent.updateMyHeight(myIndex, myNewHeight);
        }
      });

      // Watch for tallest height change
      scope.$watch(parent.getTallestHeight, function(tallestHeight){
        if (tallestHeight){
          element.css('height', tallestHeight);
        }
      });
    }
  };
}
]);