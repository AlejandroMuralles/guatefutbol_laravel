@extends('layouts.admin')

@section('title') Paises @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop


@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_pais')}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($paises as $pais)
			<tr>
				<td>{{$pais->nombre}}</td>
				<td>
					<a href="{{route('editar_pais',$pais->id)}}" class="btn btn-warning btn-flat btn-xs">
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