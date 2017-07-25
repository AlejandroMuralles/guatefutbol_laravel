<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/public/plugins/slick/slick.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/public/plugins/slick/slick-theme.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <style type="text/css">
    html, body {
      margin: 0;
      padding: 0;
      font-family: 'Roboto', sans-serif !important;
    }

    * {
      box-sizing: border-box;
    }

    .slider {
        width: 95%;
        margin: 10px auto;
    }

    .slick-slide {
      margin: 0px 0px;
      height: 90px
    }
    .slick-prev:before,
    .slick-next:before {
        color: black;
    }

    div.match{
    	border-right: 2px dotted gray;
        background: #292f33;
        color: white;
    }

    div.team{
    	display: block;
    	margin-bottom: 4px;
    }
	div.team img{
		display: inline-block;
		line-height: 18px;
		vertical-align: middle;
		margin: 0px 5px;
		padding: 0px 2px;
		height: 16px;
		width: 25px;
	}
	div.team h5{
		display: inline-block;
		line-height: 18px;
		vertical-align: middle;
		margin: 0;
        font-size: 12px
	}
	div.team span.score{
		display: inline-block;
		line-height: 18px;
		vertical-align: middle;
		margin: 0;
		float: right;
		width: 25px;
        font-size: 12px
	}
	div.estado, div.liga{
		display: block;
		text-align: center;
		font-size: 12px;
		margin: 1px 5px 1px 5px;
		padding: 2px;
	}
	div.estado{
		background-color: #212121;
        color: white;
		font-weight: bold;
        font-size: 12px
	}
  </style>
</head>
<body>
  <section class="regular slider">
  	@foreach($partidos as $partido)
    <div class="match">
    	<div class="estado">
        @if($partido->estado == 2)
         <span style="color: yellow"><i class="fa fa-clock-o"></i> {{$partido->tiempo}}</span>
        @else
    		  <span>{{$partido->descripcion_estado}}</span>
        @endif
    	</div>
    	<div class="liga">
    		<i class="fa fa-chevron-right-o"></i> {{$partido->campeonato->liga->nombre}}
    	</div>
    	<div class="team">
    		<img src="{{$partido->equipo_local->logo}}">
    		<h5>{{$partido->equipo_local->nombre}}</h5>
    		<span class="score">{{$partido->goles_local}}</span>
    	</div>
    	<div class="team">
    		<img src="{{$partido->equipo_visita->logo}}">
    		<h5>{{$partido->equipo_visita->nombre}}</h5>
    		<span class="score">{{$partido->goles_visita}}</span>
    	</div>
    </div>
    @endforeach
  </section>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="{{ asset('assets/public/plugins/slick/slick.js')}}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(document).on('ready', function() {
      $(".regular").slick({
        dots: false,
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 6,
        responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }]
      });
    });
</script>

</body>
</html>