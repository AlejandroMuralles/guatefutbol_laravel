@extends('layouts.admin')

@section('title') Campeonatos de {{$liga->nombre}}@stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_campeonato',$liga->id)}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th>FECHA INICIO</th>
				<th>FECHA FIN</th>
				<th>HASHTAG</th>
				<th>ESTADO</th>
				<th>ACTUAL</th>
				<th>MOSTRAR APP</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($campeonatos as $campeonato)
			<tr>
				<td>{{$campeonato->nombre}}</td>
				<td>{{date('d/m/Y',strtotime($campeonato->fecha_inicio))}}</td>
				<td>{{date('d/m/Y',strtotime($campeonato->fecha_fin))}}</td>
				<td>{{$campeonato->hashtag}}</td>
				<td> {{$campeonato->descripcion_estado}} </td>
				<td> {!! $campeonato->descripcion_actual !!} </td>
				<td> {!! $campeonato->descripcion_mostrar_app !!} </td>
				<td>
					<a href="{{route('editar_campeonato',$campeonato->id)}}" class="btn btn-warning btn-flat btn-xs">
						<i class="fa fa-edit"></i>
					</a>
					<a href="{{route('agregar_equipo_campeonato',$campeonato->id)}}" class="btn btn-info btn-flat btn-xs">
						<i class="fa fa-plus"></i> Equipos
					</a>
					<a href="{{route('editar_equipos_campeonato',$campeonato->id)}}" class="btn btn-danger btn-flat btn-xs">
						<i class="fa fa-edit"></i> Equipos
					</a>
					<a href="{{route('agregar_partido_campeonato',$campeonato->id)}}" class="btn bg-navy btn-flat btn-xs">
						<i class="fa fa-plus"></i> Partido
					</a>
					<a href="{{route('partidos_campeonato',$campeonato->id)}}" class="btn btn-danger btn-flat btn-xs">
						<i class="fa fa-edit"></i> Partidos
					</a>
					<a href="{{route('agregar_jornada_campeonato',[$campeonato->id,0])}}" class="btn btn-danger btn-flat btn-xs">
						<i class="fa fa-edit"></i> Agregar Jornada
					</a>
					<a href="{{route('editar_jornada_campeonato',[$campeonato->id,0])}}" class="btn btn-danger btn-flat btn-xs">
						<i class="fa fa-edit"></i> Editar Jornada
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<a href="{{route('ligas')}}" class="btn btn-danger btn-flat">
		Regresar
	</a>
</div>

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		$('table').dataTable({
   			"bSort" : false
   		});
	});
</script>
@stop