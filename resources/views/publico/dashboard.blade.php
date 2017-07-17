@extends('layouts.publico')

@section('title') Central de Partidos @stop

@section('css')
@if($configuracion->parametro3)
 <meta http-equiv="refresh" content="{{$configuracion->parametro1}};">
@endif
<style>
	table td{
		border: none !important;
	}
	tr:nth-child(even) {background: rgba(0, 102, 153, 0.17) !important}
	a:hover { text-decoration: none; color: white; }
</style>
@stop

@section('content')

<div class="portlet portlet-default">
	<div class="portlet-heading">
		@if($configuracion->parametro3)
		<div class="portlet-title" style="float: right;">
			<h4><i class="fa fa-refresh"></i> <span id="txtActualizar"></span></h4>
		</div>
		@endif
		<div class="portlet-title">
			<h4>Central de Partidos - {{$campeonato->nombre}}</h4>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="portlet-body">
		@foreach($partidos as $partido)
		<div class="row">
			<div class="col-lg-12">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th colspan="2" class="default">
								@if($partido['partido']->estado_id == 1)
									{{date('d/m/y H:i', strtotime($partido['partido']->fecha))}}
								@else
									{{$partido['partido']->estado->nombre}}
								@endif
							</th>
						</tr>
						<tr>
							<th colspan="5">
								<a href="{{route('ficha',$partido['partido']->id)}}" style="color: white; ">
									<img src="{{asset('assets/imagenes/equipos')}}/{{$partido['partido']->equipoLocal->imagen}}" width="25px">
									{{$partido['partido']->equipoLocal->nombre}} {{$partido['partido']->goles_local}} - 
									{{$partido['partido']->goles_visita}} {{$partido['partido']->equipoVisita->nombre}} 	
									<img src="{{asset('assets/imagenes/equipos')}}/{{$partido['partido']->equipoVisita->imagen}}" width="25px">
								</a>
							</th>
						</tr>
					</thead>
					<tbody>
					@foreach($partido['eventos'] as $evento)
						<tr>
							<td class="text-center" style="width: 5% !important">{{$evento['minuto_local']}}</td>
							<td style="width: 40% !important">
								{{$evento['nombre_local']}}
							</td>
							<td class="text-center" style="width: 10% !important">{{$evento['resultado']}}</td>
							<td style="width: 40% !important; text-align: right">
								{{$evento['nombre_visita']}}
							</td>
							<td class="text-center" style="width: 5% !important">{{$evento['minuto_visita']}}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		@endforeach

	</div>
</div>

@stop
@section('js')
<script>

	var segundos = 0;

	$(function(){

		@if($configuracion->parametro3)
			segundos = {{$configuracion->parametro1}};
 			actualizar(); 			
		@endif
	});

    function actualizar(){
    	if(segundos > 0){
    		segundos = segundos - 1;
    		$('#txtActualizar').text(segundos);
    		setTimeout("actualizar()",1000) 
        }
    }
</script>
@stop