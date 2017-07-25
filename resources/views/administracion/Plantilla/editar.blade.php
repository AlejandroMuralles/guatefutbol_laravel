@extends('layouts.admin')

@section('title') Editar Personas de Equipo de Campeonato @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')
<h3>Campeonato {{$campeonatoEquipo->campeonato->nombre}} - {{$campeonatoEquipo->equipo->nombre}} </h3>
<div class="table-responsive">
	{!! Form::open(['route' => array('editar_personas_equipo',$campeonatoEquipo->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	<table class="table table-bordered">
		<thead>
			<tr>
				<th></th>
				<th>NOMBRE</th>		
				<th></th>		
			</tr>
		</thead>
		<tbody>
			@foreach($personas as $persona)
			<tr>
				<td>
					<input type="checkbox" name="personas[{{$persona->id}}][seleccionado]">
					<input type="hidden" name="personas[{{$persona->id}}][id]" value="{{$persona->id}}">
				</td>
				<td>{{$persona->persona->nombreCompletoApellidos}}</td>
				<td>{{$persona->persona->descripcion_rol}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<input type="submit" value="Eliminar" class="btn btn-primary btn-flat">
	<a href="{{route('editar_equipos_campeonato',$campeonatoEquipo->campeonato_id)}}" class="btn btn-danger btn-flat">
		Regresar
	</a>
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
