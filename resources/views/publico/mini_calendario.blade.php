<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:regular,900,700,100&amp;greek-ext,latin" type="text/css">
		<link href="{{ asset('assets/public/css/estilos_minicalendario.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	</head>
	<body class="fondo" style="margin: 0; font-family: Roboto,sans-serif;">

		@foreach($jornadas as $jornada)
		<div>
			@foreach($jornada['partidos'] as $partido)
			<div class="soccer-recent-result">
				<div class="clubnames" style="font-size: 10px">
					<span>{{ date('d-m-Y', strtotime($partido->fecha)) }}</span>
					<span class="pull-right">{{ date('H:i', strtotime($partido->fecha)) }}</span>
				</div>
				<div class="soccer-recent-result-item">
					<div class="soccer-recent-result-list" style="width: 36%; padding-left: 3px">
						<img src="{{asset('assets/imagenes/equipos/')}}/{{ $partido->equipoLocal->imagen }}"> {{ $partido->equipoLocal->nombre }}
					</div>
					@if(!is_null($partido->goles_local))
					<div class="text-center soccer-recent-result-list" style="width: 25%">
						<span class="goal">{{ $partido->goles_local }}</span> - <span class="goal">{{ $partido->goles_visita }}</span>
					</div>
					@else
					<div class="text-center soccer-recent-result-list" style="width: 25%">
						-
					</div>
					@endif
					<div class="text-center soccer-recent-result-list" style="width: 36%">
						{{ $partido->equipoVisita->nombre }} <img src="{{asset('assets/imagenes/equipos/')}}/{{ $partido->equipoVisita->imagen }}">
					</div>
				</div>
			</div> 
			@endforeach
		</div>
		@endforeach
		<input type="hidden" value="{{$campeonato->id}}" id="campeonatoId">
		<input type="hidden" value="{{$campeonato->liga_id}}" id="ligaId">

		@if($configuracion->parametro3)
			<input type="hidden" value="{{$configuracion->parametro1}}" id="tiempo">			
		@else
			<input type="hidden" value="0" id="tiempo">
		@endif

	</body>
</html>