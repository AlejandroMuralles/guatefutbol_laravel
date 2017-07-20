@extends('layouts.admin')

@section('title') Listado de Tablas Acumuladas - {{$liga->nombre}} @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_tabla_acumulada',$liga->id)}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>CAMPEONATO 1</th>
				<th>CAMPEONATO 2</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($tablasAcumuladas as $tablaAcumulada)
			<tr>
				<td>{{$tablaAcumulada->campeonato1->nombre}}</td>
				<td>{{$tablaAcumulada->campeonato2->nombre}}</td>
				<td>
					<a href="{{route('editar_tabla_acumulada',$tablaAcumulada->id)}}" class="btn btn-warning btn-flat btn-xs">
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