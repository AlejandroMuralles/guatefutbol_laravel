@extends('layouts.admin')

@section('title') Modulos @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_modulo')}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($modulos as $modulo)
			<tr>
				<td>{{$modulo->nombre}}</td>
				<td>
					<a href="{{route('editar_modulo',$modulo->id)}}" class="btn btn-warning btn-flat btn-xs">
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