@extends('layouts.publico')
@section('css')
@stop
@section('content')
<div class="dir-result">
	<div class="container">
		<div class="eq-local">
			<a class="nom-equip" href="#">
				<span class="escudo">
					<img height="50px" src="{{$partido->equipo_local->logo}}" >
				</span>
				<span class="nom" itemprop="name">{{$partido->equipo_local->nombre}} </span>
			</a>
		</div>
		<div class="marcador cf">
			<span class="tanteo-local">{{$partido->goles_local}}</span>
			<span class="tanteo-time" id="tiempoPartido"></span>
			<span class="tanteo-visit">{{$partido->goles_visita}}</span>
			@if(!is_null($partido->descripcion_penales)) <span class="tanteo-visit">({{$partido->descripcion_penales}})</span> @endif
		</div>
		<div class="eq-visit">
			<a class="nom-equip" href="#">
				<span class="escudo">
					<img height="50px" src="{{$partido->equipo_visita->logo}}" >
				</span>
				<span class="nom">{{$partido->equipo_visita->nombre}} </span>
			</a>
		</div>
	</div>
</div>
<br/>
@if($configuracion->parametro3)
	<h2 style="margin-top: 10px; float:right"><i class="fa fa-refresh"></i> <span id="txtActualizar"></span></h2>
@endif
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#ficha" >Ficha</a></li>
  <li ><a data-toggle="tab" href="#minuto" onclick="redirect();">Minuto a minuto</a></li>
</ul>
<div class="tab-content" style="font-size: 12px">
		<div id="ficha" class="tab-pane fade in active">
			<div class="row">
			<div class="col-lg-12">
				<center>
					<table>
						<tr>
							<td style="font-weight: bold; padding: 5px" class="bg-primary">Fecha: &nbsp;&nbsp;</td>
							<td style="padding: 5px; background-color: #B7E3F9">{{$partido->fecha}}</td>
						</tr>
						<tr>
							<td style="font-weight: bold; padding: 5px" class="bg-primary">Estadio: &nbsp;&nbsp;</td>
							<td style="padding: 5px; background-color: #B7E3F9">@if($partido->estadio) {{$partido->estadio->nombre}} @endif</td>
						</tr>
						<tr>
							<td style="font-weight: bold; padding: 5px" class="bg-primary">Árbitro: &nbsp;&nbsp;</td>
							<td style="padding: 5px; background-color: #B7E3F9">

								@if(!is_null($partido->arbitro_central))
									{{$partido->arbitro_central->nombre_completo}} 
								@endif
							</td>
						</tr>
					</table>
				</center>
			</div>
		</div>
		<br/><br/>
		<div class="row">
			<div class="col-lg-6 col-sm-6 col-xs-6" style="padding-right: 0; padding-left: 0; ">
				<table class="table watermark">
					<thead>
						<tr>
							<th class="text-center gray-gradient">{{$partido->equipo_local->nombre}}</th>
							<th class="gray-gradient" style="width: 35px"><img src="{{asset('assets/imagenes/eventos/gol.png')}}" alt="" width="25px"></th>
							<th class="gray-gradient" style="width: 35px"><img src="{{asset('assets/imagenes/eventos/cambio.png')}}" alt="" width="25px"></th>
						</tr>
					</thead>
					<tbody>
						@if($ficha->alineacionLocal)
							@foreach($ficha->alineacionLocal as $al)
								<tr style="@if(!$al->es_titular) background-color: #B7E3F9; @endif">
									<td>{{$al->persona->nombreCompletoApellidos}}</td>
									<td style="width: 35px" class="text-center">@if($al->goles != 0) {{$al->goles}} @endif</td>
									<td style="text-align: center; @if(!$al->es_titular) color: #069; @else color: red; @endif width: 35px">{{$al->minutoCambio}} </td>
								</tr >
							@endforeach
						@else
							<tr><td colspan="3">Alineaciones por anunciar</td></tr>
						@endif
						<tr class="bg-primary">
							<td colspan="3" class="text-center"> 
								@if($ficha->dtLocal)	DT. {{$ficha->dtLocal->nombreCompleto}} @endif
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
			<div class="col-lg-6 col-sm-6 col-xs-6" style="padding-right: 0; padding-left: 0;">
				<table class="table watermark">
					<thead>
						<tr>
							<th class="text-center gray-gradient">{{$partido->equipo_visita->nombre}}</th>
							<th class="gray-gradient" style="width: 35px"><img src="{{asset('assets/imagenes/eventos/gol.png')}}" alt="" width="25px"></th>
							<th class="gray-gradient" style="width: 35px"><img src="{{asset('assets/imagenes/eventos/cambio.png')}}" alt="" width="25px"></th>
						</tr>
					</thead>
					<tbody>
						@if($ficha->alineacionVisita)
							@foreach($ficha->alineacionVisita as $av)
								<tr style="@if(!$av->es_titular) background-color: #B7E3F9; @endif">
									<td>{{$av->persona->nombreCompletoApellidos}}</td>
									<td style="width: 35px" class="text-center">@if($av->goles != 0) {{$av->goles}} @endif</td>
									<td style="text-align: center; @if(!$av->es_titular) color: #069; @else color: red; @endif width: 35px">{{$av->minutoCambio}} </td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="3">Alineaciones por anunciar</td></tr>
						@endif
						<tr class="bg-primary">
							<td colspan="3" class="text-center">
								@if($ficha->dtVisita)	DT. {{$ficha->dtVisita->nombreCompleto}} @endif
								
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-lg-6 col-sm-6 col-xs-6" style="padding-right: 0; padding-left: 0">
				<table class="table">
					<thead>
						<tr>
							<th class="text-center gray-gradient">Goles de {{$partido->equipo_local->nombre}}</th>
							<th style="width: 30px" class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/gol.png')}}" alt=""></th>
						</tr>
					</thead>
					<tbody>
						@if($ficha->golesLocal)
							@foreach($ficha->golesLocal as $gl)
								<tr>
									<td>{{$gl->jugador->nombreCompletoApellidos}} @if($gl->autogol) (ag) @endif</td>
									<td style="width: 30px;" class="text-center">{{$gl->minuto}}</td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="2">Sin goles</td></tr>
						@endif
					</tbody>
				</table>	
			</div>
			<div class="col-lg-6 col-sm-6 col-xs-6" style="padding-right: 0; padding-left: 0">
				<table class="table">
					<thead>
						<tr>
							<th class="text-center gray-gradient">Goles de {{$partido->equipo_visita->nombre}}</th>
							<th style="width: 30px" class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/gol.png')}}" alt=""></th>
						</tr>
					</thead>
					<tbody>
						@if($ficha->golesVisita)
							@foreach($ficha->golesVisita as $gv)
								<tr>
									<td>{{$gv->jugador->nombreCompletoApellidos}} @if($gv->autogol) (ag) @endif</td>
									<td style="width: 30px;" class="text-center">{{$gv->minuto}}</td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="2">Sin goles</td></tr>
						@endif
					</tbody>
				</table>	
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-sm-6 col-xs-6" style="padding-right: 0; padding-left: 0">
				<table class="table">
					<thead>
						<tr>
							<th class="text-center gray-gradient">Tarjetas de {{$partido->equipo_local->nombre}}</th>
							<th style="width: 30px" class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/amarilla.png')}}" alt=""></th>
							<th style="width: 30px" class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/dobleAmarilla.png')}}" alt=""></th>
							<th style="width: 30px" class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/roja.png')}}" alt=""></th>
						</tr>
					</thead>
					<tbody>
						@if($ficha->tarjetasLocal)
							@foreach($ficha->tarjetasLocal as $tl)
								<tr>
									<td>{{$tl->jugador->nombreCompletoApellidos}}</td>
									<td style="width: 30px;" class="text-center">{{$tl->minutoAmarilla}}</td>
									<td style="width: 30px;" class="text-center">{{$tl->minutoDoble}}</td>
									<td style="width: 30px;" class="text-center">{{$tl->minutoRoja}}</td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="4">Sin tarjetas</td></tr>
						@endif
					</tbody>
				</table>	
			</div>
			<div class="col-lg-6 col-sm-6 col-xs-6" style="padding-right: 0; padding-left: 0">
				<table class="table">
					<thead>
						<tr>
							<th class="text-center gray-gradient">Tarjetas de {{$partido->equipo_visita->nombre}}</th>
							<th style="width: 30px" class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/amarilla.png')}}" alt=""></th>
							<th style="width: 30px" class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/dobleAmarilla.png')}}" alt=""></th>
							<th style="width: 30px" class="text-center gray-gradient"><img src="{{asset('assets/imagenes/eventos/roja.png')}}" alt=""></th>
						</tr>
					</thead>
					<tbody>
						@if($ficha->tarjetasVisita)
							@foreach($ficha->tarjetasVisita as $tv)
								<tr>
									<td>{{$tv->jugador->nombreCompletoApellidos}}</td>
									<td style="width: 30px;" class="text-center">{{$tv->minutoAmarilla}}</td>
									<td style="width: 30px;" class="text-center">{{$tv->minutoDoble}}</td>
									<td style="width: 30px;" class="text-center">{{$tv->minutoRoja}}</td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="4">Sin tarjetas</td></tr>
						@endif
					</tbody>
				</table>	
			</div>
		</div>
		</div>
	<div id="minuto" class="tab-pane fade">
		Cargando...
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
	function redirect(){
		window.location.replace("{{route('en_vivo',$partido->id)}}");
	}
	function actualizar(){
    	if(segundos > 0){
    		segundos = segundos - 1;
    		$('#txtActualizar').text(segundos);
    		setTimeout("actualizar()",1000) 
        }
        else{
        	window.location.reload();
        }
    } 
</script>
<script> 

	var minuto = 0;
	var segundo = 0;
	var tiempoPartido = '';

    function mueveReloj(){
    	segundo = segundo + 1;
    	if(segundo == 60){
    		minuto = minuto + 1;
    		segundo = 0;
    	}
    	txtSeg = segundo;
    	txtMin = minuto;
        if(txtSeg<10) txtSeg = "0"+txtSeg;
        if(txtMin<10) txtMin = "0"+txtMin;

        tiempoPartido = txtMin + " : " + txtSeg; 

        $('#tiempoPartido').text(tiempoPartido);

        setTimeout("mueveReloj()",1000) 
    } 

    $(document).ready(function()
    {
    	var estadoPartido = {{$partido->estado}};
    	if(estadoPartido == 1){
       		return ;
    	}

    	tiempoPartido = '{{$partido->tiempo}}';
    	if(!tiempoPartido.includes(":")){
       		$('#tiempoPartido').text(tiempoPartido);
       		return ;
       	}
       	tiempoPartido = tiempoPartido.split(":");
        minuto = parseInt(tiempoPartido[0]);
        segundo = parseInt(tiempoPartido[1]);
        mueveReloj();
    });
</script>

@stop