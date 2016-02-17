var app = angular.module('detall', ['ngAnimate', 'ui.bootstrap', 'ngLoadingSpinner']) .controller('emalist', function($scope, $uibModal) {
$scope.open = function (size) {

//console.log(size);
  $scope.animationsEnabled = true;
    var modalInstance = $uibModal.open({
      animation: $scope.animationsEnabled,
      templateUrl: 'http://cbdev-localhost/editar/Gestor_grups.php?a=get_html_email&b='+size,
      controller: 'ModalInstanceCtrl',
      size: size,
      resolve: {
        items: function () {
          return $scope.items;
        }
      }
});
}});

//var detall = angular.module('detall', []);



angular.module('detall').controller('ModalInstanceCtrl', function ($scope, $uibModalInstance, $http) {

  $scope.ok = function () {
    //$uibModalInstance.close($scope.selected.item);
    alert("OOOOK");
  };

  $scope.reenvia = function (mid) {
    //$uibModalInstance.close($scope.selected.item);
    $http.get("Gestor_grups.php?a=resend_email&b=" + mid)
        .then(function(response) {
        //    console.log(response);
        //  alert(response.data);
        if (response.data.resultat){
            location.reload();
        }else{
            alert("L'enviament ha fallat!");
        }
        });
    //alert("reenvia");
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };
});


angular.module('detall').controller('llistatEmails', function ($scope,  $http) {
    $http.get("Gestor_grups.php?a=llista_emails_reserva&b=17" )
        .then(function(response) {
          $scope.confirmada = response.data.confirmada;
          $scope.files = response.data.rows;  
  console.log(response.data);
    });
    
});


app.filter('num', function() {
    return function(input) {
      return parseInt(input, 10);
    }
});