@extends('layouts.publico')
@section('title') Tabla de Posiciones - {{$campeonato->nombre}} @stop
@section('css')
@stop
@section('header')
<section class="page-title">
    <div class="container">
        <header>
            <h2>Tabla de Posiciones - {{$campeonato->nombre}}</h2>
        </header>
    </div>
</section>
<div class="gradient-gray ribbon"></div>
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
			<h4>Tabla de Posiciones - {{$campeonato->nombre}} </h4>
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
			<a href="{{route('goleadores',[$ligaId, $campeonato->id])}}"
				class="btn btn-gray btn-sm gray-gradient round-border">Tabla de Goleadores</a>
			<a href="{{route('porteros',[$ligaId, $campeonato->id])}}"
				class="btn btn-gray btn-sm gray-gradient round-border">Tabla de Guardametas</a>
			@if($campeonato->liga_id == 21)
			<a href="{{route('campeones',[$campeonato->liga_id,$campeonato->id])}}"
				class="btn btn-gray btn-sm gray-gradient round-border">Campeones</a>
			@endif


		</center>
		<br/><br/>
		<div class="row">
			<div class="table-responsive col-lg-12">
				<table class="table watermark" >
					<thead>
						<tr class="gradient-gray white">
							<th class="text-center">POS</th>
							<th class="text-center">EQUIPO</th>
							<th class="text-center">PTS</th>
							<th class="text-center">JJ</th>
							<th class="text-center">JG</th>
							<th class="text-center">JE</th>
							<th class="text-center">JP</th>
							<th class="text-center">GF</th>
							<th class="text-center">GC</th>
							<th class="text-center">DIF</th>
						</tr>
					</thead>
					<tbody class="color">
						@foreach($posiciones as $posicion)
						<tr>
							<td class="text-center">{{$posicion->POS}}</td>
							<td style="text-align: left">
								<a href="{{route('calendario_equipo',[$ligaId,$campeonato->id,$posicion->equipo->id])}}" class="" style="text-decoration: none">
									<img src="{{$posicion->equipo->logo}}" style="height: 25px; width: 25px">
									{{$posicion->equipo->nombre}}
								</a>
							</td>
							<td class="text-center">{{$posicion->PTS}}</td>
							<td class="text-center">{{$posicion->JJ}}</td>
							<td class="text-center">{{$posicion->JG}}</td>
							<td class="text-center">{{$posicion->JE}}</td>
							<td class="text-center">{{$posicion->JP}}</td>
							<td class="text-center">{{$posicion->GF}}</td>
							<td class="text-center">{{$posicion->GC}}</td>
							<td class="text-center">{{$posicion->DIF}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@stop

@section('js')
<script>

	var segundos = 0;

	$(function(){

		@if($configuracion->parametro3)
			segundos = {{$configuracion->parametro1}};
 			actualizar();
		@endif

		$('select').on('change', function () {
          var url = '{{route("inicio")}}/posiciones/{{$ligaId}}/'+ $(this).val();
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
