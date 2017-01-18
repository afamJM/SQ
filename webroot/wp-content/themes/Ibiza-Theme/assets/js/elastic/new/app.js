var app = angular.module('ibiza', ['elasticui','mm.foundation.pagination']);

app.constant('euiHost', api_location + '/ProductCatalog.Api/api/elastic');
app.controller('IndexController', function ($scope) {
    $scope.indexName = "product";
});


app.controller('PaginationDemoCtrl', function ($scope) {
  //
  
  $scope.currentPage = indexVm.page;
  $scope.maxSize = 3;
  $scope.itemsPerPage = indexVm.pageSize;
  $scope.prevText = '<img src="https://s3-eu-west-1.amazonaws.com/project-ibiza-dev/images/f48e3691-5b64-4a6f-94b4-083e8ec40434.jpg" />';
 
  $scope.setPage = function (pageNo) {
    $scope.currentPage = pageNo;
  };
 
  $scope.setPageTotal = function (total) {
    $scope.totalItems = total;
  };

     $scope.pageChanged = function (pageNo) {
    
        setPage( pageNo )
    
  };

});

 
app.filter('makeUppercase', function () {
    return function (item) {
        // make the url lowercase
        var encodedUrl = item.toString().toLowerCase();

        // replace & with and
        encodedUrl = encodedUrl.split(/\&+/).join("-and-");

        // remove invalid characters
        encodedUrl = encodedUrl.split(/[^a-z0-9]/).join("-");

        // remove duplicates
        encodedUrl = encodedUrl.split(/-+/).join("-");

        // trim leading & trailing characters
        encodedUrl = encodedUrl.trim('-');

        return encodedUrl;
    };
});
