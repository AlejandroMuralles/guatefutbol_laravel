@extends('layouts.admin')

@section('title') Editar Equipos de Campeonato @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')
<h3>Campeonato {{$campeonato->nombre}}</h3>
<a href="{{route('trasladar_equipos_campeonato', [$campeonato->id, 0])}}" class="btn btn-info btn-flat btn-xs">
	<i class="fa fa-edit"></i> Trasladar Equipos
</a>
<br/><br/>
<div class="table-responsive">
	{!! Form::open(['route' => array('editar_equipos_campeonato',$campeonato->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	<table class="table table-bordered">
		<thead>
			<tr>
				<th width="15px"></th>
				<th>NOMBRE</th>	
				<th></th>			
			</tr>
		</thead>
		<tbody>
			@foreach($equipos as $equipo)
			<tr>
				<td>
					<input type="checkbox" name="equipos[{{$equipo->id}}][seleccionado]">
					<input type="hidden" name="equipos[{{$equipo->id}}][id]" value="{{$equipo->id}}">
				</td>
				<td>{{$equipo->equipo->nombre}}</td>
				<td>
					<a href="{{route('agregar_personas_equipo', $equipo->id)}}" class="btn btn-info btn-flat btn-xs">
						<i class="fa fa-plus"></i> Personas
					</a>
					<a href="{{route('editar_personas_equipo', $equipo->id)}}" class="btn btn-warning btn-flat btn-xs">
						<i class="fa fa-edit"></i> Personas
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<input type="submit" value="Eliminar" class="btn btn-primary btn-flat">
	<a href="{{route('campeonatos',$campeonato->liga_id)}}" class="btn btn-danger btn-flat">
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
   		$('table').dataTable({
   			"bSort" : true,
   			"aaSorting" : [[1, 'asc']]
   		});
	});
</script>
@stop