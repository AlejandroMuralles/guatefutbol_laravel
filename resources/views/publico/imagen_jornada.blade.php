@extends('layouts.externo')
@section('css')
<link href="https://fonts.googleapis.com/css?family=Fascinate+Inline|Fredericka+the+Great|Luckiest+Guy|Monoton|Orbitron|Spicy+Rice" rel="stylesheet">
<style>
    .imagen{
        width: 1000px;
        height: '{{count($partidos)*80+250}}px';
        /*background: url("{{asset('assets/imagenes/imagen_jornada.png')}}") center no-repeat;*/
        position: relative;
        margin: 10px;
        margin-bottom: 50px;
    }
    .transparente{
        width: 1000px;
        height: {{count($partidos)*80+250}}px;
        background: rgba(12, 63, 108, 0.90);
    }
    .logos{
        position: absolute;
        top: 30px;
        left: 15px;
        text-align: center;
        width: 970px;
        height: 60px;
        line-height: 60px;
        vertical-align: middle;
        color: white;
        /*color: #063e71;
        background: white;*/
        font-family: 'Spicy Rice', cursive;
        font-size: 50px;
    }
    .logos div{
        position: absolute;
    }
    .titulo-liga{
        position: absolute;
        top: 20px;
        left: 15px;
        text-align: center;
        width: 970px;
        height: 60px;
        line-height: 60px;
        vertical-align: middle;
        color: white;
        /*color: #063e71;
        background: white;*/
        font-family: 'Luckiest Guy', cursive;
        font-size: 50px;
    }
    .liga{
        left: 25px !important;
    }
    .futsal502{
        right: 25px !important;
    }
    .titulo-jornada{
        position: absolute;
        top: 110px;
        left: 15px;
        text-align: center;
        width: 970px;
        height: 60px;
        line-height: 60px;
        vertical-align: middle;
        color: white;
        /*color: #063e71;
        background: white;*/
        font-family: 'Luckiest Guy', cursive;
        font-size: 30px;
    }
    .titulo-jornada img{
        height: 75px;
        margin-bottom: 25px;
    }
    .cuadrado{
        position: absolute;
        top: 15px;
        right: 15px;
        left: 15px;
        bottom: 15px;
        border: 3px solid white;
    }
    .logo-jornada{
        position: absolute;
        top: 47px;;
        right: 15px;
        height: 75px;
        width: 100px;
    }
    .partido{
        position: absolute;
        border: 3px solid white;
        height: 70px;
        width: 900px;
        left: 50px;
    }
    .local{
        position: absolute;
        left: 25px;
        line-height: 70px;
        height: 70px;
        vertical-align: middle;
        color: white;
        font-size: 30px;
        top: -4px;
    }
    .visita{
        position: absolute;
        right: 25px;
        line-height: 70px;
        height: 70px;
        vertical-align: middle;
        color: white;
        font-size: 30px;
        top: -4px;
    }
    .fecha{
        position: absolute;
        text-align: center;
        width: 900px;
        height: 35px;
        line-height: 35px;
        vertical-align: middle;
        color: white;
        /*color: #063e71;
        background: white;*/
        font-family: 'Luckiest Guy', cursive;
        font-size: 25px;
        top: 5px;
    }
    .domo{
        position: absolute;
        text-align: center;
        width: 900px;
        height: 35px;
        line-height: 35px;
        vertical-align: middle;
        color: white;
        /*color: #063e71;
        background: white;*/
        font-size: 15px;
        top: 30px;
    }
    .footer{
        position: absolute;
        bottom: 30px;
        width: 970px;
        height: 35px;
        line-height: 35px;
        vertical-align: middle;
        left: 15px;
        color: white !important;
        font-size: 20px;
        text-align: center;
    }
    .social{        
        display: inline-block;
        color: white !important;
    }
    .facebook{
        position: absolute;
        left: 50px;
    }
    .twitter{
        position: absolute;
        right: 50px;
    }
</style>
@endsection
@section('content')
    <div class="row">
		<div class="col-lg-3">
			{!! Field::select('liga_id',$ligas, $ligaId, ['id'=>'ligaId']) !!}
		</div>
		<div class="col-lg-3">
			{!! Field::select('campeonato_id',$campeonatos, $campeonatoId, ['id'=>'campeonatoId']) !!}
		</div>
		<div class="col-lg-3">
			{!! Field::select('jornada_id',$jornadas, $jornadaId, ['id'=>'jornadaId']) !!}
		</div>
	</div>
    <div class="row">
        <div class="col-lg-12">
            @if($jornada)
            <div class="imagen">
                <div class="transparente"></div>
                <div class="cuadrado"></div>
                <div class="logos">
                    <div class="liga">
                        <img src="{{asset('assets/imagenes/logos/logo_liga.png')}}" height="50px">
                    </div>
                    <div class="titulo-liga">
                        {{$campeonato->liga->nombre}}
                    </div>
                    <div class="futsal502">
                        <img src="{{asset('assets/imagenes/logo.png')}}" height="100px">
                    </div>
                </div>
                <h1 class="titulo-jornada">{{$jornada->nombre}}</h1>
                @php $height = 0; @endphp
                @foreach($partidos as $partido)
                    <div class="partido" style="top: {{195+$height}}px;">
                        <div class="local"><img src="{{$partido->equipo_local->logo}}" height="35px" width="35px"> {{$partido->equipo_local->nombre}}</div>
                        <div class="fecha">{{date('d/m - H:i', strtotime($partido->fecha))}}</div>
                        <div class="domo">{{$partido->estadio->nombre}}</div>
                        <div class="visita">{{$partido->equipo_visita->nombre}} <img src="{{$partido->equipo_visita->logo}}" height="35px" width="35px"></div>
                    </div>
                @php $height += 75; @endphp   
                @endforeach
                <div class="footer">
                    <div class="social facebook">
                        <i class="fa fa-facebook-square"></i> <span>/Guatefutbol.com</span>
                    </div>
                    <div class="social instagram">
                        <i class="fa fa-instagram"></i> <span>@guatefutbol.oficial</span>
                    </div>
                    <div class="social twitter">
                        <i class="fa fa-twitter"></i> <span>@guatefut</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
@section('js')

<script>
	
	$(function(){

		var equipoId = 0;
        var tipo = '{{$tipo}}';

		$('select').on('change', function()
		{
			var ligaId = $('#ligaId').val();
			var campeonatoId = $('#campeonatoId').val();
			var jornadaId = $('#jornadaId').val();

			if(ligaId == '') ligaId = 0;
			if(campeonatoId == '') campeonatoId = 0;
			if(jornadaId == '') jornadaId = 0;

			var ruta = "{{route('inicio')}}/externo-imagen-jornada/" + ligaId + "/" + campeonatoId + "/" + jornadaId + "/" + tipo;
			window.location.href = ruta;

		});

	})

</script>

@endsection