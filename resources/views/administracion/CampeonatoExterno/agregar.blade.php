@extends('layouts.admin')
@section('title') Agregar Campeonato Externo @stop
@section('content')
	{!! Form::open(['route' => 'agregar_campeonato_externo', 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
		{!! Field::text('nombre_liga', null, ['data-required'=> 'true']) !!}
		{!! Field::text('nombre', null, ['data-required'=> 'true']) !!}
		{!! Field::text('link', null, ['data-required'=> 'true']) !!}
		<br/>
        <p>
            <input type="submit" value="Agregar" class="btn btn-primary btn-flat">
            <a href="{{ route('campeonatos_externos') }}" class="btn btn-danger btn-flat">Cancelar</a>
        </p>
	{!! Form::close() !!}
@stop