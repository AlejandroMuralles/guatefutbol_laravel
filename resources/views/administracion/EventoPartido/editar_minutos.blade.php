@extends('layouts.admin')
@section('title') Editar Minutos Jugados - {{$equipo->nombre}} @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')

<div class="table-responsive">
	{!! Form::open(['route' => array('editar_minutos_jugados',$partidoId,$equipoId), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th>TITULAR</th>
				<th>MINUTOS</th>
			</tr>
		</thead>
		<tbody>
			@foreach($alineacion as $jugador)
			<tr>
				<td>{{$jugador->persona->nombreCompletoApellidos}}</td>
				<td>
					<input type="hidden" name="jugadores[{{$jugador->id}}][id]" value="{{$jugador->id}}" >
					@if($jugador->es_titular)
						<i class="fa fa-check bg-green" style="border: none; border-radius: 5px; font-size: 16px; padding: 3px;"></i>
					@else
						<i class="fa fa-times bg-red" style="border: none; border-radius: 5px; font-size: 16px; padding: 3px;"></i>
					@endif
				</td>
				<td>					
					<input type="text" class="form-control" name="jugadores[{{$jugador->id}}][minutos_jugados]" value="{{$jugador->minutos_jugados}}">
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<input type="submit" value="Editar" class="btn btn-primary btn-flat">
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