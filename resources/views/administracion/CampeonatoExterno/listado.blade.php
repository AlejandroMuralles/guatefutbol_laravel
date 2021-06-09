@extends('layouts.admin')
@section('title') Campeonatos Externos @stop
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop
@section('content')
<div class="table-responsive">
	<a href="{{route('agregar_campeonato_externo')}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBBRE LIGA</th>
				<th>NOMBRE</th>
                <th>LINK</th>
				<th>ESTADO</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($campeonatos as $campeonato)
			<tr>
				<td>{{$campeonato->nombre_liga}}</td>
				<td>{{$campeonato->nombre}}</td>
				<td>{{$campeonato->link}}</td>
				<td>{{$campeonato->descripcion_estado}}</td>
				<td>
					<a href="{{route('editar_campeonato_externo',$campeonato->id)}}" class="btn btn-warning btn-flat btn-xs">Editar</a>
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