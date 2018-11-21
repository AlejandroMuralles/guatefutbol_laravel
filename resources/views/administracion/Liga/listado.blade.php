@extends('layouts.admin')

@section('title') Ligas @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_liga')}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table id="tabla" class="table table-bordered">
		<thead>
			<tr>
				<th>NOMBRE</th>
				<th>ORDEN</th>
				<th>MOSTRAR APP</th>
				<th>ESTADO</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($ligas as $liga)
			<tr>
				<td>{{$liga->nombre}}</td>
				<td>{{$liga->orden}}</td>
				<td>{!! $liga->descripcion_mostrar_app !!}</td>
				<td>{{$liga->descripcion_estado}}</td>
				<td>
					<a href="{{route('editar_liga',$liga->id)}}" class="btn btn-warning btn-flat btn-xs">
						Editar
					</a>
					<a href="{{route('campeonatos',$liga->id)}}" class="btn btn-info btn-flat btn-xs">
						Campeonatos
					</a>
					<a href="{{route('tablas_acumuladas',$liga->id)}}" class="btn btn-info btn-flat btn-xs">
						Tablas Acumuladas
					</a>
					<a href="{{route('agregar_campeonato',$liga->id)}}" class="btn bg-navy btn-flat btn-xs">
						Agregar Campeonato
					</a>
					<a href="{{route('partidos_equipos',[$liga->id,0,0])}}" class="btn bg-orange btn-flat btn-xs">
						Partidos por Equipo
					</a>
					<a href="{{route('partidos_jugadores',[$liga->id,0,0,0,0])}}" class="btn bg-green btn-flat btn-xs">
						Jugador
					</a>
					<a href="{{route('estadisticas_jugadores',[$liga->id,-1])}}" class="btn bg-green btn-flat btn-xs">
						Jugadores
					</a>
					<a href="{{route('dashboard_admin_estadisticas_arbitros',$liga->id)}}" class="btn bg-green btn-flat btn-xs">
						Arbitros
					</a>
					<a href="{{route('posiciones_liga',$liga->id)}}" class="btn bg-green btn-flat btn-xs">
						Posiciones
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