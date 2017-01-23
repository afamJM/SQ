var app_angular = angular.module('ibiza', ['elasticui','mm.foundation.pagination']);

app_angular.constant('euiHost', end_points.elastic);
app_angular.controller('IndexController', function ($scope) {
    $scope.indexName = "product";
});
 
app_angular.directive('euiMultiSelectFilter', ['$parse', function($parse) {
        return {
            templateUrl: '/multiselect.html',
            restrict: 'E',
            scope: true,
            link : {
                'pre': function(scope, element, attrs) {
                    elasticui.util.AngularTool.setupBinding($parse, scope, attrs, ['field', 'size']);
                    scope.agg_name = scope.field.replace(/[^a-z_0-9]/gmi, '_') + '_' + (elasticui.widgets.directives.default_agg_count++);
                }
            }
        };
    }]);
 
app_angular.controller('PaginationDemoCtrl', function ($scope) {
  
  $scope.angMath = window.Math;

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
         
        setPage( pageNo );
    
  };

});

 
app_angular.filter('makeUppercase', function () {
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

// Directive to make elements the same size
app_angular.directive('vertilizeContainer', [
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
        // Add window resize to digest cycle
        angular.element($window).bind('load', function(){
          return $scope.$apply();
        });
      }
    ]
  };
}
]);

// Vertilize Item
app_angular.directive('vertilize', [
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
