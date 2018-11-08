@extends('layouts.partido')
@section('css')
<link rel="stylesheet" href="{{asset('assets/public/css/partido.css')}}">
<style>
table, tr td{
    border: none !important;
}
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6 col-xs-6">
                <h3>{{$partido->equipo_local->nombre}}</h3>
                <table class="table">
                    <tbody>
                    @foreach($titularesLocales as $tl)
                        <tr>
                            <td>{{$tl->jugador->nombre_corto_apellidos}}</td>
                            <td width="50px" class="text-center">
                                @if($tl->cambio)
                                <i class="fa fa-exchange-alt" style="color: red;"></i>
                                @endif
                            </td>
                            <td width="50px" class="text-center">
                                @if($tl->expulsado && count($tl->amarillas)==2)
                                    <i class="fa fa-clone" style="color: yellow"></i>
                                @elseif($tl->expulsado)
                                    <i class="fa fa-square" style="color: red"></i>
                                @elseif(count($tl->amarillas))
                                    <i class="fa fa-square" style="color: yellow"></i>
                                @endif
                            </td>
                            <td width="50px" class="text-center">
                                @if(count($tl->goles)>0)
                                <i class="fa fa-futbol"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @foreach($suplentesLocales as $sl)
                        <tr>
                            <td>{{$sl->jugador->nombre_corto_apellidos}}</td>
                            <td width="50px" class="text-center">
                                @if($sl->cambio)
                                <i class="fa fa-exchange-alt" style="color: green;"></i>
                                @endif
                            </td>
                            <td width="50px" class="text-center">
                                
                            </td>
                            <td width="50px" class="text-center">
                                @if(count($sl->goles)>0)
                                <i class="fa fa-futbol"></i> @if(count($sl->goles)>1) x{{count($sl->goles)}} @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6 col-xs-6">
                <h3>{{$partido->equipo_visita->nombre}}</h3>
                <table class="table">
                        <tbody>
                        @foreach($titularesVisita as $tl)
                            <tr>
                                <td>{{$tl->jugador->nombre_corto_apellidos}}</td>
                                <td width="50px" class="text-center">
                                    @if($tl->cambio)
                                    <i class="fa fa-exchange-alt" style="color: red;"></i>
                                    @endif
                                </td>
                                <td width="50px" class="text-center">
                                    @if($tl->expulsado && count($tl->amarillas)==2)
                                        <i class="fa fa-clone" style="color: yellow"></i>
                                    @elseif($tl->expulsado)
                                        <i class="fa fa-square" style="color: red"></i>
                                    @elseif(count($tl->amarillas))
                                        <i class="fa fa-square" style="color: yellow"></i>
                                    @endif
                                </td>
                                <td width="50px" class="text-center">
                                    @if(count($tl->goles)>0)
                                    <i class="fa fa-futbol"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @foreach($suplentesVisita as $sl)
                            <tr>
                                <td>{{$sl->jugador->nombre_corto_apellidos}}</td>
                                <td width="50px" class="text-center">
                                    @if($sl->cambio)
                                    <i class="fa fa-exchange-alt" style="color: green;"></i>
                                    @endif
                                </td>
                                <td width="50px" class="text-center">
                                    
                                </td>
                                <td width="50px" class="text-center">
                                    @if(count($sl->goles)>0)
                                    <i class="fa fa-futbol"></i> @if(count($sl->goles)>1) x{{count($sl->goles)}} @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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
