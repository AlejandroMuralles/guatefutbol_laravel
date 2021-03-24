@extends('layouts.admin')
@section('title') Campeonatos de Tabla Acumulada - {{$tablaAcumuladaLiga->descripcion}} @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="table-responsive">
	<a href="{{route('agregar_tabla_acumulada_liga_detalle',$tablaAcumuladaLiga->id)}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>CAMPEONATO</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($campeonatos as $campeonato)
			<tr>
				<td>{{$campeonato->campeonato->nombre}}</td>
				<td></td>
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