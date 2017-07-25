@extends('layouts.admin')

@section('title') Configuraciones @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="table-responsive">
	<!--<a href="{{route('agregar_configuracion')}}" class="btn bg-navy btn-flat">Agregar</a>-->
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th>PARAMETRO 1</th>
				<th>PARAMETRO 2</th>
				<th>PARAMETRO 3</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($configuraciones as $configuracion)
			<tr>
				<td>{{$configuracion->nombre}}</td>
				<td>{{$configuracion->parametro1}}</td>
				<td>{{$configuracion->parametro2}}</td>
				<td>{{$configuracion->parametro3}}</td>
				<td>
					<a href="{{route('editar_configuracion',$configuracion->id)}}" class="btn btn-warning btn-flat btn-xs">
						<i class="fa fa-edit"></i>
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
   			"bSort" : false
   		});
	});
</script>
@stop