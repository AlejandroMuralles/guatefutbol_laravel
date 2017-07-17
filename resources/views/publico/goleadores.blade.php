@extends('layouts.publico')
@section('css')

<link href="{{ asset('assets/public/css/plugins/datatables/datatables.css') }}" rel="stylesheet" type="text/css" />

@stop
@section('title')
Tabla de Goleadores - {{$campeonato->nombre}}
@stop
@section('header')
<section class="page-title">
    <div class="container">
        <header>
            <h2>Tabla de Goleadores - {{$campeonato->nombre}}</h2>
        </header>
    </div>          
</section>
<div class="orange ribbon"></div>
@stop

@section('content')
<div class="portlet portlet-default">
	<div class="portlet-heading">
		@if($configuracion->parametro3)
		<div class="portlet-title" style="float: right;">
			<h4><i class="fa fa-refresh"></i> <span id="txtActualizar"></span></h4>
		</div>
		@endif
		<div class="portlet-title">
			<h4>Tabla de Goleadores - {{$campeonato->nombre}} </h4>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-lg-6">
				{!!Field::select('campeonato',$campeonatos,$campeonato->id) !!}
			</div>
		</div>
		<center>
			<a href="{{route('posiciones',[$ligaId,$campeonato->id])}}" 
				class="btn btn-gray btn-sm gray-gradient round-border">Tabla General</a>
			<a href="{{route('posiciones_local',[$ligaId,$campeonato->id])}}" 
				class="btn btn-gray btn-sm gray-gradient round-border">Tabla Local</a>
			<a href="{{route('posiciones_visita',[$ligaId,$campeonato->id])}}" 
				class="btn btn-gray btn-sm gray-gradient round-border">Tabla Visita</a>
			<a href="{{route('tabla_acumulada',[$ligaId,$campeonato->id])}}" 
				class="btn btn-gray btn-sm gray-gradient round-border">Tabla Acumulada</a>
			<br/>
			<br/>
			<a href="{{route('porteros',[$ligaId, $campeonato->id])}}"
				class="btn btn-gray btn-sm gray-gradient round-border">Tabla de Guardametas</a>
			@if($campeonato->liga_id == 21)
			<a href="{{route('campeones',[$campeonato->liga,$campeonato->id])}}" 
				class="btn btn-gray btn-sm gray-gradient round-border">Campeones</a>
			@endif
			
			
		</center>
		<br/><br/>
		<div class="row row2">
			<div class="col-lg-12">
				<div class="table-responsive" style="padding: 5px">
					<table class="table watermark">
						<thead>
							<tr class="dark-blue white">
								<th>JUGADOR</th>
								<th>EDAD</th>
								<th>EQUIPO</th>
								<th>G</th>
								<th>MJ</th>
							</tr>
						</thead>
						<tbody>
							@foreach($goleadores as $goleador)
							<tr>
								<td>{{$goleador->jugador->nombreCompletoApellidos}}</td>
								<td class="text-center">{{$goleador->jugador->fecha_nacimiento}}</td>
								<td class="text-center">
									<img src="{{asset('assets/imagenes/equipos')}}/{{$goleador->equipo->imagen}}" width="25px"> {{$goleador->equipo->nombre}}
								</td>
								<td class="text-center">{{$goleador->goles}}</td>
								<td class="text-center">{{$goleador->minutos}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


@stop

@section('js')
<script src="{{ asset('assets/public/js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/public/js/plugins/datatables/datatables-bs3.js') }}" type="text/javascript"></script>
<script>
	var segundos = 0;

	$(function(){

		@if($configuracion->parametro3)
			segundos = {{$configuracion->parametro1}};
 			actualizar(); 			
		@endif

		$('table').dataTable({
			"bSort" : false,
			"bPaginate": true,
			"bFilter": true, 
			"bInfo": true,
   			"iDisplayLength" : 10,
		});

		$('select').on('change', function () {
          var url = '{{route("inicio")}}/goleadores/{{$ligaId}}/'+ $(this).val();
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });

	});

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

@stop