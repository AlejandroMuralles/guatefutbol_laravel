@extends('layouts.admin')

@section('title') Editar Evento {{$evento->evento->nombre}} - {{$equipo->nombre}} @stop

@section('content')

	{!! Form::model($evento,['route' => array('editar_evento_persona',$evento->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('minuto') !!}
		{!! Field::select('jugador1_id',$jugadores) !!}


		@if($evento->id == 9)
			{!! Field::select('jugador2_id',$jugadores) !!}
		@endif

		@if($evento->evento->id == 11)
			{!! Field::checkbox('doble_amarilla') !!}
		@endif


		{!! Field::textarea('comentario') !!}

		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{route('eventos_partido',$evento->partido_id)}}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop