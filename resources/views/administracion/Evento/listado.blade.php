@extends('layouts.admin')
@section('title') Listado de Eventos @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="table-responsive">
	<table id="table" class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th>IMAGEN</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($eventos as $evento)
			<tr>
				<td>{{$evento->nombre}}</td>
				<td><img src="{{$evento->imagen}}" style="width: 25px; height: 25px"></td>
				<td>
					<a href="{{route('editar_evento',$evento->id)}}" class="btn btn-warning btn-flat btn-xs">
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