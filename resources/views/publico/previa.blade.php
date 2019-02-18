@extends('layouts.partido')
@section('css')
<link rel="stylesheet" href="{{asset('assets/public/css/partido.css')}}">
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="datos-partido">
            <div class="row">
                <div class="col-lg-6 col-xs-6">
                    <div class="dato-partido">
                        <div class="icono"><i class="fa fa-trophy"></i></div>
                        <div class="dato">
                            <div class="titulo">COMPETICIÓN</div>
                            <div class="sub-titulo">{{$partido->campeonato->liga->nombre}} - {{$partido->campeonato->nombre}} </div>
                        </div>
                    </div>                    
                </div>
                <div class="col-lg-6 col-xs-6">
                    <div class="dato-partido">
                        <div class="icono"><i class="fa fa-calendar"></i></div>
                        <div class="dato">
                            <div class="titulo">FECHA</div>
                            <div class="sub-titulo" style="font-size: 13px;">{{$partido->fecha}} </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-xs-6">
                    <div class="dato-partido">
                        <div class="icono"><i class="flaticon flaticon-whistle"></i></div>
                        <div class="dato">
                            <div class="titulo">ARBITRO</div>
                            <div class="sub-titulo">{{$partido->arbitro_central->nombre_completo}}</div>
                        </div>
                    </div>                    
                </div>
                <div class="col-lg-6 col-xs-6">
                    <div class="dato-partido">
                        <div class="icono"><i class="flaticon flaticon-soccer-field"></i></div>
                        <div class="dato">
                            <div class="titulo">ESTADIO</div>
                            <div class="sub-titulo">{{$partido->estadio->nombre}} </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>        
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="datos-partido" style="padding-top: 0">
            <h3 style="margin:0; margin-bottom: 20px; padding: 5px 15px; background: #069; border-top-left-radius: 5px; 
            border-top-right-radius: 5px; color: white; text-align: center">
                <span class="bullet-comentario con-icono icono fa fa-futbol" style="color: black"></span> Cómo llegan los equipos
            </h3>
            <h3 style="color: #069; margin-left: 15px;">{{$partido->equipo_local->nombre}}</h3>
            <div class="racha">                
                <div class="racha_logo"><img src="{{$partido->equipo_local->logo}}"></div>
                <div class="racha_estadisticas">
                    <div class="racha_estadistica racha_ganados">{{$rachaLocal->ganados}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_ganados">Ganados</div>
                    <div class="racha_estadistica racha_empatados">{{$rachaLocal->empatados}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_empatados">Empatados</div>
                    <div class="racha_estadistica racha_perdidos">{{$rachaLocal->perdidos}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_perdidos">Perdidos</div>
                </div>
            </div>
            <h3 style="color: #069; margin-left: 15px;">{{$partido->equipo_visita->nombre}}</h3>
            <div class="racha">
                <div class="racha_logo"><img src="{{$partido->equipo_visita->logo}}"></div>
                <div class="racha_estadisticas">
                    <div class="racha_estadistica racha_ganados">{{$rachaVisita->ganados}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_ganados">Ganados</div>
                    <div class="racha_estadistica racha_empatados">{{$rachaVisita->empatados}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_empatados">Empatados</div>
                    <div class="racha_estadistica racha_perdidos">{{$rachaVisita->perdidos}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_perdidos">Perdidos</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="datos-partido" style="padding-top: 0">
            <h3 style="margin:0; margin-bottom: 20px; padding: 5px 15px; background: #069; border-top-left-radius: 5px; 
                        border-top-right-radius: 5px; color: white; text-align: center">
                <span class="bullet-comentario con-icono icono fa fa-futbol" style="color: black"></span> Últimos diez enfrentamientos
            </h3>
            <h3 style="color: #069; margin-left: 15px;">{{$partido->equipo_local->nombre}}</h3>
            <div class="racha">                
                <div class="racha_logo"><img src="{{$partido->equipo_local->logo}}"></div>
                <div class="racha_estadisticas">
                    <div class="racha_estadistica racha_ganados">{{$rachaEntreEquipos['equipo_local_ganados']}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_ganados">Ganados</div>
                    <div class="racha_estadistica racha_empatados">{{$rachaEntreEquipos['empatados']}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_empatados">Empatados</div>
                    <div class="racha_estadistica racha_perdidos">{{$rachaEntreEquipos['equipo_visita_ganados']}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_perdidos">Perdidos</div>
                </div>
            </div>
            <h3 style="color: #069; margin-left: 15px;">{{$partido->equipo_visita->nombre}}</h3>
            <div class="racha">
                <div class="racha_logo"><img src="{{$partido->equipo_visita->logo}}"></div>
                <div class="racha_estadisticas">
                    <div class="racha_estadistica racha_ganados">{{$rachaEntreEquipos['equipo_visita_ganados']}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_ganados">Ganados</div>
                    <div class="racha_estadistica racha_empatados">{{$rachaEntreEquipos['empatados']}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_empatados">Empatados</div>
                    <div class="racha_estadistica racha_perdidos">{{$rachaEntreEquipos['equipo_local_ganados']}}</div>
                    <div class="descripcion_racha_estadistica desc_racha_perdidos">Perdidos</div>
                </div>
            </div>
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

        $('.previa').addClass('active');
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
