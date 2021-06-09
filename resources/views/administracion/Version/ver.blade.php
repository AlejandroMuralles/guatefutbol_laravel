@extends('layouts.admin')
@section('title') Versión App @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="table-responsive">
	@if(is_null($version))
	<a href="{{route('agregar_version')}}" class="btn bg-navy btn-flat">Agregar</a>
	@else   
	<a href="{{route('editar_version')}}" class="btn btn-warning btn-flat">Editar</a>
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>ANDROID</th>
				<th>IOS</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$version->android}}</td>
				<td>{{$version->ios}}</td>
			</tr>
		</tbody>
	</table>
	@endif
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