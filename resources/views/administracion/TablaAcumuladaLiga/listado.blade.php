@extends('layouts.admin')
@section('title') Listado de Tablas Acumuladas - {{$liga->nombre}} @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_tabla_acumulada_liga',$liga->id)}}" class="btn bg-navy btn-flat">Agregar</a>
	<a href="{{route('ligas')}}" class="btn btn-danger btn-flat">Regresar</a>
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>DESCRIPCION</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($tablasAcumuladas as $tablaAcumulada)
			<tr>
				<td>{{$tablaAcumulada->descripcion}}</td>
				<td>
					<a href="{{route('editar_tabla_acumulada_liga',$tablaAcumulada->id)}}" class="btn btn-warning btn-flat btn-xs">
						Editar
					</a>
					<a href="{{route('tablas_acumuladas_ligas_detalle',$tablaAcumulada->id)}}" class="btn btn-info btn-flat btn-xs">
						Campeonatos
					</a>
					<a href="{{route('ver_tabla_acumulada_liga',$tablaAcumulada->id)}}" class="btn bg-navy btn-flat btn-xs">
						Ver Tabla
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection

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
@endsection