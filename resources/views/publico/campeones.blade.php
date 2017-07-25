@extends('layouts.publico')

@section('css')
<link href="{{ asset('assets/css/plugins/datatables/datatables.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')

<div class="portlet portlet-default">
	<div class="portlet-heading">
		<div class="portlet-title">
			<h4>Tabla de Campeones </h4>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="portlet-body">
		<center>
			<a href="{{route('posiciones',[$campeonato->liga,$campeonato->id])}}" 
				class="btn btn-gray btn-sm gray-gradient round-border">Tabla de Posiciones</a>
			<a href="{{route('goleadores',[$ligaId, $campeonato->id])}}" 
				class="btn btn-gray btn-sm gray-gradient round-border">Tabla de Goleadores</a>
			<a href="{{route('porteros',[$ligaId,$campeonato->id])}}" 
				class="btn btn-gray btn-sm gray-gradient round-border">Tabla de Guardametas</a>
		</center>
		<br/><br/>
		<div class="table-responsive">
			<table class="table watermark" >
				<thead>
					<tr>
						<th class="text-center gray-gradient">CAMPEONATO</th>
						<th class="text-center gray-gradient">EQUIPO CAMPEON</th>
						<th class="text-center gray-gradient">V</th>
						<th class="text-center gray-gradient">ENTRENADOR</th>
						<th class="text-center gray-gradient">V</th>
						<th class="text-center gray-gradient">EQUIPO SUBCAMPEON</th>
					</tr>
				</thead>
				<tbody>
					@foreach($campeones as $campeon)
					<tr>						
						<td class="text-center">{{$campeon->campeonato}}</td>
						<td class="text-center">{{$campeon->equipo_campeon}}</td>
						<td class="text-center">{{$campeon->veces_equipo}}</td>
						<td class="text-center">{{$campeon->entrenador_campeon}}</td>
						<td class="text-center">{{$campeon->veces_entrenador}}</td>
						<td class="text-center">{{$campeon->equipo_subcampeon}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop

@section('js')

<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/plugins/datatables/datatables-bs3.js') }}" type="text/javascript"></script>
<script>
	$(function(){

		$('table').dataTable({
			"bSort" : false,
			"bPaginate": true,
			"bFilter": true, 
			"bInfo": true,
   			"iDisplayLength" : 10,
		});

	});
</script>

@stop