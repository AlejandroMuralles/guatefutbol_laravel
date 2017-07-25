@extends('layouts.admin')

@section('title') Editar Alineación - {{$equipo->nombre}} @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
<style>
	tr:hover {
    	background-color: #3c8dbc;
    	color: white;
	}
</style>
@stop
@section('content')

<div class="table-responsive">
	{!! Form::open(['route' => array('editar_alineacion',$partidoId,$eventoId,$equipoId), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}

	{!! Field::select('tecnico_id', $tecnicos,$tecnicoId,['data-required'=>'false']) !!}

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th>TITULAR</th>
				<th>SUPLENTE</th>
			</tr>
		</thead>
		<tbody>
			@foreach($jugadores as $jugador)
			<tr>
				<td>{{$jugador->nombreCompletoApellidos}}</td>
				<td>
					@if($jugador->inicia)
						<input type="checkbox" name="jugadores[{{$jugador->id}}][inicia]" checked >
					@else
						<input type="checkbox" name="jugadores[{{$jugador->id}}][inicia]" >
					@endif
				</td>
				<td>
					@if($jugador->suplente)
						<input type="checkbox" name="jugadores[{{$jugador->id}}][suplente]" checked>
					@else
						<input type="checkbox" name="jugadores[{{$jugador->id}}][suplente]"  >
					@endif
					<input type="hidden" name="jugadores[{{$jugador->id}}][id]" value="{{$jugador->id}}">
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<input type="submit" value="Agregar" class="btn btn-primary btn-flat">
	<a href="{{ route('monitorear_jornada',[$partido->campeonato->liga_id, $partido->campeonato_id,$partido->jornada_id,$partido->id,$equipoId]) }}" class="btn btn-danger btn-flat">Cancelar</a>

	{!! Form::close() !!}
</div>

@stop
@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		/*$('table').dataTable({
   			"bSort" : true,
   			"aaSorting" : [[1, 'asc']]
   		});*/

	});
</script>
@stop