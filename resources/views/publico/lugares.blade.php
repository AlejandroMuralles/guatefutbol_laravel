@extends('layouts.publico')
@section('title') DOMOS @stop
@section('header')
<section class="page-title">
    <div class="container">
        <header>
            <h2>Domos</h2>
        </header>
    </div>          
</section>
<div class="orange ribbon"></div>
@stop
@section('content')
<section>
	<div class="row" style="padding: 5px">
		<center>
			@foreach($domos as $domo)
			<a class="btn btn-primary" onclick="centerMap({{$domo->latitud}}, {{$domo->longitud}});">{{$domo->nombre}}</a>
			@endforeach
		</center>
	</div>
	
	<div style="padding: 5px" class="row row2">
		<div id="map"></div>
	</div>
	<br/>
	<div class="row row2">
		@foreach($domos as $domo)
		<div class="col-lg-4">
			<h3 class="text-center white blue" style="padding: 10px 0; margin: 5px 0;">{{$domo->nombre}}</h3>
			<div class="form-group">
				<label>Dirección</label>
				<p>{{$domo->direccion}}</p>
			</div>
			@if(!is_null($domo->imagen))
				<img src="{{asset('assets/imagenes/domos')}}/{{$domo->imagen}}" width="100%">
			@endif
		</div>
		@endforeach
	</div>

</section>
@stop
@section('js')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
<script type="text/javascript">
	var map;
	$(document).ready(function () {
		createMap();
	});
	function createMap()
	{		
		var mapOptions = {
			zoom:18,
			center: latLang,
			disableDefaultUI: false,
			navigationControl: false,
			mapTypeControl: false,
			scrollwheel: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById('map'), mapOptions);
		google.maps.event.trigger(map, 'resize');
		map.setZoom( map.getZoom() );
		var image = {
		    //url: "assets/images/ico.png", // url
		    scaledSize: new google.maps.Size(30, 30), // scaled size
		    origin: new google.maps.Point(0,0), // origin
		    anchor: new google.maps.Point(0, 0) // anchor
		};

		var latLang;
		var marker;
		@foreach($domos as $domo)
			/* MARKER Gimnasio Teodoro Palacios Flores */
			latLang = new google.maps.LatLng({{$domo->latitud}}, {{$domo->longitud}} );
			marker = new google.maps.Marker({
				position: latLang,
				map: map,
				title: '{{$domo->nombre}}',
				/*icon: image*/
			});

			marker.setMap(map);

		@endforeach

		map.setCenter(latLang);


		google.maps.event.addListener(marker, "click", function() {
			// Add optionally an action for when the marker is clicked
		});

		// kepp googlemap responsive - center on resize
		google.maps.event.addDomListener(window, 'resize', function() {
			map.setCenter(latLang);
		});
	}

	function centerMap(latitude, longitude)
	{
		var latLang = new google.maps.LatLng(latitude, longitude);
		map.setCenter(latLang);
	}

</script>

@stop