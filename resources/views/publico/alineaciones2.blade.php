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
}
.banquillo{
    background-color: #dddddd;
    color: #666;
}
</style>
<style>
    .c-tab{
        padding: 0 15px;
    }
    .c-tab_list {
        padding: 0;
        position: relative;
        list-style: none;
        margin: 0 auto;
    }
    .c-tab_input,.c-tab_content {
        display: none;
    }
    .c-tab_content {
        padding-top: 50px;
    }
    .c-tab_input:checked ~ .c-tab_content {
        display: block;
    }
    .c-tab_label {
        display: inline-block;
        position: absolute;
        top: 0;
        width: 200px;
        height: 2.5em;
        line-height: 2.5em;
        box-sizing: border-box;
        text-align: center;
        border-width: 1px 0 1px 1px;
        border-style: solid;
        border-color: #069;
        color: #069;
        cursor: pointer;
        transition: 0.2s linear;
    }
    .c-tab_input:checked + .c-tab_label {
        color: #fff;
        background-color: #069;
    }
    .c-tab_item:nth-child(1) > .c-tab_label {
        left: 50%;
        margin-left: -200px;
    }
    .c-tab_item:nth-child(2) > .c-tab_label {
        right: 50%;
        margin-right: -200px;
    }
    .c-tab_item:first-child > .c-tab_label {
        border-radius: 0.4em 0 0 0.4em;
    }
    .c-tab_item:last-child > .c-tab_label {
        border-width: 1px;
        border-radius: 0 0.4em 0.4em 0;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="c-tab">
            <ul class="c-tab_list">
                <li class="c-tab_item">
                    <input class="c-tab_input" type="radio" name="c-tab" id="foo-c-tab-1" checked="checked">
                    <label class="c-tab_label" for="foo-c-tab-1">{{$partido->equipo_local->nombre}}</label>
                    <section class="c-tab_content">
                        <table class="table">
                            <tbody>
                            @foreach($titularesLocales as $ev)
                                <tr>
                                    <td>{{$ev->jugador->nombre_completo_apellidos}}</td>
                                    <td width="50px" class="text-center">
                                        @if($ev->cambio)
                                        <i class="fa fa-exchange-alt" style="color: red;" data-toggle="tooltip" data-placement="top" title="{{$ev->minuto_cambio}}'"></i>
                                        @endif
                                    </td>
                                    <td width="50px" class="text-center">
                                        @if($ev->expulsado && count($ev->amarillas)==2)
                                            <i class="fa fa-clone" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}', {{$ev->amarillas[1]}}'"></i>
                                        @elseif($ev->expulsado)
                                            <i class="fa fa-square" style="color: red" data-toggle="tooltip" data-placement="top" title="{{$ev->roja}}'"></i>
                                        @elseif(count($ev->amarillas))
                                            <i class="fa fa-square" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}'"></i>
                                        @endif
                                    </td>
                                    <td width="50px" class="text-center">
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
                                    <td>{{$ev->jugador->nombre_corto_apellidos}}</td>
                                    <td width="50px" class="text-center">
                                        @if($ev->cambio)
                                        <i class="fa fa-exchange-alt" style="color: green;" data-toggle="tooltip" data-placement="top" title="{{$ev->minuto_cambio}}'"></i>
                                        @endif
                                    </td>
                                    <td width="50px" class="text-center">
                                        @if($ev->expulsado && count($ev->amarillas)==2)
                                            <i class="fa fa-clone" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}', {{$ev->amarillas[1]}}'"></i>
                                        @elseif($ev->expulsado)
                                            <i class="fa fa-square" style="color: red" data-toggle="tooltip" data-placement="top" title="{{$ev->roja}}'"></i>
                                        @elseif(count($ev->amarillas))
                                            <i class="fa fa-square" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}'"></i>
                                        @endif
                                    </td>
                                    <td width="50px" class="text-center">
                                        @if(count($ev->goles)>0)
                                        <i class="fa fa-futbol"></i> @if(count($ev->goles)>1) x{{count($ev->goles)}} @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="banquillo" >DT. {{$dtLocal->nombre_completo}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                </li>
                <li class="c-tab_item">
                    <input class="c-tab_input" type="radio" name="c-tab" id="foo-c-tab-2">
                    <label class="c-tab_label" for="foo-c-tab-2">{{$partido->equipo_visita->nombre}}</label>
                    <section class="c-tab_content">
                        <table class="table">
                            <tbody>
                            @foreach($titularesVisita as $ev)
                                <tr>
                                    <td>{{$ev->jugador->nombre_completo_apellidos}}</td>
                                    <td width="50px" class="text-center">
                                        @if($ev->cambio)
                                        <i class="fa fa-exchange-alt" style="color: red;" data-toggle="tooltip" data-placement="top" title="{{$ev->minuto_cambio}}'"></i>
                                        @endif
                                    </td>
                                    <td width="50px" class="text-center">
                                        @if($ev->expulsado && count($ev->amarillas)==2)
                                            <i class="fa fa-clone" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}', {{$ev->amarillas[1]}}'"></i>
                                        @elseif($ev->expulsado)
                                            <i class="fa fa-square" style="color: red" data-toggle="tooltip" data-placement="top" title="{{$ev->roja}}'"></i>
                                        @elseif(count($ev->amarillas))
                                            <i class="fa fa-square" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}'"></i>
                                        @endif
                                    </td>
                                    <td width="50px" class="text-center">
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
                                    <td>{{$ev->jugador->nombre_corto_apellidos}}</td>
                                    <td width="50px" class="text-center">
                                        @if($ev->cambio)
                                        <i class="fa fa-exchange-alt" style="color: green;" data-toggle="tooltip" data-placement="top" title="{{$ev->minuto_cambio}}'"></i>
                                        @endif
                                    </td>
                                    <td width="50px" class="text-center">
                                        @if($ev->expulsado && count($ev->amarillas)==2)
                                            <i class="fa fa-clone" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}', {{$ev->amarillas[1]}}'"></i>
                                        @elseif($ev->expulsado)
                                            <i class="fa fa-square" style="color: red" data-toggle="tooltip" data-placement="top" title="{{$ev->roja}}'"></i>
                                        @elseif(count($ev->amarillas))
                                            <i class="fa fa-square" style="color: #FFBF00" data-toggle="tooltip" data-placement="top" title="{{$ev->amarillas[0]}}'"></i>
                                        @endif
                                    </td>
                                    <td width="50px" class="text-center">
                                        @if(count($ev->goles)>0)
                                        <i class="fa fa-futbol"></i> @if(count($ev->goles)>1) x{{count($ev->goles)}} @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="banquillo" >DT. {{$dtVisita->nombre_completo}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                </li>
            </ul>
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
