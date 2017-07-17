@extends('layouts.publico')

@section('css')
<link href="{{ asset('assets/public/css/plugins/datatables/datatables.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')

<div class="portlet portlet-default">
	<div class="portlet-heading">
		<div class="portlet-title">
			<h4>Plantilla @if(!is_null($equipo)) - {{$equipo->nombre}} @endif</h4>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-lg-6">
				{!! Field::select('campeonato',$campeonatos,$campeonato->id,['id'=>'campeonato']) !!}
				{!! Field::select('equipo',$equipos,$equipoId,['id'=>'equipo']) !!}
			</div>
		</div>
		<br/><br/>
		<div class="table-responsive">
			<table class="table watermark">
				<thead>
					<tr class="text-center">
						<th class="text-center gray-gradient">JUGADOR</th>
						<th class="text-center gray-gradient">E</th>
						<th class="text-center gray-gradient">LN</th>
						<th class="text-center gray-gradient">AP</th>
						<th class="text-center gray-gradient">MJ</th>
						<th class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/gol.png')}}" alt=""></th>
						<th class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/amarilla.png')}}" alt=""></th>
						<th class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/dobleAmarilla.png')}}" alt=""></th>
						<th class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/roja.png')}}" alt=""></th>
					</tr>
				</thead>
				<tbody>
					@foreach($plantilla as $jugador)
					<tr>
						<td>{{$jugador->nombreCompletoApellidos}}</td>
						<td class="text-center">{{$jugador->edad}}</td>
						<td class="text-center">
							@if(is_null($jugador->departamento))
								{{$jugador->pais->nombre}}
							@else
								{{rtrim($jugador->departamento->nombre, ",")}}
							@endif
						</td>
						<td class="text-center">{{$jugador->apariciones}}</td>
						<td class="text-center">{{$jugador->minutos_jugados}}</td>
						<td class="text-center">{{$jugador->goles}}</td>
						<td class="text-center">{{$jugador->amarillas}}</td>
						<td class="text-center">{{$jugador->doblesamarillas}}</td>
						<td class="text-center">{{$jugador->rojas}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/public/js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/public/js/plugins/datatables/datatables-bs3.js') }}" type="text/javascript"></script>
<script>
	$(function(){

		$('.table').dataTable({
			"bSort" : false,
			"bPaginate": false,
			"bFilter": false, 
			"bInfo": false,
   			"iDisplayLength" : 20,
		});

		$('select').on('change', function () {
			var campeonato = $('#campeonato').val() != '' ? $('#campeonato').val() : 0;
			var equipo = $('#equipo').val() != '' ? $('#equipo').val() : 0;
          	var url = '{{route("inicio")}}/plantilla/{{$campeonato->liga_id}}/'+ campeonato + "/" + equipo;
          	if (url) { // require a URL
            	window.location = url; // redirect
          	}
          	return false;
      });

	})
</script>

@stop