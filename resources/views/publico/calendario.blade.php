@extends('layouts.publico')

@section('css')

@if($configuracion->parametro3)
 <meta http-equiv="refresh" content="{{$configuracion->parametro1}};">
@endif

@stop

@section('content')

<div class="portlet portlet-default">
	<div class="portlet-heading">
		<div class="portlet-title">
			<h4>Calendario - {{$campeonato->nombre}}</h4>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-lg-6">
				{!! Field::select('campeonato',$campeonatos,$campeonato->id,['id'=>'campeonato']) !!}
				<div class="form-group">
					<label for="completo">Calendario completo</label>	
					<input name="completo" type="checkbox" value="1">
				</div>
			</div>
		</div>
		<br/><br/>
		<div class="table-responsive">
			<table class="table watermark">
				<thead>
					<tr>
						<th class="text-center default">FECHA</th>
						<th class="text-center default">HORA</th>
						<th class="text-center default">LOCAL</th>
						<th class="text-center default">RESULTADO</th>
						<th class="text-center default">VISITA</th>
					</tr>
				</thead>
				<tbody>
					@foreach($jornadas as $jornada)
						<tr>
							<td colspan="5" class="default text-center bold" style="color: white;">{{$jornada['jornada']->nombre}}</td>
						</tr>
						@foreach($jornada['partidos'] as $partido)
						<tr>
							<td class="text-center">{{date('d-m-Y',strtotime($partido->fecha))}}</td>
							<td class="text-center">{{date('H:i',strtotime($partido->fecha))}}</td>
							<td class="text-center">{{$partido->equipo_local->nombre}}</td>
							<td class="text-center">
								<a href="{{route('ficha',$partido->id)}}" class="text-default" style="text-decoration: none; font-weight: bold" >
									@if(!is_null($partido->goles_local))
										{{$partido->goles_local}} - {{$partido->goles_visita}}
									@else
										Ver ficha
									@endif
								</a>
							</td>
							<td class="text-center">{{$partido->equipo_visita->nombre}}</td>
						</tr>
						@endforeach
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop

@section('js')

<script>
	$(function(){

		

		@if($completo != 0)

			$('input').prop('checked','true');

		@endif



		$('select, input').on('change', function () {

			check = $('input').prop('checked') ? 1 : 0;
			
          	var url = '{{route("inicio")}}/calendario/{{$campeonato->liga_id}}/'+$('#campeonato').val()+'/'+ check;
          	if (url) { // require a URL
            	window.location = url; // redirect
          	}
          	return false;
      	});

	})
</script>

@stop