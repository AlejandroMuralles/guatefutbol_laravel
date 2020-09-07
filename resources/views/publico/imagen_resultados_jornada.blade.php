@extends('layouts.externo')
@section('css')
<link href="https://fonts.googleapis.com/css?family=Fascinate+Inline|Fredericka+the+Great|Luckiest+Guy|Monoton|Orbitron|Spicy+Rice" rel="stylesheet">
<style>
    .imagen{
        width: 1100px;
        height: {{count($partidos)*55+250}}px;
        /*background: url("{{asset('assets/imagenes/imagen_jornada.png')}}") center no-repeat;*/
        position: relative;
        margin: 10px;
        margin-bottom: 50px;
    }
    .transparente{
        width: 1100px;
        height: {{count($partidos)*55+250}}px;
        background: #252F48;
    }
    .logos{
        position: absolute;
        top: 30px;
        left: 15px;
        text-align: center;
        width: 1070px;
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
        width: 1070px;
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
        width: 1070px;
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
        /*border: 3px solid white;*/
        background: #151E35;
        height: 50px;
        width: 900px;
        left: 100px;
        
    }
    .local{
        position: absolute;
        left: 0px;
        line-height: 40px;
        height: 50px;
        vertical-align: middle;
        color: white;
        font-size: 30px;
        top: 0px;
    }
    .local-team{
        width: 450px;
        text-align: center;
    }
    .local img{
        position: absolute;
        height: 50px;
        width: 50px;
        left: -25px;
    }
    .visita{
        position: absolute;
        right: 0px;
        line-height: 50px;
        height: 50px;
        vertical-align: middle;
        color: white;
        font-size: 30px;
        top: 0px;
    }
    .visita-team{
        width: 450px;
        text-align: center;
    }    
    .visita img{
        position: absolute;
        height: 50px;
        width: 50px;
        right: -25px;
    }
    .resultado{
        position: absolute;
        text-align: center;
        width: 100px;
        height: 50px;
        line-height: 50px;
        vertical-align: middle;
        background: white;
        color: #151E35;
        /*color: #063e71;
        background: white;*/
        font-family: 'Luckiest Guy', cursive;
        font-size: 30px;
        left: 400px;
        -webkit-clip-path: polygon(-10% 50%, 50% -50%, 110% 50%, 50% 150%);
        clip-path: polygon(-10% 50%, 50% -50%, 110% 50%, 50% 150%);
    }
    .footer{
        position: absolute;
        bottom: 30px;
        width: 1070px;
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
            <div id="imagen" class="imagen">
                <div class="transparente"></div>
                <div class="cuadrado"></div>
                <div class="logos">
                    <div class="liga">
                        <img src="{{asset('assets/imagenes/logo_liga.png')}}" height="100px">
                    </div>
                    <div class="titulo-liga">
                        {{$campeonato->liga->nombre}}
                    </div>
                    <div class="futsal502">
                        <img src="{{asset('assets/imagenes/logo.png')}}" width="300px">
                    </div>
                </div>
                <h1 class="titulo-jornada">{{$jornada->nombre}}</h1>
                @php $height = 0; @endphp
                @foreach($partidos as $partido)
                    <div class="partido" style="top: {{175+$height}}px;">
                        <div class="local">
                            <img src="{{$partido->equipo_local->logo}}" height="25px" width="25px"> 
                            <div class="local-team">{{$partido->equipo_local->nombre}}</div>
                        </div>
                        <div class="hexagon resultado">{{$partido->goles_local}} - {{$partido->goles_visita}}</div>
                        <div class="visita">
                            <img src="{{$partido->equipo_visita->logo}}" height="25px" width="25px">
                            <div class="visita-team">{{$partido->equipo_visita->nombre}} </div>
                        </div>
                    </div>
                @php $height += 55; @endphp   
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
    <div id="imagen2"></div>
@endsection
@section('js')

<script>
	
	$(function(){

        html2canvas(document.querySelector("#imagen")).then(canvas => {
            document.querySelector('#imagen2').appendChild(canvas);
            $('#imagen').hide();
        });

		var equipoId = 0;

		$('select').on('change', function()
		{
			var ligaId = $('#ligaId').val();
			var campeonatoId = $('#campeonatoId').val();
			var jornadaId = $('#jornadaId').val();

			if(ligaId == '') ligaId = 0;
			if(campeonatoId == '') campeonatoId = 0;
			if(jornadaId == '') jornadaId = 0;

			var ruta = "{{route('inicio')}}/imagen-jornada/" + ligaId + "/" + campeonatoId + "/" + jornadaId + "/{{$tipo}}";
			window.location.href = ruta;

		});

	})

</script>

@endsection