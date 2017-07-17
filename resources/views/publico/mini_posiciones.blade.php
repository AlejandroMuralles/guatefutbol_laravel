<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:regular,900,700,100&amp;greek-ext,latin" type="text/css">
		<link href="{{ asset('assets/public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/public/css/estilos_miniposiciones.css') }}" rel="stylesheet" type="text/css" />
	</head>
	<body style="background: rgba(255, 0, 0, 0);" >
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
					@foreach($posiciones as $posicion)				
					<tr>
						<td class="text-center">{{ $posicion->POS }} </td>
						<td>
							<img src="{{asset('assets/imagenes/equipos')}}/{{ $posicion->equipo->imagen }}" width="15px"> 
							{{ $posicion->equipo->nombre }} 
						</td>
						<td class="text-center">{{ $posicion->PTS }} </td>
						<td class="text-center">{{ $posicion->JJ }} </td>
						<td class="text-center">{{ $posicion->DIF }} </td>
					</tr>
					@endforeach
				</tbody>
			</table>
	</body>
</html>
