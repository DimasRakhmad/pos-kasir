var app = angular.module('MyApp', []);

app.controller('MyCtrl', [
  '$scope', '$attrs',
  function($scope, $attrs) {
    $scope.da = $attrs.tes;
    
  }
]);
