@extends('layouts.admin')

@section('title') Departamentos @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop


@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_departamento')}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th>PAIS</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($departamentos as $departamento)
			<tr>
				<td>{{$departamento->nombre}}</td>
				<td>{{$departamento->pais->nombre}}</td>
				<td>
					<a href="{{route('editar_departamento',$departamento->id)}}" class="btn btn-warning btn-flat btn-xs">
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
   		$('#table').dataTable({
   			"bSort" : true
   		});
	});
</script>
@stop