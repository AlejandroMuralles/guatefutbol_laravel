@extends('layouts.admin')

@section('title') Partidos por Equipo @stop
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')

	{!! Form::open(['route' => ['partidos_arbitro_campeonato',$ligaId,0], 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form', 'id'=>'form']) !!}

	if($campeonatoId != 0)
		<h3>{{$arbitro->nombreCompleto}} en el Campeonato {{$campeonato}}</h3>
		<hr>
	@else

		@if($arbitro)
			{!! Field::text('arbitro', $arbitro->nombreCompleto , ['id'=>'arbitro']) !!}
		@else
			{!! Field::text('arbitro', null, ['id'=>'arbitro']) !!}
		@endif

		<input type="hidden" id="arbitroId" value="">
        <p>
            <a href="#" onclick="consultar(); return false;" class="btn btn-primary btn-flat">Buscar</a>
        </p>

	@endif



	{!! Form::close() !!}

	<div class="table-responsive">
		<table class="table table-responsive">
			<thead>
				<tr>
					<th>ARBITRO</th>
					<th>AP</th>
					<th>G</th>
					<th>A</th>
					<th>AA</th>
					<th>R</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				@if($arbitro)
					<td>
						<a href="#">{{$arbitro->nombreCompleto}}</a>
					</td>
					<td>{{$totales->apariciones}}</td>
					<td>{{$totales->goles}}</td>
					<td>{{$totales->amarillas}}</td>
					<td>{{$totales->doblesamarillas}}</td>
					<td>{{$totales->rojas}}</td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>

	<div class="table-responsive">
		<table class="table table-responsive" id="partidos">
			<thead>
				<tr>
					<th>FECHA</th>
					<th>HORA</th>
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
					<td>{{$alineacion->partido->equipo_local->nombre}}</td>
					<td>
						<a href="{{route('ficha',$alineacion->partido->id)}}">{{$alineacion->partido->goles_local}} - {{$alineacion->partido->goles_visita}}</a>
					</td>
					<td>{{$alineacion->partido->equipo_visita->nombre}}</td>
					<td>
						<a href="{{route('partidos_arbitros',[$ligaId,$arbitroId,0,$alineacion->rival->id,0])}}">{{$alineacion->rival->nombre}}</a>
					</td>
					<td>
						<a href="{{route('partidos_arbitros',[$ligaId,$arbitroId,0,0,$alineacion->partido->campeonato_id])}}">{{$alineacion->partido->campeonato->nombre}}</a>
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
            participó el arbitro contra dicho equipo.</li>
        <li>Haga click sobre el nombre del campeonato para ver todos los partidos en los que
            participó el arbitro en dicho campeonato.</li>
        <li>Haga click sobre el nombre del equipo para ver todos los partidos en los que
            participó el arbitro con dicho equipo.</li>
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

		$('#arbitro').autocomplete({
		    source: "{{route('inicio')}}/Arbitro-Liga/{{$ligaId}}",
		    dataType: 'json',
		    type: 'GET',
		    select: function(event, ui) {
		    	console.log(ui.item);
			  	$('#arbitro').val(ui.item.label);
			  	$('#arbitroId').val(ui.item.id);
			}

		});
	});

	function consultar()
	{
		var arbitroId = $('#arbitroId').val();
		if(arbitroId == '') arbitroId = 0;
		var url = "{{route('inicio')}}/EstadisticasArbitro/Por-Liga/{{$ligaId}}/{{$campeonatoId}}";
		window.location = url;
	}
</script>

@stop
