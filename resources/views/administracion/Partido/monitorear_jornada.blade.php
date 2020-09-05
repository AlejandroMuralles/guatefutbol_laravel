@extends('layouts.admin')

@section('title') Monitorear Partido @stop

@section('content')
	@if(Session::has('fb-success'))
	  <div class="alert alert-success alert-dismissable">
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	    <i class="icon fa fa-check"></i> {{ Session::get('fb-success') }}
	  </div>
	@endif
	@if(Session::has('fb-error'))
	  <div class="alert alert-danger alert-dismissable">
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	     {{ Session::get('fb-error') }}
	  </div>
	@endif
	<div class="row">
		<div class="col-lg-4">
			{!! Field::select('liga_id',$ligas, $ligaId, ['id'=>'ligaId']) !!}
		</div>
		<div class="col-lg-4">
			{!! Field::select('campeonato_id',$campeonatos, $campeonatoId, ['id'=>'campeonatoId']) !!}
		</div>
		<div class="col-lg-4">
			{!! Field::select('jornada_id',$jornadas, $jornadaId, ['id'=>'jornadaId']) !!}
		</div>
		<div class="col-lg-4">
			<label for="">Partido</label>
			<select name="partido_id" id="partidoId" class="form-control">
				<option value="">Seleccione</option>
				@foreach($partidos as $p)
					@if(!is_null($partido) && $p->id == $partido->id)
						<option value="{{$p->id}}" selected="true">{{$p->equipo_local->nombre}} - {{$p->equipo_visita->nombre}}</option>
					@else
						<option value="{{$p->id}}">{{$p->equipo_local->nombre}} - {{$p->equipo_visita->nombre}}</option>
					@endif
				@endforeach
			</select>
		</div>
	</div>
	<br/>
	@if(!is_null($partido))
	<div class="row">
		<div class="col-lg-12">
			{!! Form::open(['route' => array('login_facebook'), 'method' => 'POST', 'id' => 'form', 'class'=>'validate-form']) !!}
			<input type="hidden" name="ruta_redirect" value="{{route('monitorear_jornada',[$ligaId,$campeonatoId,$jornadaId,$partidoId,$equipoId])}}">
			<button type="submit" class="btn btn-primary" >
				<i class="fab fa-facebook fa-2x"></i> 
				@if(!is_null(Auth::user()->facebook_user))
				<span style="vertical-align: super"> Conectado como: {{Auth::user()->facebook_user}}</span>
				@endif
			</a>
			{!! Form::close() !!}
		</div>
		<div class="col-lg-12">
			<h2 style="border-top: 3px solid black; border-bottom: 3px solid black; padding: 5px">
				{{$partido->equipo_local->nombre}} 
				{{$partido->goles_local}} - {{$partido->goles_visita}} 
				@if(!is_null($partido->descripcion_penales)) ({{$partido->descripcion_penales}}) @endif
				{{$partido->equipo_visita->nombre}} 
				<span style="float: right"> <i class="fa fa-clock-o"></i> {{$partido->tiempo}} </span>
			</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4">
	        @if($equipoId == $partido->equipo_local_id || $equipoId == 0)
	        	<input type="radio" name="equipo" checked="checked" id="rb_equipo_local" style="transform: scale(1.5);" 
	        					value="{{$partido->equipo_local->id}}" />&nbsp;&nbsp;
	        	<label for="rb_equipo_local">{{$partido->equipo_local->nombre}}</label>&nbsp;&nbsp;&nbsp;&nbsp;
	        	<input type="radio" name="equipo" id="rb_equipo_visita" style="transform: scale(1.5);" 
	        					value="{{$partido->equipo_visita->id}}" />&nbsp;&nbsp;
	        	<label for="rb_equipo_visita">{{$partido->equipo_visita->nombre}}</label>
	        @else
				<input type="radio" name="equipo" id="rb_equipo_local" style="transform: scale(1.5);" 
	        					value="{{$partido->equipo_local->id}}" />&nbsp;&nbsp;
	        	<label for="rb_equipo_local">{{$partido->equipo_local->nombre}}</label>&nbsp;&nbsp;&nbsp;&nbsp;
	        	<input type="radio" name="equipo" checked="checked"  id="rb_equipo_visita" style="transform: scale(1.5);" 
	        					value="{{$partido->equipo_visita->id}}" />&nbsp;&nbsp;
	        	<label for="rb_equipo_visita">{{$partido->equipo_visita->nombre}}</label>
	        @endif
		</div>
	</div>
	<br/>
	<div class="row">
	@foreach($eventos as $evento)
		<div class="col-lg-3" style="margin-bottom: 5px">
			@if($evento->id != 8 && $evento->id != 20 && $evento->id != 21)
				@if($equipoId == $partido->equipo_local_id || $equipoId == 0)
					<a href="{{route($evento->ruta_agregar,[$partido->id,$evento->id,$partido->equipo_local_id])}}" 
						class="btn bg-navy btn-flat evento"
						rutalocal="{{route($evento->ruta_agregar,[$partido->id,$evento->id,$partido->equipo_local_id])}}"
						rutaVisita="{{route($evento->ruta_agregar,[$partido->id,$evento->id,$partido->equipo_visita_id])}}">{{$evento->nombre}}</a>
				
				@else
					<a href="{{route($evento->ruta_agregar,[$partido->id,$evento->id,$partido->equipo_visita_id])}}" 
						class="btn bg-navy btn-flat evento"
						rutalocal="{{route($evento->ruta_agregar,[$partido->id,$evento->id,$partido->equipo_local_id])}}"
						rutaVisita="{{route($evento->ruta_agregar,[$partido->id,$evento->id,$partido->equipo_visita_id])}}">{{$evento->nombre}}</a>
				@endif

			@endif
		</div>
	@endforeach
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-12">
			<a href="{{route('eventos_partido',$partido->id)}}" class="btn btn-warning btn-flat">Editar Eventos</a>	
			<a href="{{route('modificar_partido',$partido->id)}}" class="btn btn-warning btn-flat">Modificar Resultado</a>
			<a href="{{route('editar_minutos_jugados',[$partido->id,$partido->equipo_local_id])}}" class="btn btn-warning btn-flat evento"
				rutalocal="{{route('editar_minutos_jugados',[$partido->id,$partido->equipo_local_id])}}"
				rutaVisita="{{route('editar_minutos_jugados',[$partido->id,$partido->equipo_visita_id])}}">Editar Minutos Jugados</a>
		</div>		
	</div>
	@endif

@stop
@section('js')

<script>
	
	$(function(){

		var equipoId = 0;

		$('#rb_equipo_local').on('click',function()
		{
			equipoId = $(this).val();
			$('a.evento').each(function(){
				$(this).attr("href",$(this).attr('rutalocal'));
			});
		});

		$('#rb_equipo_visita').on('click',function()
		{
			equipoId = $(this).val();
			$('a.evento').each(function(){
				$(this).attr("href",$(this).attr('rutavisita'));
			});
		});

		$('select').on('change', function()
		{
			var ligaId = $('#ligaId').val();
			var campeonatoId = $('#campeonatoId').val();
			var jornadaId = $('#jornadaId').val();
			var partidoId = $('#partidoId').val();

			if(ligaId == '') ligaId = 0;
			if(campeonatoId == '') campeonatoId = 0;
			if(jornadaId == '') jornadaId = 0;
			if(partidoId == '') partidoId = 0;

			var ruta = "{{route('inicio')}}/monitorear-jornada/" + ligaId + "/" + campeonatoId + "/" + jornadaId + "/" + partidoId + "/" + equipoId;
			window.location.href = ruta;

		});

	})

</script>

@stop