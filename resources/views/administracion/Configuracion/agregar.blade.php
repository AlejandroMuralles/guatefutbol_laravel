@extends('layouts.admin')

@section('title') Agregar Configuración @stop

@section('content')

	{!! Form::open(['route' => 'agregar_configuracion', 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	
		{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
		{!! Field::text('parametro1', null, ['data-required'=> 'true']) !!}
		{!! Field::text('parametro2', null, ['data-required'=> 'true']) !!}
		{!! Field::text('parametro3', null, ['data-required'=> 'true']) !!}

		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('configuraciones') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop