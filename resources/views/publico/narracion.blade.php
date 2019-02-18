@extends('layouts.partido')
@section('css')
<link rel="stylesheet" href="{{asset('assets/public/css/partido.css')}}">
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="narracion-directo">
            @php
                $golesLocal = $partido->goles_local;
                $golesVisita = $partido->goles_visita;
            @endphp
            @foreach($eventos as $evento)
            <p class="cnt-comentario">
                <span class="minuto-comentario">{{$evento->minuto}}'</span>
                {{$evento->comentario}}
                @if($evento->evento_id == 6 || $evento->evento_id == 7 || $evento->evento_id == 8)
                <span class="bullet-comentario con-icono icono fa fa-futbol"></span>
                <span class="cont-marcador-narracion cf escudo">
                    <span class="col-equipo-local">
                        <a class="escudo-equipo" href="#">
                            <span><img class="img-max-size" src="{{$partido->equipo_local->logo}}" alt="Escudo {{$partido->equipo_local->nombre}}"></span>
                        </a>
                        <span class="cont-nombre-equipo">
                            <a class="nombre-equipo" href="#">{{$partido->equipo_local->nombre}}</a>				
                        </span>
                        <span class="marcador @if($evento->equipo_id == $partido->equipo_local_id) activo @endif">{{$golesLocal}}</span>
                    </span>
                    <span class="col-equipo-visitante">
                            <a class="escudo-equipo" href="#">
                            <span><img class="img-max-size" src="{{$partido->equipo_visita->logo}}" alt="Escudo {{$partido->equipo_visita->nombre}}"></span>
                        </a>
                        <span class="cont-nombre-equipo">
                            <a class="nombre-equipo" href="#">{{$partido->equipo_visita->nombre}}</a>				
                        </span>
                        <span class="marcador @if($evento->equipo_id == $partido->equipo_visita_id) activo @endif">{{$golesVisita}}</span>
                    </span>
                </span>
                @elseif($evento->evento_id == 9)
                <span class="bullet-comentario con-icono icono fa fa-exchange-alt"></span>
                @elseif($evento->evento_id == 10)
                <span class="bullet-comentario con-icono icono fa fa-square" style="color: yellow"></span>
                @elseif($evento->evento_id == 11)
                <span class="bullet-comentario con-icono icono fa fa-square" style="color: red"></span>
                @else
                <span class="bullet-comentario"></span>
                @endif
            </p>
            @if($evento->evento_id == 6 || $evento->evento_id == 7 || $evento->evento_id == 8)
                @if($evento->equipo_id == $partido->equipo_local_id)
                    @php $golesLocal--; @endphp
                @endif
                @if($evento->equipo_id == $partido->equipo_visita_id)
                    @php $golesVisita--; @endphp
                @endif
            @endif
            @endforeach
        </div>
    </div>
</div>
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

        $('.narracion').addClass('active');

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
