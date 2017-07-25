<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:regular,900,700,100&amp;greek-ext,latin" type="text/css">
		<link href="{{ asset('assets/public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

		<script src="{{ asset('assets/public/js/angular.min.js') }} "></script>
		<script src="{{ asset('assets/public/js/angular-route.min.js') }} "></script>
		<!--angular -->
		<script type="text/javascript" src="{{ asset('assets/public/js/app.js') }}"></script>

		<style>

			table {
				background-color: #000;
				color: white;
				font-family: Roboto,sans-serif;
				font-size: 12px;
				border: 1px solid #333 !important;
			}
			table th {
				background-color: #006699;
				padding: 8px !important ;
				border: 1px solid #006699 !important;
			}

			table td {
				padding: 3px !important ;
				border-top: 1px solid #333 !important;
				border-bottom: 1px solid #333 !important;
			}

		</style>

	</head>
	<body ng-app="app" ng-controller="MiniPosicionesController" style="background: rgba(255, 0, 0, 0);" >
		<input type="hidden" value="{{$campeonato->id}}" id="campeonatoId" >
		<input type="hidden" value="{{$campeonato->liga_id}}" id="ligaId">

		@if($configuracion->parametro3)
			<input type="hidden" value="{{$configuracion->parametro1}}" id="tiempo">			
		@else
			<input type="hidden" value="0" id="tiempo">
		@endif
			<table class="table table-responsive" style="">
				<tbody>
					<tr>
						<th class="text-center">POS</th>
						<th class="text-center">EQUIPO</th>
						<th class="text-center">PTS</th>
						<th class="text-center">JJ</th>
						<th class="text-center">DIF</th>
					</tr>					
					<tr ng-repeat="posicion in posiciones">
						<td class="text-center"><% posicion.POS %> </td>
						<td>
							<img ng-src="<% posicion.equipo.logo %>" width="15px"> 
							<% posicion.equipo.nombre %> 
						</td>
						<td class="text-center"><% posicion.PTS %> </td>
						<td class="text-center"><% posicion.JJ %> </td>
						<td class="text-center"><% posicion.DIF %> </td>
					</tr>
				</tbody>
			</table>
	</body>
</html>
