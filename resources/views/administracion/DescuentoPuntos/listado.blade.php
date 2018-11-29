@extends('layouts.admin')
@section('title') Listado de Descuento de Puntos - {{$liga->nombre}} @endsection
@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="table-responsive">
	<a href="{{route('agregar_descuento_puntos',[$liga->id,0])}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>CAMPEONATO</th>
				<th>EQUIPO</th>
				<th>TIPO</th>
				<th>PUNTOS</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($descuentos as $descuento)
			<tr>
				<td>{{$descuento->campeonato->nombre}}</td>
				<td>{{$descuento->equipo->nombre}}</td>
				<td>{{$descuento->descripcion_tipo}}</td>
				<td>{{$descuento->puntos}}</td>
				<td>
					<a href="{{route('editar_descuento_puntos',$descuento->id)}}" class="btn btn-warning btn-flat btn-xs">
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
   		$('#tabla').dataTable({
   			"bSort" : true
   		});
	});
</script>
@stop