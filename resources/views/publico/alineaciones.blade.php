@extends('layouts.partido')
@section('css')
<link rel="stylesheet" href="{{asset('assets/public/css/partido.css')}}">
<style>
tr td{
    border: none !important;
    background-color: white;
    font-weight: bold;
    color: black;
}
table{
    border: 1px solid #dddddd !important;
    background-color: white;
    font-size: 12px;
}
.banquillo{
    background-color: #dddddd;
    color: #666;
}
.alineaciones-equipo{
    position: relative;
    height: 50px;
    line-height: 50px;
    vertical-align: middle;
    margin-bottom: 5px;
}
.alineaciones-equipo img{
    height: 50px;
    position: absolute;
}
.alineaciones-equipo h3{
    position: absolute;
    height: 50px;
    line-height: 50px;
    font-size: 30px;
    color: #069;
    display: inline-block;
    margin: 0;
    top: 5px;
    left: 60px;;
}
td.cambios, td.tarjetas{
    width: 25px;
}
td.goles
{
    width: 50px;
}
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6 col-xs-6" style="padding-right:0;">
                <div class="alineaciones-equipo">
                    <img src="{{$partido->equipo_local->logo}}" alt=""> 
                    <h3>{{$partido->equipo_local->nombre}}</h3>
                </div>
                <table class="table" >
                    <tbody>
                    @foreach($titularesLocales as $ev)
                        <tr>
                            <td>{{$ev->jugador->nombre_completo_apellidos}}</td>
                            <td class="text-center cambios">
                                @if($ev->cambio)
                                <i class="fa fa-exchange-alt" style="color: red;" data-toggle="tooltip" data-placement="top" title="{{$ev->minuto_cambio}}'"></i>
                                @endif
                            </td>
                            <td class="text-center tarjetas">
                                @if($ev->expulsado && count($ev->amarillas)==2)
                                    <i class="fa fa-clone" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}', {{$ev->amarillas[1]}}'"></i>
                                @elseif($ev->expulsado)
                                    <i class="fa fa-square" style="color: red" data-toggle="tooltip" data-placement="top" title="{{$ev->roja}}'"></i>
                                @elseif(count($ev->amarillas))
                                    <i class="fa fa-square" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}'"></i>
                                @endif
                            </td>
                            <td class="text-center goles">
                                @if(count($ev->goles)>0)
                                <i class="fa fa-futbol"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="banquillo" >Banquillo</td>
                    </tr>
                    @foreach($suplentesLocales as $ev)
                        <tr>
                            <td>{{$ev->jugador->nombre_completo_apellidos}}</td>
                            <td class="text-center cambios">
                                @if($ev->cambio)
                                <i class="fa fa-exchange-alt" style="color: green;" data-toggle="tooltip" data-placement="top" title="{{$ev->minuto_cambio}}'"></i>
                                @endif
                            </td>
                            <td class="text-center tarjetas">
                                @if($ev->expulsado && count($ev->amarillas)==2)
                                    <i class="fa fa-clone" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}', {{$ev->amarillas[1]}}'"></i>
                                @elseif($ev->expulsado)
                                    <i class="fa fa-square" style="color: red" data-toggle="tooltip" data-placement="top" title="{{$ev->roja}}'"></i>
                                @elseif(count($ev->amarillas))
                                    <i class="fa fa-square" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}'"></i>
                                @endif
                            </td>
                            <td class="text-center goles">
                                @if(count($ev->goles)>0)
                                <i class="fa fa-futbol"></i> @if(count($ev->goles)>1) x{{count($ev->goles)}} @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="banquillo" >
                            @if(!is_null($dtLocal))
                            DT. {{$dtLocal->nombre_completo}}
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6 col-xs-6" style="padding-left:0;">
                <div class="alineaciones-equipo">
                    <img src="{{$partido->equipo_visita->logo}}" alt=""> 
                    <h3>{{$partido->equipo_visita->nombre}}</h3>
                </div>
                <table class="table">
                        <tbody>
                        @foreach($titularesVisita as $ev)
                            <tr>
                                <td>{{$ev->jugador->nombre_completo_apellidos}}</td>
                                <td class="text-center cambios">
                                    @if($ev->cambio)
                                    <i class="fa fa-exchange-alt" style="color: red;" data-toggle="tooltip" data-placement="top" title="{{$ev->minuto_cambio}}'"></i>
                                    @endif
                                </td>
                                <td class="text-center tarjetas">
                                    @if($ev->expulsado && count($ev->amarillas)==2)
                                        <i class="fa fa-clone" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}', {{$ev->amarillas[1]}}'"></i>
                                    @elseif($ev->expulsado)
                                        <i class="fa fa-square" style="color: red" data-toggle="tooltip" data-placement="top" title="{{$ev->roja}}'"></i>
                                    @elseif(count($ev->amarillas))
                                        <i class="fa fa-square" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}'"></i>
                                    @endif
                                </td>
                                <td class="text-center goles">
                                    @if(count($ev->goles)>0)
                                    <i class="fa fa-futbol"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="banquillo" >Banquillo</td>
                        </tr>
                        @foreach($suplentesVisita as $ev)
                            <tr>
                                <td>{{$ev->jugador->nombre_completo_apellidos}}</td>
                                <td class="text-center cambios">
                                    @if($ev->cambio)
                                    <i class="fa fa-exchange-alt" style="color: green;" data-toggle="tooltip" data-placement="top" title="{{$ev->minuto_cambio}}'"></i>
                                    @endif
                                </td>
                                <td class="text-center tarjetas">
                                    @if($ev->expulsado && count($ev->amarillas)==2)
                                        <i class="fa fa-clone" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}', {{$ev->amarillas[1]}}'"></i>
                                    @elseif($ev->expulsado)
                                        <i class="fa fa-square" style="color: red" data-toggle="tooltip" data-placement="top" title="{{$ev->roja}}'"></i>
                                    @elseif(count($ev->amarillas))
                                        <i class="fa fa-square" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}'"></i>
                                    @endif
                                </td>
                                <td class="text-center goles">
                                    @if(count($ev->goles)>0)
                                    <i class="fa fa-futbol"></i> @if(count($ev->goles)>1) x{{count($ev->goles)}} @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="banquillo" >
                                @if(!is_null($dtVisita))
                                DT. {{$dtVisita->nombre_completo}}
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-xs-6" style="padding-right:0;">
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
									<td>
										@if($gl->jugador)
											{{$gl->jugador->nombreCompletoApellidos}} @if($gl->autogol) (ag) @endif
										@endif
									</td>
									<td style="width: 30px;" class="text-center">{{$gl->minuto}}</td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="2">Sin goles</td></tr>
						@endif
					</tbody>
				</table>
            </div>
            <div class="col-lg-6 col-xs-6" style="padding-left:0;">
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
									<td>
										@if($gv->jugador)
											{{$gv->jugador->nombreCompletoApellidos}} @if($gv->autogol) (ag) @endif
										@endif
									</td>
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
</div>
<br>
@if($configuracion->parametro3 && $partido->estado != 3)
	<h2 style="margin-top: 10px; float:right"><i class="fa fa-refresh"></i> <span id="txtActualizar"></span></h2>
@endif
@endsection
@section('js')

<script>
	var segundos = 0;
	$(function(){
		@if($configuracion->parametro3 && $partido->estado != 3)
			segundos = {{$configuracion->parametro1}};
 			actualizar();
		@endif

        $('.alineaciones').addClass('active');
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
    		$('#tiempoPartido').html('&nbsp;');
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
