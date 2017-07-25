@extends('layouts.admin')

@section('title') Agregar Equipo @stop

@section('content')

	{!! Form::open(['route' => 'agregar_equipo', 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	
		{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
		{!! Field::text('nombre_corto', null, ['data-required'=> 'true']) !!}
		{!! Field::text('siglas', null, ['data-required'=> 'true']) !!}
		{!! Field::file('logo') !!}

		<br/>

        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('equipos') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop