@extends('layouts.admin')

@section('title') Partidos por Equipo @stop
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')

	{!! Form::open(['route' => ['partidos_jugadores',$ligaId,0], 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form', 'id'=>'form']) !!}
	
	@if($equipoId != 0)
		<h3>{{$jugador->nombreCompleto}} con {{$equipo}}</h3>
		<hr>
	@elseif($rivalId != 0)
		<h3>{{$jugador->nombreCompleto}} contra {{$rival}}</h3>
		<hr>
	@elseif($campeonatoId != 0)
		<h3>{{$jugador->nombreCompleto}} en el Campeonato {{$campeonato}}</h3>
		<hr>
	@else

		@if($jugador)
			{!! Field::text('jugador', $jugador->nombreCompleto , ['id'=>'jugador']) !!}
		@else
			{!! Field::text('jugador', null, ['id'=>'jugador']) !!}
		@endif

		<input type="hidden" id="jugadorId" value="">
        <p>
            <a href="#" onclick="consultar(); return false;" class="btn btn-primary btn-flat">Buscar</a>
        </p>

	@endif

		

	{!! Form::close() !!}

	<div class="table-responsive">
		<table class="table table-responsive">
			<thead>
				<tr>
					<th>JUGADOR</th>
					<th>AP</th>
					<th>MJ</th>
					<th>G</th>
					<th>A</th>
					<th>AA</th>
					<th>R</th>					
					<th>GANADOS</th>
					<th>EMPATADOS</th>
					<th>PERDIDOS</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				@if($jugador)
					<td>
						<a href="{{route('partidos_jugadores',[$ligaId,$jugadorId,0,0,0])}}">{{$jugador->nombreCompleto}}</a>
					</td>
					<td>{{$totales->apariciones}}</td>
					<td>{{$totales->minutos_jugados}}</td>
					<td>{{$totales->goles}}</td>
					<td>{{$totales->amarillas}}</td>
					<td>{{$totales->doblesamarillas}}</td>
					<td>{{$totales->rojas}}</td>
					<td>{{$totales->ganados}} </td>
					<td>{{$totales->empatados}} </td>
					<td>{{$totales->perdidos}} </td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>

	<div class="table-responsive">
		<table class="table table-responsive">
			<thead>
				<tr>
					<th>EQUIPO</th>
					<th>AP</th>
					<th>MJ</th>
					<th>G</th>
					<th>A</th>
					<th>AA</th>
					<th>R</th>
					<th>GANADOS</th>
					<th>EMPATADOS</th>
					<th>PERDIDOS</th>
				</tr>
			</thead>
			<tbody>
				@foreach($totalesEquipos as $totalEquipo)
				<tr>
					<td>
						<a href="{{route('partidos_jugadores',[$ligaId,$jugadorId,$totalEquipo->equipo->id,0,0])}}">{{$totalEquipo->equipo->nombre}}</a>
					</td>
					<td>{{$totalEquipo->apariciones}}</td>
					<td>{{$totalEquipo->minutos_jugados}}</td>
					<td>{{$totalEquipo->goles}}</td>
					<td>{{$totalEquipo->amarillas}}</td>
					<td>{{$totalEquipo->doblesamarillas}}</td>
					<td>{{$totalEquipo->rojas}}</td>
					<td>{{$totalEquipo->ganados}} </td>
					<td>{{$totalEquipo->empatados}} </td>
					<td>{{$totalEquipo->perdidos}} </td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="table-responsive">
		<table class="table table-responsive" id="partidos">
			<thead>
				<tr>
					<th>FECHA</th>
					<th>HORA</th>
					<th>AP</th>
					<th>MJ</th>
					<th>G</th>
					<th>GA</th>
					<th>A</th>
					<th>AA</th>
					<th>R</th>
					<th>LOCAL</th>
					<th>RESULTADO</th>
					<th>VISITA</th>
					<th>RIVAL</th>
					<th>CAMPEONATO</th>
				</tr>
			</thead>
			<tbody>
				@foreach($alineaciones as $alineacion)
				<tr>
					<td>{{date('d-m-Y', strtotime($alineacion->partido->fecha))}}</td>
					<td>{{date('H:i', strtotime($alineacion->partido->fecha))}}</td>
					<td>{{$alineacion->AP}}</td>
					<td>{{$alineacion->minutos_jugados}}</td>
					<td>{{$alineacion->goles}}</td>
					<td>{{$alineacion->goles_acumulados}}</td>
					<td>{{$alineacion->amarillas}}</td>
					<td>{{$alineacion->doblesamarillas}}</td>
					<td>{{$alineacion->rojas}}</td>
					<td>{{$alineacion->partido->equipoLocal->nombre}}</td>
					<td>
						<a href="{{route('ficha',$alineacion->partido->id)}}">{{$alineacion->partido->goles_local}} - {{$alineacion->partido->goles_visita}}</a>
					</td>
					<td>{{$alineacion->partido->equipoVisita->nombre}}</td>
					<td>
						<a href="{{route('partidos_jugadores',[$ligaId,$jugadorId,0,$alineacion->rival->id,0])}}">{{$alineacion->rival->nombre}}</a>
					</td>
					<td>
						<a href="{{route('partidos_jugadores',[$ligaId,$jugadorId,0,0,$alineacion->partido->campeonato_id])}}">{{$alineacion->partido->campeonato->nombre}}</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
     
    <hr>

    <ul>
        <li><b>AP:</b> Apariciones | 
            <b>A:</b> Amarillas | 
            <b>AA:</b> Dobles Amarillas | 
            <b>G:</b> Goles | 
            <b>GA:</b> Goles Acumulados | 
            <b>MJ:</b> Minutos Jugados |
            <b>R:</b> Rojas .
        </li>
        <li>Haga click sobre el resultado para ver la ficha del partido.</li>
        <li>Haga click sobre el nombre del rival para ver todos los partidos en los que
            participó el jugador contra dicho equipo.</li>
        <li>Haga click sobre el nombre del campeonato para ver todos los partidos en los que
            participó el jugador en dicho campeonato.</li>
        <li>Haga click sobre el nombre del equipo para ver todos los partidos en los que
            participó el jugador con dicho equipo.</li>
    </ul>


@stop
@section('js')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('#partidos').dataTable({
   			"bSort" : false
   		});
	});
</script>
<script>

	$(function(){

		$('#form').submit(function(){
			return false;
		})

		$('#jugador').autocomplete({
		    source: "{{route('inicio')}}/Jugadores-Liga/{{$ligaId}}",
		    dataType: 'json',
		    type: 'GET',
		    select: function(event, ui) {
		    	console.log(ui.item);
			  	$('#jugador').val(ui.item.label);
			  	$('#jugadorId').val(ui.item.id);
			}

		});
	});

	function consultar()
	{
		var jugadorId = $('#jugadorId').val();
		if(jugadorId == '') jugadorId = 0;
		var url = "{{route('inicio')}}/Estadisticas/PartidosXJugador/{{$ligaId}}/"+jugadorId+"/{{$equipoId}}/{{$rivalId}}/{{$campeonatoId}}";
		window.location = url;
	}
</script>

@stop

