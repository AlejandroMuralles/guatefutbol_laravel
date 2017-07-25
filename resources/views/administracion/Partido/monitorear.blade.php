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
		<div class="col-lg-12">
		<a href="{!!URL::to('facebook')!!}" class="btn btn-primary" >
			<i class="fa fa-facebook fa-2x"></i> 
			@if(!is_null(Auth::user()->facebook_user))
			<span style="vertical-align: super"> Conectado como: {{Auth::user()->facebook_user}}</span>
			@endif
		</a>
		</div>
		<div class="col-lg-12">
			<h2 style="border-top: 3px solid black; border-bottom: 3px solid black; padding: 5px">
				{{$partido->equipoLocal->nombre}} 
				{{$partido->goles_local}} - {{$partido->goles_visita}} 
				@if(!is_null($partido->descripcion_penales)) ({{$partido->descripcion_penales}}) @endif
				{{$partido->equipoVisita->nombre}} 
			</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4">
	        <input type="radio" name="equipo" checked="checked" id="rb_equipo_local" style="transform: scale(1.5);" 
	        					value="{{$partido->equipoLocal->id}}" />&nbsp;&nbsp;
	        <label for="rb_equipo_local">{{$partido->equipoLocal->nombre}}</label>&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="radio" name="equipo" id="rb_equipo_visita" style="transform: scale(1.5);" 
	        					value="{{$partido->equipoVisita->id}}" />&nbsp;&nbsp;
	        <label for="rb_equipo_visita">{{$partido->equipoVisita->nombre}}</label>
			<!--<select class="form-control" id="equipo">
				<option value="{{$partido->equipoLocal->id}}">{{$partido->equipoLocal->nombre}}</option>
				<option value="{{$partido->equipoVisita->id}}">{{$partido->equipoVisita->nombre}}</option>
			</select>-->
		</div>
	</div>
	<br/>
	<div class="row">
	@foreach($eventos as $evento)
		<div class="col-lg-3" style="margin-bottom: 5px">
			@if($evento->id != 8 && $evento->id != 20 && $evento->id != 21)
			<a href="{{route($evento->ruta,[$partido->id,$evento->id,$partido->equipo_local_id])}}" 
				class="btn bg-navy btn-flat evento"
				rutalocal="{{route($evento->ruta,[$partido->id,$evento->id,$partido->equipo_local_id])}}"
				rutaVisita="{{route($evento->ruta,[$partido->id,$evento->id,$partido->equipo_visita_id])}}">{{$evento->nombre}}</a>
			@endif
		</div>
	@endforeach
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-12">
			<a href="{{route('eventos_partido',$partido->id)}}" class="btn btn-warning btn-flat">Editar Eventos</a>	
			<a href="{{route('modificar_partido',$partido->id)}}" class="btn btn-warning btn-flat">Modificar Resultado</a>
		</div>		
	</div>

@stop
@section('js')

<script>
	
	$(function(){

		$('#rb_equipo_local').on('click',function()
		{
			$('a.evento').each(function(){
				$(this).attr("href",$(this).attr('rutalocal'));
			});
		});

		$('#rb_equipo_visita').on('click',function()
		{
			$('a.evento').each(function(){
				$(this).attr("href",$(this).attr('rutavisita'));
			});
		});

	})

</script>

@stop