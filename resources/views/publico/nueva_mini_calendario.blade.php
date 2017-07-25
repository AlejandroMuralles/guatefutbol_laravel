<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:regular,900,700,100&amp;greek-ext,latin" type="text/css">
		<link href="{{ asset('assets/public/css/estilos_minicalendario.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

		<script src="{{ asset('assets/public/js/angular.min.js') }} "></script>
		<script src="{{ asset('assets/public/js/angular-route.min.js') }} "></script>
		<!--angular -->
		<script type="text/javascript" src="{{ asset('assets/public/js/app.js') }}"></script>
	</head>
	<body ng-app="app" ng-controller="MiniCalendarioController" class="fondo" style="margin: 0; font-family: Roboto,sans-serif;">

		<div ng-repeat="jornada in calendario">
			<div class="soccer-recent-result" ng-repeat="partido in jornada.partidos">
				<div class="clubnames" style="font-size: 10px">
					<span><% partido.fecha %></span>
					<span class="pull-right"><% partido.hora %></span>
				</div>
				<div class="soccer-recent-result-item">
					<div class="soccer-recent-result-list" style="width: 36%; padding-left: 3px">
						<img ng-src="<% partido.imagenLocal %>"> <% partido.equipolocal %>
					</div>
					<div class="text-center soccer-recent-result-list" ng-hide="partido.golesLocal==null" style="width: 25%">
						<span class="goal"><% partido.golesLocal %></span> - <span class="goal"><% partido.golesVisita %></span>
					</div>
					<div class="text-center soccer-recent-result-list" ng-show="partido.golesLocal==null" style="width: 25%">
						-
					</div>
					<div class="text-center soccer-recent-result-list" style="width: 36%">
						<% partido.equipovisita %> <img ng-src="<% partido.imagenVisita %>">
					</div>
				</div>
			</div> 
		</div>

		<input type="hidden" value="{{$campeonato->id}}" id="campeonatoId">
		<input type="hidden" value="{{$campeonato->liga_id}}" id="ligaId">

		@if($configuracion->parametro3)
			<input type="hidden" value="{{$configuracion->parametro1}}" id="tiempo">			
		@else
			<input type="hidden" value="0" id="tiempo">
		@endif

	</body>
</html>