var app = angular.module( 'app' , ['ngRoute'], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller("MiniCalendarioController", function($scope, $http, $interval) {
    var campeonato = document.getElementById('campeonatoId').value;
    var liga = document.getElementById('ligaId').value;
    var tiempo = document.getElementById('tiempo').value;
    console.log(tiempo);
    if(tiempo > 0){
        var myUpdater = $interval(function(){
            $scope.getCalendario();
        }, tiempo*1000000);
    }

    $scope.getCalendario = function(){
        $http.get('http://guatefutbol.net/guatefutbol/json-mini-calendario/' + liga +'/' + campeonato + '/0').success (function(data){
            $scope.calendario = data;
        });
    }

    $scope.getCalendario();
});

app.controller("MiniPosicionesController", function($scope, $http, $interval) {
    var campeonato = document.getElementById('campeonatoId').value;
    var liga = document.getElementById('ligaId').value;
    var tiempo = document.getElementById('tiempo').value;
    if(tiempo > 0){
        var myUpdater = $interval(function(){
            $scope.getPosiciones();
        }, tiempo*1000);
    }

    $scope.getPosiciones = function(){
        $http.get('http://guatefutbol.net/guatefutbol/json-mini-posiciones/' + liga +'/' + campeonato).success (function(data){
            $scope.posiciones = data;
            console.log('obtuvo posiciones');
        });
    }

    $scope.getPosiciones();
});