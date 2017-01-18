var auctionApp = angular.module('ibiza-auction', []);

//auctionApp.constant('apiSignalR', api_location + '/ProductCatalog.Api/signalr');
//auctionApp.constant('apiAuction', api_location + '/ProductCatalog.api/api/legacy/auction');
//auctionApp.constant('apiTodayspProducts', api_location + '/ProductCatalog.api/api/legacy/todaysproducts');

auctionApp.controller('AuctionPage', ['$scope', '$http', 'signalRHubProxy', '$window', 'getTheSpec', '$interval', function ($scope, $http, signalRHubProxy, $window, getTheSpec, $interval) {
    //$scope.signalR = api_location + "/ProductCatalog.Api/signalr";
    //jQuery.connection.ibizaHubProxy.connection.url =  api_location + "/ProductCatalog.Api/signalr";
    //jQuery.connection.ibizaHubProxy.connection.start();
    //$scope.signalR = jQuery.connection.ibizaHubProxy.connection.url;
    $http.get(api_location + "/ProductCatalog.api/api/legacy/auction").then(function (response) {
        $scope.productData = response.data[0];
        $scope.mainItemAuctionLegacyId = $scope.productData.data.legacycode;

        //get the spec
        var myDataPromise = getTheSpec.getIt(response.data[0].$schema, $scope.productData.data);
        myDataPromise.then(function(result) {
            $scope.productDataSpec = result;
        });

        $scope.mainPhoto = response.data[0].data.images[0].url;
    });

    $http.get(api_location + "/ProductCatalog.api/api/legacy/todaysproducts").then(function (response) {
      $scope.todaysProductsData = response;
    });

    $http.get("/wp-content/themes/Ibiza-Theme/logged-in-checker.php").then(function (response) {
      $scope.isLoggedIn = response.data;
    });

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

    var auctionClient = signalRHubProxy('ibizaHubProxy', { logging: true });

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

     $scope.changeOffCanvas = function(theIndex){
        $scope.titleOC = $scope.todaysProductsData.data[theIndex].data.name;
        $scope.productcodeOC = $scope.todaysProductsData.data[theIndex].data.productcode;
        $scope.priceOC = $scope.todaysProductsData.data[theIndex].auction.price;
        $scope.mainPhotoOC = $scope.todaysProductsData.data[theIndex].data.images[0].url;
        $scope.descOC = $scope.todaysProductsData.data[theIndex].data.description;
        $scope.prodDetailOC = $scope.todaysProductsData.data[theIndex].data.legacycode;
        $scope.auctionIdOC = $scope.todaysProductsData.data[theIndex].auction.id;

        //$scope.specOC = $scope.todaysProductsData.data[theIndex];

        window.zxc = $scope.todaysProductsData.data[theIndex];

        var offCanvas = jQuery('#off-canvas');
        var newOffCanvas = jQuery('.auction-off-canvas');
        var todaysItems = jQuery('.todays-items-row');

        offCanvas.prepend(newOffCanvas);
        offCanvas.addClass('show-auction-off-canvas');
        offCanvas.css('margin-top',todaysItems.offset().top+'px');
        todaysItems.css('min-height',offCanvas.height()+'px');
        jQuery('[data-toggle="off-canvas"]:not(.auction-off-canvas-button)').on('click.closeOffCanvas', function(){
            jQuery('#content').after(newOffCanvas);
            jQuery('[data-toggle="off-canvas"]:not(.auction-off-canvas-button), .off-canvas-wrapper-inner *').off('click.closeOffCanvas');
            offCanvas.removeClass('show-auction-off-canvas');
            offCanvas.css('margin-top','0px');
            todaysItems.css('min-height','auto');
        });

     };

}]);




'use strict';
auctionApp.factory('signalRHubProxy', ['$rootScope', function ($rootScope) {
    function signalRHubProxyFactory(hubName, startOptions, done, fail) {
        var connection = jQuery.hubConnection(api_location + "/ProductCatalog.api/");
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
            return $http.get(api_location + "/ProductCatalog.api/api/schema/title/Product").then(function (response) {
                var prod = response.data.properties;
                return $http.get(api_location + "/ProductCatalog.api/api/schema/title/"+theSchema).then(function (response) {

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
