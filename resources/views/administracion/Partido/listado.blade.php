@extends('layouts.admin')

@section('title') Partidos del Campeonato {{$campeonato->nombre}}@stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')

<div class="row">
	<div class="col-lg-4">
		{!! Field::select('jornada',$jornadas,null,['id'=>'jornada']) !!}	
	</div>
</div>
	

<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>FECHA</th>
				<th>HORA</th>
				<th>LOCAL</th>
				<th></th>
				<th>VISITA</th>
				<th>JORNADA</th>
				<th>ESTADIO</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($partidos as $partido)
			<tr class="{{$partido->jornada_id}}">
				<td>{{date('d-m-Y', strtotime($partido->fecha))}}</td>
				<td>{{date('H:i', strtotime($partido->fecha))}}</td>
				<td>{{$partido->equipo_local->nombre}}</td>				
				<td>{{$partido->goles_local}} - {{$partido->goles_visita}} </td>
				<td>{{$partido->equipo_visita->nombre}}</td>
				<td>{{$partido->jornada->nombre}}</td>
				<td>{{$partido->estadio->nombre}}</td>
				<td>
					<a href="{{route('editar_partido_campeonato',$partido->id)}}" class="btn btn-danger btn-flat btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar">
						<i class="fa fa-edit"></i>
					</a>
					<!--<a href="{{route('monitorear',$partido->id)}}" class="btn bg-navy btn-flat btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Monitorear">
						<i class="fa fa-gear"></i>
					</a>-->
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<a href="{{route('campeonatos',$campeonato->liga_id)}}" class="btn btn-danger btn-flat">
		Regresar
	</a>
</div>

@stop

@section('js')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script>
	$(document).ready(function() {
   		/*$('table').dataTable({
   			"bSort" : true
   		});*/

   		$('#jornada').on('change',function()
   		{
   			if($(this).val()==''){
   				$('tr').show()	
   			}
   			else{
   				$('tbody tr').hide()
   				$('tbody tr.'+$(this).val()).show();
   			}
   		});

	});
</script>
@stop