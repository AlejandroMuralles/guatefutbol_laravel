@extends('layouts.admin')

@section('title') Usuarios @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_usuario')}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<div class="table-respondive">
		<table id="tabla" class="table table-bordered">
			<thead>
				<tr>
					<th>USERNAME</th>
					<th>PERFIL</th>
					<th>ESTADO</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($usuarios as $usuario)
				<tr>
					<td>{{$usuario->username}}</td>
					<td>{{$usuario->perfil->nombre}}</td>
					<td>{{$usuario->descripcion_estado}}</td>
					<td>
						<a href="{{route('editar_usuario',$usuario->id)}}" class="btn btn-warning btn-flat btn-xs">
							Editar
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('#table').dataTable({
   			"bSort" : true
   		});
	});
</script>
@stop