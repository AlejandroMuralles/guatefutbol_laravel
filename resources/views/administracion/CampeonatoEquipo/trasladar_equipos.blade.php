@extends('layouts.admin')

@section('title') Trasladar Equipos de Campeonato @stop

@section('css')
<link href="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
@stop

@section('content')
<h3>Campeonato {{$campeonato->nombre}}</h3>

{!! Form::open(['route' => array('trasladar_equipos_campeonato',$campeonato->id,$campeonatoAntiguo), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
<div class="row">
	<div class="col-lg-6">
		{!! Field::select('campeonato_id',$campeonatos,$campeonatoAntiguo,['required'=>'true','id'=>'campeonatoId']) !!}
	</div>
</div>
<div class="row">
	<div class="col-lg-6">
		{!! Field::checkbox('incluir_personas') !!}
	</div>
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-responsive" id="tablaEquipos">
				<thead>
					<th></th>
					<th>NOMBRE</th>
				</thead>
				<tbody>
					@foreach($equipos as $equipo)
						<tr>
							<td style="width: 25px">
								<input type="checkbox" name="equipos[{{$equipo->equipo->id}}][seleccionado]">
								<input type="hidden" name="equipos[{{$equipo->equipo->id}}][id]" value="{{$equipo->equipo->id}}">
							</td>
							<td>{{$equipo->equipo->nombre}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<input type="submit" value="Trasladar" class="btn btn-primary btn-flat">
		<a href="{{route('campeonatos',$campeonato->liga_id)}}" class="btn btn-danger btn-flat">Regresar</a>
	</div>
</div>

@stop

@section('js')

<script>
	$(function(){

		$('#campeonatoId').on('change',function(){
			window.location.href = "{{route('inicio')}}"+"/CampeonatoEquipo/trasladar-equipos/{{$campeonato->id}}/" + $(this).val();
		})

	})
</script>

@stop