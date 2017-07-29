@extends('layouts.publico')

@section('css')
<style>
	table.unbordered, .unbordered td, .unbordered th{
		border: none !important;
	}
	table, td, th { border: 1px solid white !important; }
</style>

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
		<div class="row">
			@foreach($jornadas as $jornada)
			<div class="col-lg-4 col-md-6">
				<div class="portlet portlet-default" style="margin-bottom: 15px !important">
					<div class="portlet-heading">
						<div class="portlet-title">
							<h4>{{$jornada['jornada']->nombre}}</h4>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="portlet-body" style="padding-bottom: 0px !important">
						<div class="table-responsive" style="border: none;">
							<table class="table table-responsive unbordered">
								@foreach($jornada['partidos'] as $partido)
								<tr>
									<td class="text-right" width="40%">
										{{$partido->equipo_local->nombre}}
										<img src="{{$partido->equipo_local->logo}}" height="25px" width="25px">
									</td>
									<td class="text-center default" style="color: white !important" width="20%">
										<a href="{{route('ficha',$partido->id)}}" class="text-white" style="text-decoration: none; font-weight: bold" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver Ficha" >
											@if($partido->estado != 1)
												{{$partido->goles_local}} - {{$partido->goles_visita}}
											@else
												<span style="font-size: 10px">
												{{date('d-m',strtotime($partido->fecha))}} / 
												{{date('H:i',strtotime($partido->fecha))}}
												</span>
											@endif
										</a>
									</td>
									<td class="text-left" width="40%">
										<img src="{{$partido->equipo_visita->logo}}" height="25px" width="25px">
										{{$partido->equipo_visita->nombre}}
									</td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<!--<div class="table-responsive">
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
		</div>-->
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