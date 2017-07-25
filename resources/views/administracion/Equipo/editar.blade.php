@extends('layouts.admin')

@section('title') Editar Equipo @stop

@section('content')

	{!! Form::model($equipo, ['route' => array('editar_equipo', $equipo->id), 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form','files'=>'true']) !!}
	
		{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
		{!! Field::text('nombre_corto', null, ['data-required'=> 'true']) !!}
		{!! Field::text('siglas', null, ['data-required'=> 'true']) !!}
		{!! Field::file('logo') !!}
		{!! Field::select('estado', $estados, null, ['data-required'=> 'true']) !!}

		<br/>

        <p>
            <input type="submit" value="Editar" class="btn btn-primary btn-flat">
            <a href="{{ route('equipos') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>

	{!! Form::close() !!}

@stop