@extends('layouts.admin')

@section('title') Editar Evento {{$evento->evento->nombre}} @stop

@section('content')

	{!! Form::model($evento, ['route' => array('editar_evento_partido',$evento->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('minuto') !!}

		{!! Field::textarea('comentario') !!}

		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{route('eventos_partido',$evento->partido_id)}}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop