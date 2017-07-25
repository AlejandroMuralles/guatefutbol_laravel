@extends('layouts.admin')

@section('title') Perfiles @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_perfil')}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($perfiles as $perfil)
			<tr>
				<td>{{$perfil->nombre}}</td>
				<td>
					<a href="{{route('editar_perfil',$perfil->id)}}" class="btn btn-warning btn-flat btn-xs">
						Editar
					</a>
					<a href="{{route('permisos',$perfil->id)}}" class="btn btn-info btn-flat btn-xs">
						Permisos
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