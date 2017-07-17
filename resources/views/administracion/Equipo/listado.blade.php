@extends('layouts.admin')

@section('title') Listado de Equipos @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_equipo')}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th>NOMBRE CORTO</th>
				<th>SIGLAS</th>
				<th>IMAGEN</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($equipos as $equipo)
			<tr>
				<td>{{$equipo->nombre}}</td>
				<td>{{$equipo->nombre_corto}}</td>
				<td>{{$equipo->siglas}}</td>
				<td><img src="{{$equipo->logo}}" style="width: 25px; height: 25px"></td>
				<td>
					<a href="{{route('editar_equipo',$equipo->id)}}" class="btn btn-warning btn-flat btn-xs">
						Editar
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('table').dataTable({
   			"bSort" : true
   		});
	});
</script>
@stop