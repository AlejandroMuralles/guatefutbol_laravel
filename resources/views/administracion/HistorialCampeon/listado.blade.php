@extends('layouts.admin')

@section('title') Campeones @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="table-responsive">
	<a href="{{route('agregar_historial_campeon')}}" class="btn bg-navy btn-flat">Agregar</a>
	<hr>
	<table id="tabla" class="table watermark" >
		<thead>
			<tr>
				<th class="text-center gray-gradient">FECHA</th>
				<th class="text-center gray-gradient">CAMPEONATO</th>
				<th class="text-center gray-gradient">EQUIPO CAMPEON</th>
				<th class="text-center gray-gradient">V</th>
				<th class="text-center gray-gradient">ENTRENADOR</th>
				<th class="text-center gray-gradient">V</th>
				<th class="text-center gray-gradient">EQUIPO SUBCAMPEON</th>
				<th class="text-center gray-gradient"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($campeones as $campeon)
			<tr>
				<td class="text-center">{{date('d-m-Y', strtotime($campeon->fecha))}}</td>						
				<td class="text-center">{{$campeon->campeonato}}</td>
				<td class="text-center">{{$campeon->equipo_campeon}}</td>
				<td class="text-center">{{$campeon->veces_equipo}}</td>
				<td class="text-center">{{$campeon->entrenador_campeon}}</td>
				<td class="text-center">{{$campeon->veces_entrenador}}</td>
				<td class="text-center">{{$campeon->equipo_subcampeon}}</td>
				<td>
					<a href="{{route('editar_historial_campeon',$campeon->id)}}" class="btn btn-warning btn-flat btn-xs">
						<i class="fa fa-edit"></i>
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